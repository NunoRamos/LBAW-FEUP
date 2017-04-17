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

function getAllTags()
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "Tag"');
    $stmt->execute();
    return $stmt->fetchAll();
}

function getUserById($userId){
    global $conn;

    $stmt = $conn->prepare('SELECT id,name FROM "User" WHERE id = ?');
    $stmt->execute([$userId]);
    return $stmt->fetch();
}
