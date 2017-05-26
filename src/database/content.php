<?php

function getQuestion($questionId, $userId)
{
    global $conn;

    if (!isset($userId))
        $userId = 0;

    $stmt = $conn->prepare('SELECT "question"."id","question"."creatorId","question"."creationDate","question"."text","question"."rating","question"."contentId","question"."title","question"."closed","question"."numReplies","Vote"."positive"
 FROM (SELECT * FROM "Content", "Question" WHERE "id" = ? AND "contentId" = "Content".id) AS "question"
 LEFT JOIN "Vote" ON "question"."id" = "Vote"."contentId" AND "Vote"."userId" = ?;
');
    $stmt->execute([$questionId, $userId]);

    return $stmt->fetch();
}

function getDescendantsOfContent($contentId, $userId, $level = 1)
{
    global $conn;

    if (!isset($userId))
        $userId = 0;

    $stmt = $conn->prepare('SELECT "replies"."id", "replies"."creatorId", "replies"."creationDate", "replies"."text", "replies"."rating", "replies"."contentId", "replies"."parentId",	"replies"."questionId", "replies"."deleted", "Vote"."positive"
 FROM (SELECT * FROM "Content", "Reply" WHERE "id" = "contentId" AND "parentId" = ?) AS "replies"
 LEFT JOIN "Vote" ON "replies"."id" = "Vote"."contentId" AND "Vote"."userId" = ?;');
    $stmt->execute([$contentId, $userId]);

    $descendants = $stmt->fetchAll();
    foreach ($descendants as $key => $descendant) {
        $descendants[$key]["indentation"] = $level;
        $descendants[$key]["children"] = getDescendantsOfContent($descendant['contentId'], $userId, $level + 1);
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

function getMostRecentQuestions($limit, $userId)
{
    global $conn;
    //$stmt = $conn->prepare('SELECT * FROM "Content", "Question" WHERE "contentId" = "Content".id ORDER BY "creationDate" DESC LIMIT ?');

    $stmt = $conn->prepare('
    SELECT "questions"."id","questions"."text","questions"."creatorId", "questions"."rating", "questions"."title", "questions"."creationDate","Vote"."positive"
 FROM (SELECT * FROM "Content", "Question" WHERE "contentId" = "Content".id) AS "questions"
 LEFT JOIN "Vote" ON "questions"."id" = "Vote"."contentId" AND "Vote"."userId" = ?
ORDER BY "questions"."creationDate" DESC
LIMIT ?');

    $stmt->execute([$userId, $limit]);
    return $stmt->fetchAll();
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
function getAllBannedUsers()
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "BannedUser"');
    $stmt->execute();
    return $stmt->fetchAll();
}

function getAllPendingTags()
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "PendingTag"');
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

function searchQuestions($inputString, $tags, $order, $resultsPerPage, $resultOffset, $userId)
{
    global $conn;
    $textLanguage = 'english';
    $orderBy = 'ts_rank_cd(search_vector, search_query)';

    if (!isset($userId))
        $userId = 0;

    switch ($order) {
        case QuestionSearchOrder::RATING_ASC:
            $orderBy = 'rating ASC';
            break;
        case QuestionSearchOrder::RATING_DESC:
            $orderBy = 'rating DESC';
            break;
        case QuestionSearchOrder::NUM_REPLIES_ASC:
            $orderBy = '"numReplies" ASC';
            break;
        case QuestionSearchOrder::NUM_REPLIES_DESC:
            $orderBy = '"numReplies" DESC';
            break;
    }

    $tags = '{' . implode(",", $tags) . '}';

    try {
        $conn->beginTransaction();

        $countStmt = $conn->prepare('
        WITH selected_tags AS (SELECT * FROM unnest(?::INTEGER[]) AS "tagId")
        
        SELECT COUNT(*)
            FROM "Content", "Question", "User", 
                plainto_tsquery(? ,?) AS search_query,
                to_tsvector(?, concat_ws(\' \', "title", "text")) AS search_vector
            WHERE "contentId" = "Content"."id" AND "creatorId" = "User"."id" AND search_vector @@ search_query AND 
                (NOT EXISTS(SELECT * FROM selected_tags) 
                OR
                EXISTS(
                    SELECT selected_tags."tagId"
                        FROM "QuestionTags", selected_tags 
                        WHERE "QuestionTags"."contentId" = "Content"."id" AND "QuestionTags"."tagId" = selected_tags."tagId"))');
        $countStmt->execute([$tags, $textLanguage, $inputString, $textLanguage]);

        $searchStmt = $conn->prepare('
        WITH selected_tags AS (SELECT * FROM unnest(?::INTEGER[]) AS "tagId")
        
        SELECT "search"."id", "rating", "title", "creatorId",  "creationDate", "numReplies", "creatorName", "positive"
        FROM
            (SELECT "Content"."id", "rating", "title", "creatorId",  "creationDate", "numReplies", "User"."name" AS "creatorName"
                FROM "Content", "Question", "User", 
                    plainto_tsquery(?, ?) AS search_query,
                    to_tsvector(?, concat_ws(\' \', "title", "text")) AS search_vector
                WHERE "contentId" = "Content"."id" AND "creatorId" = "User"."id" AND search_vector @@ search_query AND 
                    (NOT EXISTS(SELECT * FROM selected_tags) 
                    OR
                    EXISTS(
                        SELECT selected_tags."tagId"
                            FROM "QuestionTags", selected_tags 
                            WHERE "QuestionTags"."contentId" = "Content"."id" AND "QuestionTags"."tagId" = selected_tags."tagId"))) AS "search"
            LEFT JOIN "Vote" ON "search"."id" = "Vote"."contentId" AND "Vote"."userId" = ?
            ORDER BY ? LIMIT ? OFFSET ?');

        $searchStmt->execute([$tags, $textLanguage, $inputString, $textLanguage, $userId, $orderBy, $resultsPerPage, $resultOffset]);
        $conn->commit();

        return ['questions' => $searchStmt->fetchAll(), 'numResults' => $countStmt->fetchColumn(0)];
    } catch (PDOException $exception) {
        $conn->rollBack();
        throw $exception;
    }
}

function removeVote($userId, $contentId)
{
    global $conn;

    $stmt = $conn->prepare('DELETE FROM "Vote" WHERE "contentId" = ? AND "userId" = ?');
    $stmt->execute([$contentId, $userId]);
}

function vote($userId, $contentId, $isPositive)
{
    global $conn;

    try {
        $stmt = $conn->prepare('INSERT INTO "Vote" ("userId","contentId","positive") VALUES (?,?,?)');
        $stmt->execute([$userId, $contentId, $isPositive]);
    } catch (PDOException $e) {
        $stmt = $conn->prepare('UPDATE "Vote" SET "positive" = ? WHERE "contentId" = ? AND "userId" = ?');
        $stmt->execute([$isPositive, $contentId, $userId]);
    }

}

function getVoteTarget($voteId)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "Vote" WHERE "Vote"."id" = ?');
    $stmt->execute([$voteId]);
    return $stmt->fetch();
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
function getQuestionFromContent($contentId, $userId)
{
    $question = getQuestion($contentId, $userId);

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



function editName($id, $name)
{
    //FIXME: untested
    global $conn;

    try {
       // $conn->query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
        //$conn->beginTransaction();

        $stmt = $conn->prepare('UPDATE "User" SET "name" = ? WHERE "id" = ?;');
        $stmt->execute([$name, $id]);
        //$conn->commit();

    } catch (PDOException $exception) {
        //$conn->rollBack();
        {
            echo $stmt . "<br>" . $exception->getMessage();
        }

        //$conn = null;
    }
}

function editBio($id, $bio)
{
    //FIXME: untested
    global $conn;

    try {
        // $conn->query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
        //$conn->beginTransaction();

        $stmt = $conn->prepare('UPDATE "User" SET "bio" = ? WHERE "id" = ?;');
        $stmt->execute([$bio, $id]);
        //$conn->commit();

    } catch (PDOException $exception) {
        //$conn->rollBack();
        {
            echo $stmt . "<br>" . $exception->getMessage();
        }

        //$conn = null;
    }
}

function editPhoto($id, $photo)
{
    //FIXME: untested
    global $conn;

    try {
        // $conn->query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
        //$conn->beginTransaction();

        $stmt = $conn->prepare('UPDATE "User" SET "photo" = ? WHERE "id" = ?;');
        $stmt->execute([$photo, $id]);
        //$conn->commit();

    } catch (PDOException $exception) {
        //$conn->rollBack();
        {
            echo $stmt . "<br>" . $exception->getMessage();
        }

        //$conn = null;
    }
}

function editEmail($id, $email)
{
    //FIXME: untested
    global $conn;

    try {
        // $conn->query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
        //$conn->beginTransaction();

        $stmt = $conn->prepare('UPDATE "User" SET "email" = ? WHERE "id" = ?;');
        $stmt->execute([$email, $id]);
        //$conn->commit();

    } catch (PDOException $exception) {
        //$conn->rollBack();
        {
            echo $stmt . "<br>" . $exception->getMessage();
        }

        //$conn = null;
    }
}


function deleteQuestion($questionId)
{
    global $conn;

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare('DELETE FROM "QuestionTags" WHERE "contentId" = ?');
        $stmt->execute([$questionId]);
        $stmt = $conn->prepare('DELETE FROM "Reply" WHERE "questionId" = ?');
        $stmt->execute([$questionId]);
        $stmt = $conn->prepare('DELETE FROM "Question" WHERE "contentId" = ?');
        $stmt->execute([$questionId]);
        $stmt = $conn->prepare('DELETE FROM "Content" WHERE "id" = ?');
        $stmt->execute([$questionId]);

        $conn->commit();
    } catch (PDOException $exception) {
        $conn->rollBack();
        throw $exception;
    }
}

function deleteReply($replyId)
{
    global $conn;

    $stmt = $conn->prepare('UPDATE "Reply" SET "deleted" = TRUE WHERE "contentId" = ?');
    $stmt->execute([$replyId]);
}

function deletePendingTag($tagId)
{
    global $conn;

    $stmt = $conn->prepare('DELETE FROM "PendingTag" WHERE "id" = ?');
    $stmt->execute([$tagId]);
}

function getPendingTagNameById($id)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "name" FROM "PendingTag" WHERE "id" = ?');
    $stmt->execute([$id]);
    $return = $stmt->fetch();
    return $return['name'];
}

function addTagFromPendingTag($tagId)
{
    global $conn;
    $name = getPendingTagNameById($tagId);
    try {
        $conn->beginTransaction();

       $stmt = $conn->prepare('DELETE FROM "PendingTag" WHERE "id" = ?');
       $stmt->execute([$tagId]);
       $stmt = $conn->prepare('INSERT INTO "Tag"("name") VALUES (?)');
       $stmt->execute([$name]);
        $conn->commit();
    } catch (PDOException $exception) {
        $conn->rollBack();
        throw $exception;
    }
}

function unbanUser($id){

    global $conn;
    $stmt = $conn->prepare('DELETE FROM "BannedUser" WHERE "userId" = ?');
    $stmt->execute([$id]);
}

function isQuestion($contentId)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "Question" WHERE "contentId" = ?');
    $stmt->execute([$contentId]);
    return count($stmt->fetchAll()) > 0;
}

function getVotedUsers($contentId)
{
    global $conn;

    $stmt = $conn->prepare('
    SELECT "User"."id", "email", "name", "photo","positive"
      FROM "Vote", "User"
      WHERE "contentId" = ? AND "userId" = "User"."id";  ');
    $stmt->execute([$contentId]);

    return $stmt->fetchAll();
}

function getQuestionTags($contentId)
{
    global $conn;

    $stmt = $conn->prepare('
    SELECT "id","name" FROM "QuestionTags","Tag"
WHERE "contentId"=? AND "id"="tagId";');
    $stmt->execute([$contentId]);

    return $stmt->fetchAll();
}

function updateContentText($contentId, $text)
{
    global $conn;

    $stmt = $conn->prepare('UPDATE "Content" SET "text" = ? WHERE "id" = ?');
    $stmt->execute([$text, $contentId]);
}
