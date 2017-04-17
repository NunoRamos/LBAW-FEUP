<?php

function createUser($email, $password, $name, $privilegeLevelId)
{
    global $conn;

    $stmt = $conn->prepare('INSERT INTO "User" (email,password,name,"privilegeLevelId") VALUES (?,?,?,?)');
    $stmt->execute([$email, $password, $name, $privilegeLevelId]);
}

function getUserByEmail($email)
{
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM "User" WHERE "User".email = ?');
    $stmt->execute([$email]);
    return $stmt->fetch();
}

function getUserNameById($id)
{
    global $conn;
    $stmt = $conn->prepare('SELECT "User"."name" FROM "User" WHERE "User".id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch()["name"];
}

function getUserById($userId){
    global $conn;

    $stmt = $conn->prepare('SELECT id,name FROM "User" WHERE id = ?');
    $stmt->execute([$userId]);
    return $stmt->fetch();
}
