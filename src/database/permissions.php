<?php

function canCreateQuestion($userId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "canCreateQuestion" FROM "User", "PrivilegeLevel" WHERE "User".id = ? AND "User"."privilegeLevelId" = "PrivilegeLevel".id');
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

function canDeleteOwnContent($userId) {
    global $conn;
    $stmt = $conn->prepare('SELECT "canDeleteOwnContent" FROM "User", "PrivilegeLevel" WHERE "User".id = ? AND "User"."privilegeLevelId" = "PrivilegeLevel".id');
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

function canDeleteAnyContent($userId) {
    global $conn;
    $stmt = $conn->prepare('SELECT "canDeleteAnyContent" FROM "User", "PrivilegeLevel" WHERE "User".id = ? AND "User"."privilegeLevelId" = "PrivilegeLevel".id');
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

function canReply($userId)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "canReply" FROM "User", "PrivilegeLevel" WHERE "User".id = ? AND "User"."privilegeLevelId" = "PrivilegeLevel".id');
    $stmt->execute([$userId]);
    return $stmt->fetch();
}