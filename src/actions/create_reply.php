<?php
include_once '../config/init.php';
include_once '../database/users.php';
include_once '../database/permissions.php';

$userId = $smarty->getTemplateVars('USERID');

$text = htmlspecialchars($_POST['reply-text']);
$parentId = intval(htmlspecialchars($_GET['id']));//not working
if(canReply($userId))
createReply($userId,(new \DateTime())->format('Y-m-d H:i:s'),$text,'269');
header('Location: ' . $smarty->getTemplateVars('BASE_URL')  . '/pages/content/question_page.php?id=' .'269');

