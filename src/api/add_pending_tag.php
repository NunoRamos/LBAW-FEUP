<?php
include_once '../config/init.php';
include_once '../database/content.php';

$userId = $_SESSION['userId'];

if (!isset($_POST['name']) && !isset($userId)) {
    exit;
}

$name = htmlspecialchars($_POST['name']);

$valid = verifyNameIfIsValid($name);

if(sizeof($valid) == 0)
    addPendingTag($name);