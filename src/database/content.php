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

function getSimilarQuestions($inputString, $thisPageFirstResult, $resultsPerPage, $tags)
{
    global $conn;

    if(sizeof($tags) == 0){
        $stmt = $conn->prepare('
        SELECT "id", "rating", "title", "creatorId", "creationDate"
        FROM "Content","Question", 
            to_tsvector(\'english\',text) text_search, to_tsquery(\'english\',?) text_query,
            to_tsvector(\'english\',title) title_search, to_tsquery(\'english\',?) title_query
        WHERE "contentId" = id AND (text_search @@ text_query OR title_search @@ title_query)
        ORDER BY ts_rank_cd(text_search, text_query) DESC
        LIMIT ? OFFSET ?');

        $stmt->execute([$inputString, $inputString, $resultsPerPage, $thisPageFirstResult]);
    }
    else {
        $tags = '{'.implode(",",$tags).'}';
        $stmt = $conn->prepare('
    SELECT * 
  FROM (SELECT "id", "rating", "title", "creatorId", "creationDate"
        FROM "Content","Question", 
            to_tsvector(\'english\',text) text_search, to_tsquery(\'english\',?) text_query,
            to_tsvector(\'english\',title) title_search, to_tsquery(\'english\',?) title_query
        WHERE "contentId" = id AND (text_search @@ text_query OR title_search @@ title_query)
        ORDER BY ts_rank_cd(text_search, text_query) DESC) AS "matches"
  WHERE EXISTS 
      (SELECT "tagId"  
        FROM "QuestionTags", unnest(?::INTEGER[]) AS "tag" 
        WHERE "QuestionTags"."contentId" = "matches"."id" AND "tagId" = "tag")
        LIMIT ? OFFSET ?');

        $stmt->execute([$inputString, $inputString, $tags, $resultsPerPage, $thisPageFirstResult]);
    }


    return $stmt->fetchAll();
}

function getSimiliarQuestionByNumberOfAnswers($inputString, $thisPageFirstResult, $resultsPerPage,$orderBy,$tags){
    global $conn;

    if(sizeof($tags) == 0){ //Without tags
        if($orderBy == 1){ //ASC
            $stmt = $conn->prepare('
        SELECT "Content"."id", "rating", "title", "creatorId", "creationDate" FROM 
          (SELECT "Results"."id", COUNT("topContentId") AS "NumberOfAnswers" FROM ( SELECT "id"
            FROM "Content","Question", 
              to_tsvector(\'english\',text) text_search, to_tsquery(\'english\',?) text_query,
              to_tsvector(\'english\',title) title_search, to_tsquery(\'english\',?) title_query
            WHERE "contentId" = id AND (text_search @@ text_query OR title_search @@ title_query)) AS "Results" 
          LEFT JOIN "Reply"
          ON "Results"."id" = "topContentId"
          GROUP BY "Results"."id") AS "Results", "Question", "Content"
        WHERE "Results"."id" = "Question"."contentId" AND "Question"."contentId" = "Content"."id"
        ORDER BY "NumberOfAnswers" ASC
        LIMIT ? OFFSET ?');
        }
        else { //DESC
            $stmt = $conn->prepare('
        SELECT "Content"."id", "rating", "title", "creatorId", "creationDate" FROM 
          (SELECT "Results"."id", COUNT("topContentId") AS "NumberOfAnswers" FROM ( SELECT "id"
            FROM "Content","Question", 
              to_tsvector(\'english\',text) text_search, to_tsquery(\'english\',?) text_query,
              to_tsvector(\'english\',title) title_search, to_tsquery(\'english\',?) title_query
            WHERE "contentId" = id AND (text_search @@ text_query OR title_search @@ title_query)) AS "Results" 
          LEFT JOIN "Reply"
          ON "Results"."id" = "topContentId"
          GROUP BY "Results"."id") AS "Results", "Question", "Content"
        WHERE "Results"."id" = "Question"."contentId" AND "Question"."contentId" = "Content"."id"
        ORDER BY "NumberOfAnswers" DESC
        LIMIT ? OFFSET ?');

        }

        $stmt->execute([$inputString, $inputString , $resultsPerPage, $thisPageFirstResult]);
    }
    else { //With tags
        $tags = '{'.implode(",",$tags).'}';
        if($orderBy == 1){ //ASC
            $stmt = $conn->prepare('
        SELECT "Content"."id", "rating", "title", "creatorId", "creationDate" FROM 
          (SELECT "Results"."id", COUNT("topContentId") AS "NumberOfAnswers" FROM ( SELECT * 
  FROM (SELECT "id", "rating", "title", "creatorId", "creationDate"
        FROM "Content","Question", 
            to_tsvector(\'english\',text) text_search, to_tsquery(\'english\',?) text_query,
            to_tsvector(\'english\',title) title_search, to_tsquery(\'english\',?) title_query
        WHERE "contentId" = id AND (text_search @@ text_query OR title_search @@ title_query)
        ORDER BY ts_rank_cd(text_search, text_query) DESC) AS "matches"
  WHERE EXISTS 
      (SELECT "tagId"  
        FROM "QuestionTags", unnest(?::INTEGER[]) AS "tag" 
        WHERE "QuestionTags"."contentId" = "matches"."id" AND "tagId" = "tag")) AS "Results" 
          LEFT JOIN "Reply"
          ON "Results"."id" = "topContentId"
          GROUP BY "Results"."id") AS "Results", "Question", "Content"
        WHERE "Results"."id" = "Question"."contentId" AND "Question"."contentId" = "Content"."id"
        ORDER BY "NumberOfAnswers" ASC
        LIMIT ? OFFSET ?');
        }
        else { //DESC
            $stmt = $conn->prepare('
        SELECT "Content"."id", "rating", "title", "creatorId", "creationDate" FROM 
          (SELECT "Results"."id", COUNT("topContentId") AS "NumberOfAnswers" FROM ( SELECT * 
  FROM (SELECT "id", "rating", "title", "creatorId", "creationDate"
        FROM "Content","Question", 
            to_tsvector(\'english\',text) text_search, to_tsquery(\'english\',?) text_query,
            to_tsvector(\'english\',title) title_search, to_tsquery(\'english\',?) title_query
        WHERE "contentId" = id AND (text_search @@ text_query OR title_search @@ title_query)
        ORDER BY ts_rank_cd(text_search, text_query) DESC) AS "matches"
  WHERE EXISTS 
      (SELECT "tagId"  
        FROM "QuestionTags", unnest(?::INTEGER[]) AS "tag" 
        WHERE "QuestionTags"."contentId" = "matches"."id" AND "tagId" = "tag")) AS "Results" 
          LEFT JOIN "Reply"
          ON "Results"."id" = "topContentId"
          GROUP BY "Results"."id") AS "Results", "Question", "Content"
        WHERE "Results"."id" = "Question"."contentId" AND "Question"."contentId" = "Content"."id"
        ORDER BY "NumberOfAnswers" DESC
        LIMIT ? OFFSET ?');

        }

        $stmt->execute([$inputString, $inputString , $tags, $resultsPerPage, $thisPageFirstResult]);
    }


    return $stmt->fetchAll();
}

function getSimilarQuestionsOrderedByRating($inputString, $thisPageFirstResult, $resultsPerPage,$orderBy, $tags)
{
    global $conn;

    if(sizeof($tags) == 0){ //Without tags
        if($orderBy == 3){ //ASC
            $stmt = $conn->prepare('
        SELECT "id", "rating", "title", "creatorId", "creationDate"
        FROM "Content","Question", 
            to_tsvector(\'english\',text) text_search, to_tsquery(\'english\',?) text_query,
            to_tsvector(\'english\',title) title_search, to_tsquery(\'english\',?) title_query
        WHERE "contentId" = id AND (text_search @@ text_query OR title_search @@ title_query)
        ORDER BY "rating" ASC
        LIMIT ? OFFSET ?');

        }
        else { //DESC
            $stmt = $conn->prepare('
        SELECT "id", "rating", "title", "creatorId", "creationDate"
        FROM "Content","Question", 
            to_tsvector(\'english\',text) text_search, to_tsquery(\'english\',?) text_query,
            to_tsvector(\'english\',title) title_search, to_tsquery(\'english\',?) title_query
        WHERE "contentId" = id AND (text_search @@ text_query OR title_search @@ title_query)
        ORDER BY "rating" DESC
        LIMIT ? OFFSET ?');

        }
        $stmt->execute([$inputString, $inputString, $resultsPerPage, $thisPageFirstResult]);
    }
    else { //With tags
        $tags = '{'.implode(",",$tags).'}';
        if($orderBy == 3){ //ASC
            $stmt = $conn->prepare('
        SELECT * 
  FROM (SELECT "id", "rating", "title", "creatorId", "creationDate"
        FROM "Content","Question", 
            to_tsvector(\'english\',text) text_search, to_tsquery(\'english\',?) text_query,
            to_tsvector(\'english\',title) title_search, to_tsquery(\'english\',?) title_query
        WHERE "contentId" = id AND (text_search @@ text_query OR title_search @@ title_query)
        ORDER BY ts_rank_cd(text_search, text_query) DESC) AS "matches"
  WHERE EXISTS 
      (SELECT "tagId"  
        FROM "QuestionTags", unnest(?::INTEGER[]) AS "tag" 
        WHERE "QuestionTags"."contentId" = "matches"."id" AND "tagId" = "tag")
        ORDER BY "rating" ASC
        LIMIT ? OFFSET ?');

        }
        else { //DESC
            $stmt = $conn->prepare('
       SELECT * 
  FROM (SELECT "id", "rating", "title", "creatorId", "creationDate"
        FROM "Content","Question", 
            to_tsvector(\'english\',text) text_search, to_tsquery(\'english\',?) text_query,
            to_tsvector(\'english\',title) title_search, to_tsquery(\'english\',?) title_query
        WHERE "contentId" = id AND (text_search @@ text_query OR title_search @@ title_query)
        ORDER BY ts_rank_cd(text_search, text_query) DESC) AS "matches"
  WHERE EXISTS 
      (SELECT "tagId"  
        FROM "QuestionTags", unnest(?::INTEGER[]) AS "tag" 
        WHERE "QuestionTags"."contentId" = "matches"."id" AND "tagId" = "tag")
        ORDER BY "rating" DESC
        LIMIT ? OFFSET ?');

        }
        $stmt->execute([$inputString, $inputString, $tags, $resultsPerPage, $thisPageFirstResult]);
    }

    return $stmt->fetchAll();
}

function getNumberOfSimilarQuestions($inputString,$tags)
{
    global $conn;

    if(sizeof($tags) == 0){
        $stmt = $conn->prepare('
    SELECT COUNT(*)
    FROM "Content","Question", 
        to_tsvector(\'english\',text) text_search, to_tsquery(\'english\',?) text_query,
        to_tsvector(\'english\',title) title_search, to_tsquery(\'english\',?) title_query
    WHERE "contentId" = id AND (text_search @@ text_query OR title_search @@ title_query)');
        $stmt->execute([$inputString, $inputString]);
    }
    else {
        $tags = '{'.implode(",",$tags).'}';
        $stmt = $conn->prepare('
    SELECT COUNT(*)
  FROM (SELECT "id", "rating", "title", "creatorId", "creationDate"
        FROM "Content","Question", 
            to_tsvector(\'english\',text) text_search, to_tsquery(\'english\',?) text_query,
            to_tsvector(\'english\',title) title_search, to_tsquery(\'english\',?) title_query
        WHERE "contentId" = id AND (text_search @@ text_query OR title_search @@ title_query)) AS "matches"
  WHERE EXISTS 
      (SELECT "tagId"  
        FROM "QuestionTags", unnest(?::INTEGER[]) AS "tag" 
        WHERE "QuestionTags"."contentId" = "matches"."id" AND "tagId" = "tag");');
        $stmt->execute([$inputString, $inputString,$tags]);
    }

    return $stmt->fetch();
}

function addVote($userId, $contentId, $vote)
{
    global $conn;

    $stmt = $conn->prepare('INSERT INTO "Vote" ("userId","contentId","positive") VALUES (?,?,?)');
    $stmt->execute([$userId, $contentId, $vote]);
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

    $tags = '{'.implode(",",$tags).'}';

    $stmt = $conn->prepare('
SELECT "id" FROM "Tag", unnest(?::TEXT[]) AS "tag" 
WHERE "Tag"."name" = "tag"');
    $stmt->execute([$tags]);

    $result = $stmt->fetchAll();
    $return = [];
    foreach ($result as $value){
        array_push($return,$value['id']);
    }

    return $return;
}

function searchByTag($tags, $thisPageFirstResult, $resultsPerPage)
{
    global $conn;

    $tags = '{'.implode(",",$tags).'}';

    $stmt = $conn->prepare('
SELECT "id", "rating", "title", "creatorId", "creationDate" FROM "Question","Content",
(SELECT "contentId" FROM "QuestionTags", unnest(?::INTEGER[]) AS "tag"
WHERE "tagId" = "tag") AS "results"
WHERE "Question"."contentId" = "Content"."id" AND "results"."contentId" = "Content"."id"
LIMIT ? OFFSET ?');

    $stmt->execute([$tags,$resultsPerPage,$thisPageFirstResult]);

    return $stmt->fetchAll();
}

function searchByTagOrderedByRating($tags, $thisPageFirstResult, $resultsPerPage, $orderBy)
{
    global $conn;

    $tags = '{'.implode(",",$tags).'}';

    if($orderBy == 3){ //ASC
        $stmt = $conn->prepare('
SELECT "id", "rating", "title", "creatorId", "creationDate" FROM "Question","Content",
(SELECT "contentId" FROM "QuestionTags", unnest(?::INTEGER[]) AS "tag"
WHERE "tagId" = "tag") AS "results"
WHERE "Question"."contentId" = "Content"."id" AND "results"."contentId" = "Content"."id"
ORDER BY "rating" ASC 
LIMIT ? OFFSET ?');
    }
    else { //DESC
        $stmt = $conn->prepare('
SELECT "id", "rating", "title", "creatorId", "creationDate" FROM "Question","Content",
(SELECT "contentId" FROM "QuestionTags", unnest(?::INTEGER[]) AS "tag"
WHERE "tagId" = "tag") AS "results"
WHERE "Question"."contentId" = "Content"."id" AND "results"."contentId" = "Content"."id"
ORDER BY "rating" DESC 
LIMIT ? OFFSET ?');
    }

    $stmt->execute([$tags,$resultsPerPage,$thisPageFirstResult]);

    return $stmt->fetchAll();
}

function searchByTagOrderedByNumberOfAnswers($tags, $thisPageFirstResult, $resultsPerPage, $orderBy)
{
    global $conn;

    $tags = '{'.implode(",",$tags).'}';

    if($orderBy == 1){ //ASC
        $stmt = $conn->prepare('
SELECT "Content"."id", "rating", "title", "creatorId", "creationDate" FROM 
          (SELECT "Results"."id", COUNT("topContentId") AS "NumberOfAnswers" FROM ( 
SELECT "id", "rating", "title", "creatorId", "creationDate" FROM "Question","Content",
(SELECT "contentId" FROM "QuestionTags", unnest(?::INTEGER[]) AS "tag"
WHERE "tagId" = "tag") AS "results"
WHERE "Question"."contentId" = "Content"."id" AND "results"."contentId" = "Content"."id") AS "Results" 
          LEFT JOIN "Reply"
          ON "Results"."id" = "topContentId"
          GROUP BY "Results"."id") AS "Results", "Question", "Content"
        WHERE "Results"."id" = "Question"."contentId" AND "Question"."contentId" = "Content"."id"
        ORDER BY "NumberOfAnswers" ASC
        LIMIT ? OFFSET ?');
    }
    else { //DESC
        $stmt = $conn->prepare('
SELECT "Content"."id", "rating", "title", "creatorId", "creationDate" FROM 
          (SELECT "Results"."id", COUNT("topContentId") AS "NumberOfAnswers" FROM ( 
SELECT "id", "rating", "title", "creatorId", "creationDate" FROM "Question","Content",
(SELECT "contentId" FROM "QuestionTags", unnest(?::INTEGER[]) AS "tag"
WHERE "tagId" = "tag") AS "results"
WHERE "Question"."contentId" = "Content"."id" AND "results"."contentId" = "Content"."id") AS "Results" 
          LEFT JOIN "Reply"
          ON "Results"."id" = "topContentId"
          GROUP BY "Results"."id") AS "Results", "Question", "Content"
        WHERE "Results"."id" = "Question"."contentId" AND "Question"."contentId" = "Content"."id"
        ORDER BY "NumberOfAnswers" DESC
        LIMIT ? OFFSET ?');
    }

    $stmt->execute([$tags,$resultsPerPage,$thisPageFirstResult]);

    return $stmt->fetchAll();
}

function searchByTagResultsSize($tags)
{
    global $conn;

    $tags = '{'.implode(",",$tags).'}';

    $stmt = $conn->prepare('
SELECT COUNT(*) FROM "Question","Content",
(SELECT "contentId" FROM "QuestionTags", unnest(?::INTEGER[]) AS "tag"
WHERE "tagId" = "tag") AS "results"
WHERE "Question"."contentId" = "Content"."id" AND "results"."contentId" = "Content"."id";');

    $stmt->execute([$tags]);

    return $stmt->fetch();
}
