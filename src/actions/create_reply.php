<?php
include_once '../config/init.php';
include_once '../database/users.php';
include_once '../database/content.php';
include_once '../database/permissions.php';

$userId = $smarty->getTemplateVars('USERID');

$text = htmlspecialchars($_POST['reply-text']);
$parentId = intval(htmlspecialchars($_GET['parent-id']));

if (canReply($userId))
    createReply($userId, (new \DateTime())->format('Y-m-d H:i:s'), $text, $parentId);

header('Location: ' . $_SERVER['HTTP_REFERER']);

