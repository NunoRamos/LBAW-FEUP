<?php

function register($email, $password, $name)
{
    global $conn;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('INSERT INTO "User" (email,password,name,"privilegeLevelId") VALUES (?,?,?,?) RETURNING "id", "email", "name", "privilegeLevelId"');
    $stmt->execute([$email, $hashed_password, $name, 1]);

    return $stmt->fetch();
}

function login($email, $password)
{
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM "User" WHERE "User".email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (password_verify($password, $user['password']))
        return $user;
    else
        return false;
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

function getUserById($userId)
{
    global $conn;

    $stmt = $conn->prepare('SELECT "id", "name" FROM "User" WHERE "id" = ?');
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

function getUnreadNotifications($userId)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM "Notification" WHERE "userId" = ? AND read = FALSE');
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function getUserByName($inputString, $thisPageFirstResult, $resultsPerPage)
{
    global $conn;

    $expression = '%' . $inputString . '%';

    $stmt = $conn->prepare('SELECT * FROM "User" WHERE "name" LIKE ? LIMIT ? OFFSET ?');
    $stmt->execute([$expression, $resultsPerPage, $thisPageFirstResult]);
    return $stmt->fetchAll();
}

function getUserByNameOrderedByAnswers($inputString, $thisPageFirstResult, $resultsPerPage, $orderBy)
{
    global $conn;

    $expression = '%' . $inputString . '%';

    if ($orderBy == 1) { //ASC
        $stmt = $conn->prepare('
    SELECT * FROM "User",
    (SELECT COUNT(*) FROM "Reply","Content"
      WHERE id = "contentId"
      GROUP BY "creatorId") AS "Answers" 
    WHERE "name" LIKE ? 
    ORDER BY "Answers" ASC
    LIMIT ? OFFSET ?');
    } else { //DESC
        $stmt = $conn->prepare('
    SELECT * FROM "User",
    (SELECT COUNT(*) FROM "Reply","Content"
      WHERE id = "contentId"
      GROUP BY "creatorId") AS "Answers" 
    WHERE "name" LIKE ? 
    ORDER BY "Answers" DESC
    LIMIT ? OFFSET ?');
    }

    $stmt->execute([$expression, $resultsPerPage, $thisPageFirstResult]);
    return $stmt->fetchAll();
}

function getUserByNameOrderedByQuestions($inputString, $thisPageFirstResult, $resultsPerPage, $orderBy)
{
    global $conn;

    $expression = '%' . $inputString . '%';

    if ($orderBy == 3) { //ASC
        $stmt = $conn->prepare('
    SELECT * FROM "User",
    (SELECT COUNT(*) FROM "Question","Content"
      WHERE id = "contentId"
      GROUP BY "creatorId") AS "Answers" 
    WHERE "name" LIKE ? 
    ORDER BY "Answers" ASC
    LIMIT ? OFFSET ?');
    } else { //DESC
        $stmt = $conn->prepare('
    SELECT * FROM "User",
    (SELECT COUNT(*) FROM "Question","Content"
      WHERE id = "contentId"
      GROUP BY "creatorId") AS "Answers" 
    WHERE "name" LIKE ? 
    ORDER BY "Answers" DESC
    LIMIT ? OFFSET ?');
    }

    $stmt->execute([$expression, $resultsPerPage, $thisPageFirstResult]);
    return $stmt->fetchAll();
}

function getNumberOfUsersByName($inputString)
{
    global $conn;

    $expression = '%' . $inputString . '%';

    $stmt = $conn->prepare('SELECT COUNT(*) FROM "User" WHERE "name" LIKE ?');
    $stmt->execute([$expression]);
    return $stmt->fetch();
}
