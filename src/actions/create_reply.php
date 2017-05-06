<?php
include_once '../config/init.php';
include_once '../database/users.php';
include_once '../database/content.php';
include_once '../database/permissions.php';

$userId = $smarty->getTemplateVars('USERID');


if (!isset($userId)){
    http_response_code(403);
    exit;
}


$text = htmlspecialchars($_POST['reply-text']);
$parentId = intval(htmlspecialchars($_POST['parent-id']));
$questionId = intval(htmlspecialchars($_POST['question-id']));

if (canReply($userId))
    createReply($userId, (new \DateTime())->format('Y-m-d H:i:s'), $text, $parentId, $questionId);

header('Location: ' . $_SERVER['HTTP_REFERER']);

