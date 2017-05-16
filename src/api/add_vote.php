<?php
include_once '../config/init.php';
include_once '../database/content.php';

if (!isset($_GET['contentId']) || !isset($_GET['vote']) || !isset($_GET['userId'])) {
    exit;
}

$questionId = htmlspecialchars($_GET['contentId']);
$vote = htmlspecialchars($_GET['vote']);
$userId = htmlspecialchars($_GET['userId']);

vote($userId,$questionId,$vote);

