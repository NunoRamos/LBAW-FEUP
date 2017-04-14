<?php

function createUser($email,$password,$name,$privilegeLevelId){
    global $conn;

    $stmt = $conn->prepare('INSERT INTO "User" (email,password,name,"privilegeLevelId") VALUES (?,?,?,?)');
    $stmt->execute(array($email,$password,$name,$privilegeLevelId));

}

function getUser($email) {
    global $conn;
    $stmt = $conn->prepare('SELECT * 
                            FROM "User" 
                            WHERE email = ?');
    $stmt->execute(array($email));
    return $stmt->fetch();
}