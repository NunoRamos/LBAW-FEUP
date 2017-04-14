<?php

function createUser($email,$password,$name,$privilegeLevelId){
    global $conn;

    $stmt = $conn->prepare('INSERT INTO "User" (email,password,name,"privilegeLevelId") VALUES (?,?,?,?)');
    $stmt->execute(array($email,$password,$name,$privilegeLevelId));

}