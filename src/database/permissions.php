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

function canReply($userId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "canReply" FROM "User", "PrivilegeLevel" WHERE "User".id = ? AND "User"."privilegeLevelId" = "PrivilegeLevel".id');
    $stmt->execute([$userId]);
    return $stmt->fetch()["canReply"];
}