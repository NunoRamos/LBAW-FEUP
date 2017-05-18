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

$resultsPerPage = intval(htmlspecialchars($_GET['resultsPerPage']));
if (!is_integer($resultsPerPage) || $resultsPerPage < 1)
    $resultsPerPage = 10;

$resultOffset = intval(htmlspecialchars($_GET['resultsOffset']));
if (!is_integer($resultOffset) || $resultOffset < 1)
    $resultOffset = 0;

if ((sizeof($selectedTags) == 0 && strlen($searchString) == 0))
    echo json_encode(['reply' => [], 'users' => [], 'numberOfPages' => 0]);

switch ($_GET['searchType']) {
    case SearchType::QUESTIONS:
        searchQuestion($searchString, $selectedTags, $resultsPerPage, $resultOffset);
        break;
    case SearchType::USERS:
        searchUsers();
        break;
    default:
        echo json_encode("Error");
        break;
}

function searchQuestion($searchString, $selectedTags, $resultsPerPage, $resultOffset)
{
    //Getting filter to search
    $orderBy = htmlspecialchars($_GET['orderBy']);
    if (!is_integer($orderBy))
        $orderBy = Order::SIMILARITY;

    $questions = searchQuestions($searchString, $selectedTags, $orderBy, $resultsPerPage, $resultOffset);

    $return = '';
    foreach ($questions as $question) {
        $return .= '<div class="list-group-item">' .
            '<div class="row no-gutter no-side-margin">' .
            '<div class="col-xs-1">' .
            '<div class="text-center anchor clickable" href="../../actions/add_vote.php?questionId=' . $question['id'] . '&vote=1"><span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span></div>' .
            '<div class="text-center"><span>' . $question['rating'] . '</span></div>' .
            '<div class="text-center anchor clickable" href="../../actions/add_vote.php?questionId=' . $question['id'] . '&vote=0"><span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span></div>' .
            '</div>' .
            '<div class="col-xs-11 anchor clickable" href="question_page.php?id=' . $question['id'] . '">' .
            '<div class="col-xs-12">' .
            '<a class="small-text" href="../users/profile_page.php?id=' . $question['creatorId'] . '><span>' . $question [' creatorName '] . '</span></a>' .
            '<span class="small-text"> | ' . $question['creationDate'] . '</span>' .
            '</div>' .
            '<span class="large - text col - xs - 12">' . $question ['title'] . '</span>' .
            '</div>' .
            '</div>' .
            '</div>';
    }

    echo $return;
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


