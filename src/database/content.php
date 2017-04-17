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