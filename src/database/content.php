<?php

function getQuestion($questionId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM "Content", "Question" WHERE "contentId" = ?');
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

function createContent($creatorId, $creationDate, $text)
{
    global $conn;
    $stmt = $conn->prepare('INSERT INTO "Content"("creatorId", "creationDate", "text") VALUES (?, ?, ?) RETURNING id');
    $stmt->execute([$creatorId, $creationDate, $text]);
    return $stmt->fetch()['id'];
}

function createQuestion($creatorId, $creationDate, $text, $title, $tags)
{
    global $conn;
    $contentId = createContent($creatorId, $creationDate, $text);
    $stmt = $conn->prepare('INSERT INTO "Question" VALUES(?, ?, FALSE)');
    $stmt->execute([$contentId, $title]);

    $stmt = $conn->prepare('INSERT INTO "QuestionTags" VALUES(?, ?)');
    foreach ($tags as $tagId) {
        $stmt->execute([$contentId, $tagId]);
    }

    return $contentId;
}

function createReply($creatorId, $creationDate, $text, $parentId)
{
    global $conn;
    $contentId = createContent($creatorId, $creationDate, $text);
    $stmt = $conn->prepare('INSERT INTO "Reply" VALUES(?, ?)');
    $stmt->execute([$contentId, $parentId]);

    return $contentId;
}

function getAllTags()
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "Tag"');
    $stmt->execute();
    return $stmt->fetchAll();
}
