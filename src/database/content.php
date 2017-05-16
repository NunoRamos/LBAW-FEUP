<?php

function getQuestion($questionId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM "Content", "Question" WHERE "id" = ? AND "contentId" = "Content".id');
    $stmt->execute([$questionId]);
    return $stmt->fetch();
}

function getDescendantsOfContent($contentId, $level = 1)
{
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM "Content", "Reply" WHERE "id" = "contentId" AND "parentId" = ?');
    $stmt->execute([$contentId]);
    $descendants = $stmt->fetchAll();
    foreach ($descendants as $key => $descendant) {
        $descendants[$key]["indentation"] = $level;
        $descendants[$key]["children"] = getDescendantsOfContent($descendant['contentId'], $level + 1);
    }
    return $descendants;
}

function getContentOwnerId($contentId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "creatorId" FROM "Content" WHERE "Content"."id" = ?');
    $stmt->execute([$contentId]);
    return $stmt->fetch()['creatorId'];
}

function getMostRecentQuestions($limit,$userId)
{
    global $conn;
    //$stmt = $conn->prepare('SELECT * FROM "Content", "Question" WHERE "contentId" = "Content".id ORDER BY "creationDate" DESC LIMIT ?');

    $stmt = $conn->prepare('
    SELECT "questions"."id","questions"."text","questions"."creatorId", "questions"."rating", "questions"."title", "questions"."creationDate","Vote"."positive"
 FROM (SELECT * FROM "Content", "Question" WHERE "contentId" = "Content".id) AS "questions"
 LEFT JOIN "Vote" ON "questions"."id" = "Vote"."contentId" AND "Vote"."userId" = ?
ORDER BY "questions"."creationDate" DESC
LIMIT ?');
    
    $stmt->execute([$userId,$limit]);
    return $stmt->fetchAll();
}

function canDeleteContent($userId, $contentId)
{
    if (isset($userId) && isset($contentId)) {
        if (canDeleteOwnContent($userId) && getContentOwnerId($contentId) === $userId)
            return true;
        else if (canDeleteAnyContent($userId))
            return true;
        else
            return false;
    }

    return false;
}

function createQuestion($creatorId, $creationDate, $text, $title, $tags)
{
    global $conn;
    try {
        $conn->query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
        $conn->beginTransaction();

        $stmt = $conn->prepare('INSERT INTO "Content" ("creatorId", "creationDate", "text") VALUES(?, ?, ?) RETURNING id');
        $stmt->execute([$creatorId, $creationDate, $text]);
        $contentId = $stmt->fetch()["id"];

        $stmt = $conn->prepare('INSERT INTO "Question"("contentId", "title") VALUES(?, ?)');
        $stmt->execute([$contentId, $title]);

        $stmt = $conn->prepare('INSERT INTO "QuestionTags"("contentId", "tagId")
                                            SELECT * FROM (SELECT ?::INTEGER) AS content_id, unnest(?::INTEGER[]) AS unnest');
        $stmt->execute([$contentId, "{" . join(",", $tags) . "}"]);

        $conn->commit();
        return $contentId;
    } catch (PDOException $exception) {
        $conn->rollBack();
        throw $exception;
    }
}

function editQuestion($contentId, $text, $title, $tags)
{
    //FIXME: untested
    global $conn;

    try {
        $conn->query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
        $conn->beginTransaction();

        $stmt = $conn->prepare('UPDATE "Content" SET "text" = ? WHERE "id" = ?');
        $stmt->execute([$text, $contentId]);


        $stmt = $conn->prepare('UPDATE "Question" SET "title" = ? WHERE "contentId" = ?');
        $stmt->execute([$title, $contentId]);

        $stmt = $conn->prepare('DELETE FROM "QuestionTags" WHERE "contentId" = ? AND "tagId" NOT IN(SELECT * FROM unnest(?::INTEGER[]) AS unnest)');
        $stmt->execute([$contentId, $tags]);

        $stmt = $conn->prepare('INSERT INTO "QuestionTags" SELECT * FROM(SELECT ?) AS content_id, unnest(?::INTEGER[]) AS unnest WHERE unnest NOT IN(SELECT "tagId" FROM "QuestionTags" WHERE "contentId" = ?)');
        $stmt->execute([$contentId, $tags, $contentId]);

    } catch (PDOException $exception) {
        $conn->rollBack();
        throw $exception;
    }
}

function createReply($creatorId, $creationDate, $text, $parentId, $questionId)
{
    global $conn;
    try {
        $conn->query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
        $conn->beginTransaction();

        $stmt = $conn->prepare('INSERT INTO "Content" ("creatorId", "creationDate", "text") VALUES(?, ?, ?) RETURNING id');
        $stmt->execute([$creatorId, $creationDate, $text]);
        $contentId = $stmt->fetch()["id"];

        $stmt = $conn->prepare('INSERT INTO "Reply"("contentId", "parentId", "questionId") VALUES(?, ?, ?)');
        $stmt->execute([$contentId, $parentId, $questionId]);

        $conn->commit();
        return $contentId;
    } catch (PDOException $exception) {
        $conn->rollBack();
        throw $exception;
    }
}

function getAllTags()
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "Tag"');
    $stmt->execute();
    return $stmt->fetchAll();
}

function getQuestionHierarchy($questionId)
{
    $question = getQuestion($questionId);
    $question->children = getDescendantsOfContent($question);
    return $question;
}

function getContentById($id)
{
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM "Content", "Question" WHERE "id" = "contentId" AND "id" = ?');
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function searchQuestions($inputString, $tags, $orderBy, $resultsPerPage, $resultOffset)
{
    global $conn;
    $textLanguage = "'english'";
    $sortingMethod = 'ts_rank_cd(search_vector, search_query)';
    $sortingOrder = 'DESC';

    switch ($orderBy) {
        case Order::RATING_ASC:
            $sortingMethod = 'rating';
            $sortingOrder = 'ASC';
            break;
        case Order::RATING_DESC:
            $sortingMethod = 'rating';
            $sortingOrder = 'DESC';
            break;
        case Order::NUM_REPLIES_ASC:
            $sortingMethod = '"numReplies"';
            $sortingOrder = 'ASC';
            break;
        case Order::NUM_REPLIES_DESC:
            $sortingMethod = '"numReplies"';
            $sortingOrder = 'DESC';
            break;
    }

    $tags = '{' . implode(",", $tags) . '}';

    try {
        $conn->beginTransaction();

        $countStmt = $conn->prepare('
        WITH selected_tags AS (SELECT * FROM unnest(?::INTEGER[]) AS "tagId")
        
        SELECT COUNT(*)
            FROM "Content", "Question", "User", 
                plainto_tsquery(' . $textLanguage . ',?) AS search_query,
                to_tsvector(' . $textLanguage . ', concat_ws(\' \', "title", "text")) AS search_vector
            WHERE "contentId" = "Content"."id" AND "creatorId" = "User"."id" AND search_vector @@ search_query AND 
                (NOT EXISTS(SELECT * FROM selected_tags) 
                OR
                EXISTS(
                    SELECT selected_tags."tagId"
                        FROM "QuestionTags", selected_tags 
                        WHERE "QuestionTags"."contentId" = "Content"."id" AND "QuestionTags"."tagId" = selected_tags."tagId"))');
        $countStmt->execute([$tags, $inputString]);


        $searchStmt = $conn->prepare('
        WITH selected_tags AS (SELECT * FROM unnest(?::INTEGER[]) AS "tagId")
        
        SELECT "Content"."id", "rating", "title", "creatorId",  "creationDate", "numReplies", "User"."name" AS "creatorName"
            FROM "Content", "Question", "User", 
                plainto_tsquery(' . $textLanguage . ',?) AS search_query,
                to_tsvector(' . $textLanguage . ', concat_ws(\' \', "title", "text")) AS search_vector
            WHERE "contentId" = "Content"."id" AND "creatorId" = "User"."id" AND search_vector @@ search_query AND 
                (NOT EXISTS(SELECT * FROM selected_tags) 
                OR
                EXISTS(
                    SELECT selected_tags."tagId"
                        FROM "QuestionTags", selected_tags 
                        WHERE "QuestionTags"."contentId" = "Content"."id" AND "QuestionTags"."tagId" = selected_tags."tagId"))
            ORDER BY ' . $sortingMethod . ' ' . $sortingOrder . ' LIMIT ? OFFSET ?');

        $searchStmt->execute([$tags, $inputString, $resultsPerPage, $resultOffset]);
        $conn->commit();

        return ["numResults" => $countStmt->fetchAll()[0]['count'], "results" => $searchStmt->fetchAll()];
    } catch (PDOException $exception) {
        $conn->rollBack();
        throw $exception;
    }
}

function vote($userId, $contentId, $vote)
{
    global $conn;

    if($vote == -1){
        $stmt = $conn->prepare('DELETE FROM "Vote" WHERE "contentId" = ? AND "userId" = ?');
        $stmt->execute([$contentId, $userId]);
    }
    else{
        try{
            $stmt = $conn->prepare('INSERT INTO "Vote" ("userId","contentId","positive") VALUES (?,?,?)');
            $stmt->execute([$userId, $contentId, $vote]);
        }catch (PDOException $e){
            $stmt = $conn->prepare('UPDATE "Vote" SET "positive" = ? WHERE "contentId" = ? AND "userId" = ?');
            $stmt->execute([$vote, $contentId, $userId]);
        }
    }

}

function getVoteTarget($voteId)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "Vote" WHERE "id" = ?');
    $stmt->execute([$voteId]);
    return $stmt->fetchAll();
}

function getTagsId($tags)
{
    global $conn;

    $tags = '{' . implode(",", $tags) . '}';

    $stmt = $conn->prepare('
      SELECT "id" FROM "Tag", unnest(?::TEXT[]) AS "tag" 
      WHERE "Tag"."name" = "tag"');
    $stmt->execute([$tags]);

    $result = $stmt->fetchAll();
    $return = [];
    foreach ($result as $value) {
        array_push($return, $value['id']);
    }

    return $return;
}

function stripProhibitedTags($text)
{
    /*FIXME: remove <strike> tag once this issue is fixed
    * https://github.com/Alex-D/Trumbowyg/issues/544 */
    return strip_tags($text, '<p><a><strong><em><strike><s><br><sub><sup><img><ul><ol><li>');
}

function getQuestionFromReply($replyId)
{
    global $conn;

    $stmt = $conn->prepare('
        SELECT * FROM "Reply", "Content", "Question" 
          WHERE "Reply"."contentId" = ? AND "Content".id = "Reply"."questionId" AND "Question"."contentId" = "Content"."id"
          ');

    $stmt->execute([$replyId]);
    return $stmt->fetch();
}

/** If the id received is from a question, then return its information.
 * Otherwise, get the information as if it were a reply, and return it. */
function getQuestionFromContent($contentId)
{
    $question = getQuestion($contentId);

    return ($question !== false)
        ? $question
        : getQuestionFromReply($contentId);
}

function readNotifications($questionId)
{
    global $conn;

    $stmt = $conn->prepare('
      UPDATE "Notification" SET "read" = TRUE 
        FROM "Reply", "Vote", "Question"
        WHERE 
          (("Reply"."contentId" = "Notification"."contentId" AND "Reply"."questionId" = ?) OR "Notification"."contentId" = ?)
          OR 
          ("Vote"."id" = "Notification"."voteId" AND 
            (("Reply"."contentId" = "Vote"."contentId" AND "Reply"."questionId" = ?) OR "Question"."contentId" = ?))
          ');

    $stmt->execute([$questionId, $questionId, $questionId, $questionId]);
}