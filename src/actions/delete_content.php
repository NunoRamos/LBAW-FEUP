<?php
include_once '../config/init.php';
include_once '../database/users.php';
include_once '../database/content.php';
include_once '../database/permissions.php';

global $lastToken;
$token = $_POST['token'];

if (strcmp($lastToken, $token) !== 0) {
    http_response_code(403);
    exit;
}

$userId = $_SESSION['userId'];
$contentId = $_POST['content-id'];

if (!canDeleteContent($userId, $contentId)) {
    http_response_code(403);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

if (isQuestion($contentId)) {
    header('Location: /');
    deleteQuestion($contentId);
} else {
    deleteReply($contentId);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
