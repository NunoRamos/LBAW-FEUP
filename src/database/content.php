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

function getMostRecentQuestions($limit)
{
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM "Content", "Question" WHERE "contentId" = "Content".id ORDER BY "creationDate" DESC LIMIT ?');
    $stmt->execute([$limit]);
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
                                            SELECT * FROM (SELECT ?::integer) AS content_id, unnest(?::integer[]) AS unnest');
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

function createReply($creatorId, $creationDate, $text, $parentId, $topContentId)
{
    global $conn;
    try {
        $conn->query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
        $conn->beginTransaction();

        $stmt = $conn->prepare('INSERT INTO "Content" ("creatorId", "creationDate", "text") VALUES(?, ?, ?) RETURNING id');
        $stmt->execute([$creatorId, $creationDate, $text]);
        $contentId = $stmt->fetch()["id"];

        $stmt = $conn->prepare('INSERT INTO "Reply"("contentId", "parentId", "topContentId") VALUES(?, ?, ?)');
        $stmt->execute([$contentId, $parentId, $topContentId]);

        $conn->commit();
        return $contentId;
    } catch (PDOException $exception) {
        $conn->rollBack();
        throw $exception;
    }

    return $contentId;
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

function getSimilarQuestions($inputString,$thisPageFirstResult,$resultsPerPage){
    global $conn;

    $stmt = $conn->prepare('
    SELECT "id", "rating", "title", "creatorId", "creationDate"
    FROM "Content","Question", 
        to_tsvector(\'english\',text) text_search, to_tsquery(\'english\',?) text_query,
        to_tsvector(\'english\',title) title_search, to_tsquery(\'english\',?) title_query
    WHERE "contentId" = id AND (text_search @@ text_query OR title_search @@ title_query)
    ORDER BY ts_rank_cd(text_search, text_query) DESC
    LIMIT ? OFFSET ?');

    $stmt->execute([$inputString,$inputString,$resultsPerPage,$thisPageFirstResult]);
    return $stmt->fetchAll();
}

function getNumberOfSimilarQuestions($inputString){
    global $conn;

    $stmt = $conn->prepare('
    SELECT "id" 
    FROM "Content","Question", 
        to_tsvector(\'english\',text) text_search, to_tsquery(\'english\',?) text_query,
        to_tsvector(\'english\',title) title_search, to_tsquery(\'english\',?) title_query
    WHERE "contentId" = id AND (text_search @@ text_query OR title_search @@ title_query)
    ORDER BY ts_rank_cd(text_search, text_query) DESC');

    $stmt->execute([$inputString,$inputString]);
    return sizeof($stmt->fetchAll());
}

function getQuestionByString($inputString)
{
    global $conn;

    $expression = '%' . $inputString . '%';

    $stmt = $conn->prepare('SELECT "id", "rating", "title", "creatorId", "creationDate"
    FROM "Content","Question" WHERE "contentId" = id AND "title" LIKE ?');
    $stmt->execute([$expression]);

    return $stmt->fetchAll();

}

function addVote($userId,$contentId,$vote){
    global $conn;


    $stmt = $conn->prepare('INSERT INTO "Vote" ("userId","contentId","positive") VALUES (?,?,?)');
    $stmt->execute([$userId,$contentId,$vote]);
}