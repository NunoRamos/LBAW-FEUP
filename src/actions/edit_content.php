<?php
include_once '../config/init.php';
include_once '../database/content.php';
include_once '../database/permissions.php';

$userId = $smarty->getTemplateVars('USERID');

if (!isset($userId)){
    http_response_code(403);
    exit;
}

if(!isset($_POST['container-text']) || !isset($_POST['parent-id'])){
    exit;
}

$text = stripProhibitedTags($_POST['container-text']);
$contentId = intval(htmlspecialchars($_POST['parent-id']));

if(canEditContent($userId,$contentId)){
    updateContentText($contentId,$text);
}

header('Location: ' . $_SERVER['HTTP_REFERER']);