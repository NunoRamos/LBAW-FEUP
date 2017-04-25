<?php
include_once '../config/init.php';
include_once '../database/content.php';

if (!isset($_GET['questionId']) || !isset($_GET['vote'])) {
    $_SESSION['error_messages'][] = 'Invalid vote';
    $_SESSION['form_values'] = $_GET;
    if (empty($_SERVER['HTTP_REFERER']))
        header('Location: ../pages/misc/landing_page.php');
    else
        header("Location:" . $_SERVER['HTTP_REFERER']);
    exit;
}

$userId = $smarty->getTemplateVars('USERID');

if (!isset($userId)){
    //http_response_code(403);
    $_SESSION['error_messages'][] = 'You need to be signed-in';
    if (empty($_SERVER['HTTP_REFERER']))
        header('Location: ../pages/misc/landing_page.php');
    else
        header("Location:" . $_SERVER['HTTP_REFERER']);
    exit;
}

$questionId = htmlspecialchars($_GET['questionId']);
$vote = htmlspecialchars($_GET['vote']);

if($vote == 1)
    addVote($userId,$questionId,TRUE);
else
    addVote($userId,$questionId,FALSE);

header("Location:" . $_SERVER['HTTP_REFERER']);

