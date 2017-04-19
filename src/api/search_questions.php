<?php
include_once('../config/init.php');
include_once($BASE_DIR .'database/users.php');
include_once($BASE_DIR .'database/content.php');

if (!$_GET['inputString']) {
    $_SESSION['error_messages'][] = 'All fields are mandatory';
    $_SESSION['form_values'] = $_POST;
    header("Location:" . $_SERVER['HTTP_REFERER']);
    exit;
}

$inputString = htmlspecialchars($_GET['inputString']);

$lookALikeQuestions = getQuestionByString($inputString);

$creator = array();

foreach ($lookALikeQuestions as $lookALikeQuestion){
    $creator[] = getUserById($lookALikeQuestion['creatorId']);
}

echo json_encode(['questions' => $lookALikeQuestions,'users' => $creator]);

