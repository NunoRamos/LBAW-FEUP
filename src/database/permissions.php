<?php

function canCreateQuestion($userId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "canCreateQuestion" FROM "User", "PrivilegeLevel" WHERE "User".id = ? AND "User"."privilegeLevelId" = "PrivilegeLevel".id');
    $stmt->execute([$userId]);
    return $stmt->fetch()["canCreateQuestion"];
}

function canDeleteOwnContent($userId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "canDeleteOwnContent" FROM "User", "PrivilegeLevel" WHERE "User".id = ? AND "User"."privilegeLevelId" = "PrivilegeLevel".id');
    $stmt->execute([$userId]);
    return $stmt->fetch()["canDeleteOwnContent"];
}

function canDeleteAnyContent($userId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "canDeleteAnyContent" FROM "User", "PrivilegeLevel" WHERE "User".id = ? AND "User"."privilegeLevelId" = "PrivilegeLevel".id');
    $stmt->execute([$userId]);
    return $stmt->fetch()["canDeleteAnyContent"];
}

function canUserReply($userId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "canReply" FROM "User", "PrivilegeLevel" WHERE "User".id = ? AND "User"."privilegeLevelId" = "PrivilegeLevel".id');
    $stmt->execute([$userId]);
    return $stmt->fetch()["canReply"];
}

function canDeleteContent($userId, $contentId)
{
    if (isset($userId) && isset($contentId))
        return (canDeleteOwnContent($userId) && getContentOwnerId($contentId) === $userId) || canDeleteAnyContent($userId);

    return false;
}

function canEditAnyContent($userId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "canEditAnyContent" FROM "User", "PrivilegeLevel" WHERE "User".id = ? AND "User"."privilegeLevelId" = "PrivilegeLevel".id');
    $stmt->execute([$userId]);
    return $stmt->fetch()["canEditAnyContent"];
}

function canEditOwnContent($userId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "canEditOwnContent" FROM "User", "PrivilegeLevel" WHERE "User".id = ? AND "User"."privilegeLevelId" = "PrivilegeLevel".id');
    $stmt->execute([$userId]);
    return $stmt->fetch()["canEditOwnContent"];
}

function canEditContent($userId, $contentId)
{
    if (isset($userId) && isset($contentId))
        return (canEditOwnContent($userId) && getContentOwnerId($contentId) === $userId) || canEditAnyContent($userId);

    return false;
}

function canFollowContent($userId)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "PrivilegeLevel", "User" WHERE "User"."id" = ? AND "User"."privilegeLevelId" = "PrivilegeLevel"."id"');
    $stmt->execute([$userId]);
    return $stmt->fetch()['canFollowContent'];
}

function canAcceptPendingTags($userId)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "PrivilegeLevel", "User" WHERE "User"."id" = ? AND "User"."privilegeLevelId" = "PrivilegeLevel"."id"');
    $stmt->execute([$userId]);
    return $stmt->fetch()['canAcceptPendingTags'];
}

function canBanUsers($userId)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "PrivilegeLevel", "User" WHERE "User"."id" = ? AND "User"."privilegeLevelId" = "PrivilegeLevel"."id"');
    $stmt->execute([$userId]);
    return $stmt->fetch()['canBanUsers'];
}

function canCloseAnyQuestion($userId)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "PrivilegeLevel", "User" WHERE "User"."id" = ? AND "User"."privilegeLevelId" = "PrivilegeLevel"."id"');
    $stmt->execute([$userId]);
    return $stmt->fetch()['canCloseAnyQuestion'];
}

function canCloseOwnQuestion($userId)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "PrivilegeLevel", "User" WHERE "User"."id" = ? AND "User"."privilegeLevelId" = "PrivilegeLevel"."id"');
    $stmt->execute([$userId]);
    return $stmt->fetch()['canCloseOwnQuestion'];
}

function canCloseQuestion($userId, $questionId)
{
    return (canCloseOwnQuestion($userId) && getContentOwnerId($questionId) === $userId) || canCloseAnyQuestion($userId);
}

function canReply($userId, $contentId, $questionId)
{
    return canUserReply($userId) && (isset($questionId) ? !isQuestionClosed($questionId) : !isQuestionClosed($contentId));
}
