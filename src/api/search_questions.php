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

$resultsPerPage = 10;

$inputString = htmlspecialchars($_GET['inputString']);

if(isset($_GET['searchType']))
    $searchType = htmlspecialchars($_GET['searchType']);
else $searchType = 'Questions';

if($searchType == 'Questions'){
    searchQuestion();
}
else if($searchType == 'Users'){
    searchUsers();
}

function searchQuestion(){
    global $inputString;
    global $resultsPerPage;

    //Getting active tags
    if(isset($_GET['tags'])){
        $tags = $_GET['tags'];
        $tagsId = getTagsId($tags);
    }
    else $tagsId = [];

    //Lets see number of results
    $return = getNumberOfSimilarQuestions($inputString,$tagsId);
    $numberOfResults = $return['count'];

    $numberOfPages = ceil($numberOfResults/$resultsPerPage);

    if(isset($_GET['page']))
        $atualPage = htmlspecialchars($_GET['page']);
    else $atualPage = 1;

    //Getting the position of the first element to be searched
    $thisPageFirstResult = ($atualPage - 1) * $resultsPerPage;

    //Getting filter to search
    if(isset($_GET['orderBy']))
        $orderBy = htmlspecialchars($_GET['orderBy']);
    else $orderBy = 0;

    //Getting questions
    if($orderBy == 1 || $orderBy == 2){ // 1 == Order by Answers - Ascending | 2 == Order by Answers - Descending
        $lookALikeQuestions = getSimiliarQuestionByNumberOfAnswers($inputString,$thisPageFirstResult,$resultsPerPage,$orderBy,$tagsId);
    }
    else if($orderBy == 3 || $orderBy == 4){ // 3 == Order by Rating - Ascending | 4 == Order by Rating - Descending
        $lookALikeQuestions = getSimilarQuestionsOrderedByRating($inputString,$thisPageFirstResult,$resultsPerPage,$orderBy,$tagsId);
    }
    else { //No order
        $lookALikeQuestions = getSimilarQuestions($inputString,$thisPageFirstResult,$resultsPerPage,$tagsId);
    }

    $creator = array();

    foreach ($lookALikeQuestions as $lookALikeQuestion){
        $creator[] = getUserById($lookALikeQuestion['creatorId']);
    }

    echo json_encode(['questions' => $lookALikeQuestions,'users' => $creator,
        'numberOfPages' => $numberOfPages, 'tags'=> $tagsId]);
}

function searchUsers(){
    global $inputString;
    global $resultsPerPage;

    //Lets see number of results
    $return = getNumberOfUsersByName($inputString);
    $numberOfResults = $return['count'];

    $numberOfPages = ceil($numberOfResults/$resultsPerPage);

    if(isset($_GET['page']))
        $atualPage = htmlspecialchars($_GET['page']);
    else $atualPage = 1;

    //Getting the position of the first element to be searched
    $thisPageFirstResult = ($atualPage - 1) * $resultsPerPage;

    //Getting filter to search
    if(isset($_GET['orderBy']))
        $orderBy = htmlspecialchars($_GET['orderBy']);
    else $orderBy = 0;

    if($orderBy == 1 || $orderBy == 2) { // 1 == Order by Answers - Ascending | 2 == Order by Answers - Descending
        $users = getUserByNameOrderedByAnswers($inputString,$thisPageFirstResult,$resultsPerPage,$orderBy);
    }
    else if($orderBy == 3 || $orderBy == 4) { // 3 == Order by Questions - Ascending | 4 == Order by Questions - Descending
        $users = getUserByNameOrderedByQuestions($inputString,$thisPageFirstResult,$resultsPerPage,$orderBy);
    }
    else { //No order
        $users = getUserByName($inputString,$thisPageFirstResult,$resultsPerPage);
    }

    echo json_encode(['users' => $users,'numberOfPages' => $numberOfPages]);
}


