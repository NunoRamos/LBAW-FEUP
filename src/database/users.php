<?php

function createUser($email, $password, $name, $privilegeLevelId)
{
    global $conn;

    $stmt = $conn->prepare('INSERT INTO "User" (email,password,name,"privilegeLevelId") VALUES (?,?,?,?)');
    $stmt->execute(array($email, $password, $name, $privilegeLevelId));
}

function getUser($email)
{
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM "User" WHERE "User".email = ?');
    $stmt->execute(array($email));
    return $stmt->fetch();
}

function canCreateQuestion($userId)
{
    global $conn;
    $conn->prepare('SELECT "canCreateQuestion" FROM "User", "PrivilegeLevel" WHERE "User".id = ? AND "User"."privilegeLevelId" = "PrivilegeLevel".id');
    $conn->exec([$userId]);
}
