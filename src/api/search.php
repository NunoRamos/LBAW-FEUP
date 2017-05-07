<?php
include_once('../config/init.php');
include_once($BASE_DIR . 'database/users.php');
include_once($BASE_DIR . 'database/content.php');
include_once($BASE_DIR . 'lib/order.php');
include_once($BASE_DIR . 'lib/search_type.php');

$searchString = htmlspecialchars($_GET['inputString']);

$selectedTags = [];
if (isset($_GET['selectedTags'])) {
    foreach ($_GET['selectedTags'] as $tag)
        $selectedTags[] = intval(htmlspecialchars($tag));
}

if ((sizeof($selectedTags) == 0 && strlen($searchString) == 0))
    echo json_encode(['questions' => [], 'users' => [], 'numberOfPages' => 0]);

switch ($_GET['searchType']) {
    case SearchType::QUESTIONS:
        searchQuestion($searchString, $selectedTags);
        break;
    case SearchType::USERS:
        searchUsers();
        break;
    default:
        echo json_encode("Error");
        break;
}

function searchQuestion($searchString, $selectedTags)
{
    //Getting filter to search
    $orderBy = htmlspecialchars($_GET['orderBy']);
    if (!is_integer($orderBy))
        $orderBy = Order::SIMILARITY;

    $lookALikeQuestions = getSimilarQuestions($searchString, $selectedTags, $orderBy);

    echo json_encode($lookALikeQuestions);
}

function searchUsers()
{
    global $searchString;
    global $resultsPerPage;

    //Lets see number of results
    $return = getNumberOfUsersByName($searchString);
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
        $users = getUserByNameOrderedByAnswers($searchString, $thisPageFirstResult, $resultsPerPage, $orderBy);
    } else if ($orderBy == 3 || $orderBy == 4) { // 3 == Order by Questions - Ascending | 4 == Order by Questions - Descending
        $users = getUserByNameOrderedByQuestions($searchString, $thisPageFirstResult, $resultsPerPage, $orderBy);
    } else { //No order
        $users = getUserByName($searchString, $thisPageFirstResult, $resultsPerPage);
    }

    echo json_encode(['users' => $users, 'numberOfPages' => $numberOfPages]);
}


