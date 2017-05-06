<?php
include_once('../config/init.php');
include_once($BASE_DIR . 'database/users.php');
include_once($BASE_DIR . 'database/content.php');
include_once($BASE_DIR . 'lib/order.php');
include_once($BASE_DIR . 'lib/search_type.php');


$inputString = htmlspecialchars($_GET['inputString']);

$selectedTags = [];
echo $_GET['activeTags'];
foreach ($_GET['activeTags'] as $tag) {
    $selectedTags[] = intval(htmlspecialchars($tag));
}

if ((sizeof($selectedTags) == 0 && strlen($inputString) == 0))
    echo json_encode(['questions' => [], 'users' => [], 'numberOfPages' => 0]);


$resultsPerPage = intval(htmlspecialchars($_GET['resultsPerPage']));
if (!is_integer($resultsPerPage) || $resultsPerPage < 1)
    $resultsPerPage = 10;

$searchType = $_GET['searchType'];
if (!SearchType::isValid($searchType))
    $searchType = SearchType::QUESTIONS;

echo json_encode(['question' => $selectedTags, 'users' => [], 'numberOfPages' => 0]);

function searchQuestion()
{
    global $inputString;
    global $resultsPerPage;
    global $selectedTags;

    //Lets see number of results
    if (strlen($inputString) == 0)
        $return = searchByTagResultsSize($selectedTags);
    else $return = getNumberOfSimilarQuestions($inputString, $selectedTags);

    $numberOfResults = $return['count'];

    $numberOfPages = ceil($numberOfResults / $resultsPerPage);

    $currentPage = htmlspecialchars($_GET['page']);

    if (!is_integer($currentPage) || $currentPage < 1 || $currentPage > $numberOfPages)
        $currentPage = 1;

    //Getting the position of the first element to be searched
    $resultsOffset = ($currentPage - 1) * $resultsPerPage;

    //Getting filter to search
    $orderBy = htmlspecialchars($_GET['orderBy']);
    if (!is_integer($orderBy))
        $orderBy = Order::SIMILARITY;

    $lookALikeQuestions = getSimilarQuestions($inputString, $resultsOffset, $resultsPerPage, $selectedTags, $orderBy);

    //Getting questions
    /*if (strlen($inputString) == 0) { //Just search by tags
        if ($orderBy == 1 || $orderBy == 2) { // 1 == Order by Answers - Ascending | 2 == Order by Answers - Descending
            $lookALikeQuestions = searchByTagOrderedByNumberOfAnswers($tagsId, $resultsOffset, $resultsPerPage, $orderBy);
        } else if ($orderBy == 3 || $orderBy == 4) { // 3 == Order by Rating - Ascending | 4 == Order by Rating - Descending
            $lookALikeQuestions = searchByTagOrderedByRating($tagsId, $resultsOffset, $resultsPerPage, $orderBy);
        } else { //No order
            $lookALikeQuestions = searchByTag($tagsId, $resultsOffset, $resultsPerPage);
        }

    } else {
        if ($orderBy == 1 || $orderBy == 2) { // 1 == Order by Answers - Ascending | 2 == Order by Answers - Descending
            $lookALikeQuestions = getSimiliarQuestionByNumberOfAnswers($inputString, $resultsOffset, $resultsPerPage, $orderBy, $tagsId);
        } else if ($orderBy == 3 || $orderBy == 4) { // 3 == Order by Rating - Ascending | 4 == Order by Rating - Descending
            $lookALikeQuestions = getSimilarQuestionsOrderedByRating($inputString, $resultsOffset, $resultsPerPage, $orderBy, $tagsId);
        } else { //No order
            $lookALikeQuestions = getSimilarQuestions($inputString, $resultsOffset, $resultsPerPage, $tagsId);
        }
    }*/

    $creator = [];

    foreach ($lookALikeQuestions as $lookALikeQuestion) {
        $creator[] = getUserById($lookALikeQuestion['creatorId']);
    }

    echo json_encode(['questions' => $lookALikeQuestions, 'users' => $creator,
        'numberOfPages' => $numberOfPages]);
}

function searchUsers()
{
    global $inputString;
    global $resultsPerPage;

    //Lets see number of results
    $return = getNumberOfUsersByName($inputString);
    $numberOfResults = $return['count'];

    $numberOfPages = ceil($numberOfResults / $resultsPerPage);

    if (isset($_GET['page']))
        $atualPage = htmlspecialchars($_GET['page']);
    else $atualPage = 1;

    //Getting the position of the first element to be searched
    $thisPageFirstResult = ($atualPage - 1) * $resultsPerPage;

    //Getting filter to search
    if (isset($_GET['orderBy']))
        $orderBy = htmlspecialchars($_GET['orderBy']);
    else $orderBy = 0;

    if ($orderBy == 1 || $orderBy == 2) { // 1 == Order by Answers - Ascending | 2 == Order by Answers - Descending
        $users = getUserByNameOrderedByAnswers($inputString, $thisPageFirstResult, $resultsPerPage, $orderBy);
    } else if ($orderBy == 3 || $orderBy == 4) { // 3 == Order by Questions - Ascending | 4 == Order by Questions - Descending
        $users = getUserByNameOrderedByQuestions($inputString, $thisPageFirstResult, $resultsPerPage, $orderBy);
    } else { //No order
        $users = getUserByName($inputString, $thisPageFirstResult, $resultsPerPage);
    }

    echo json_encode(['users' => $users, 'numberOfPages' => $numberOfPages]);
}


