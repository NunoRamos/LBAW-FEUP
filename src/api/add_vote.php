<?php
include_once '../config/init.php';
include_once '../database/content.php';

if (!isset($_GET['questionId']) || !isset($_GET['vote'])) {
    exit;
}

$userId = $smarty->getTemplateVars('USERID');

if (!isset($userId)){
    exit;
}

$questionId = htmlspecialchars($_GET['questionId']);
$vote = htmlspecialchars($_GET['vote']);

if($vote == 1)
    addVote($userId,$questionId,TRUE);
else
    addVote($userId,$questionId,FALSE);

header("Location:" . $_SERVER['HTTP_REFERER']);

