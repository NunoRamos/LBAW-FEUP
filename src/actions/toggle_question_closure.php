<?php
include_once '../config/init.php';
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

if (!canCloseQuestion($userId, $contentId)) {
    http_response_code(403);
    exit;
}

toggleQuestionClosure($contentId);

header('Location: ' . $_SERVER['HTTP_REFERER']);
