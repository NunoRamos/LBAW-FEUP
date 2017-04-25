<?php
include_once('../config/init.php');
include_once($BASE_DIR .'database/users.php');
include_once($BASE_DIR .'database/content.php');

if (!$_GET['inputString']) {
    $_SESSION['error_messages'][] = 'All fields are mandatory';
    $_SESSION['form_values'] = $_POST;
    if(empty($_SERVER['HTTP_REFERER']))
        header('Location: ../pages/misc/landing_page.php');
    else
        header("Location:" . $_SERVER['HTTP_REFERER']);
    exit;
    exit;
}

//Lets see number of results
$numberOfResults = getNumberOfSimilarQuestions($inputString);

$resultsPerPage = 10;

$numberOfPages = ceil($numberOfResults/$resultsPerPage);

$inputString = htmlspecialchars($_GET['inputString']);

if(isset($_GET['page']))
    $atualPage = $_GET['page'];
else $atualPage = 1;

$thisPageFirstResult = ($atualPage - 1) * $resultsPerPage;

$lookALikeQuestions = getSimilarQuestions($inputString,$thisPageFirstResult,$resultsPerPage);// getQuestionByString($inputString);

$smarty->assign('numberOfPages', $numberOfPages);

$creator = array();

foreach ($lookALikeQuestions as $lookALikeQuestion){
    $creator[] = getUserById($lookALikeQuestion['creatorId']);
}

echo json_encode(['questions' => $lookALikeQuestions,'users' => $creator]);

