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

if (!isset($userId)) {
    http_response_code(403);
    exit;
}

$text = stripProhibitedTags($_POST['content-text']);
$parentId = intval(htmlspecialchars($_POST['content-id']));
$questionId = intval(htmlspecialchars($_POST['question-id']));

error_log($questionId);

if (canReply($userId, $parentId, $questionId))
    createReply($userId, (new \DateTime())->format('Y-m-d H:i:s'), $text, $parentId, $questionId);

header('Location: ' . $_SERVER['HTTP_REFERER']);

