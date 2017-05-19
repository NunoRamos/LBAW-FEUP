<?php
include_once('../config/init.php');
include_once($BASE_DIR . 'database/users.php');
include_once($BASE_DIR . 'database/content.php');
include_once($BASE_DIR . 'lib/question_search_order.php');
include_once($BASE_DIR . 'lib/user_search_order.php');
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

$page = intval(htmlspecialchars($_GET['page']));
if (!is_integer($page) || $page < 1)
    $page = 1;

$orderBy = htmlspecialchars($_GET['orderBy']);

if ((sizeof($selectedTags) == 0 && strlen($searchString) == 0))
    echo json_encode(['reply' => [], 'users' => [], 'numberOfPages' => 0]);


switch ($_GET['searchType']) {
    case SearchType::QUESTIONS:
        searchQuestion($searchString, $selectedTags, $resultsPerPage, $page, $orderBy);
        break;
    case SearchType::USERS:
        searchUsers($searchString, $resultsPerPage, $page, $orderBy);
        break;
    default:
        echo json_encode("Error");
        break;
}

function searchQuestion($searchString, $selectedTags, $resultsPerPage, $page, $orderBy)
{
    $resultOffset = $resultsPerPage * ($page - 1);
    $results = searchQuestions($searchString, $selectedTags, $orderBy, $resultsPerPage, $resultOffset);
    $questions = $results['questions'];
    $numResults = $results['numResults'];

    $return = '<div class="panel panel-default">';

    foreach ($questions as $question) {
        $return .= '<div class="list-group-item">' .
            '<div class="row no-gutter no-side-margin">' .
            '<div class="col-xs-1">' .
            '<div class="text-center anchor clickable" href="/actions/add_vote.php?questionId=' . $question['id'] . '&vote=1">' .
            '<span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span></div>' .
            '<div class="text-center"><span>' . $question['rating'] . '</span></div>' .
            '<div class="text-center anchor clickable" href="/actions/add_vote.php?questionId=' . $question['id'] . '&vote=0">' .
            '<span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span></div>' .
            '</div>' .
            '<div class="col-xs-11 anchor clickable" href="question_page.php?id=' . $question['id'] . '">' .
            '<div class="col-xs-12">' .
            '<a class="small-text" href="../users/profile_page.php?id=' . $question['creatorId'] . '"><span>' . $question ['creatorName'] . '</span></a>' .
            '<span class="small-text"> | ' . $question['creationDate'] . '</span>' .
            '</div>' .
            '<span class="large-text col-xs-12">' . $question ['title'] . '</span>' .
            '</div>' .
            '</div>' .
            '</div>';
    }


    $pagination = '';

    if ($numResults === 0)
        $return = '<div class="list-group-item">No results found</div>';
    else
        $pagination = generatePagination($numResults, $resultsPerPage, $page);

    $return .= '</div>';

    echo $return . $pagination;
}

function generatePagination($numResults, $resultsPerPage, $currentPage)
{
    $numPages = ceil($numResults / $resultsPerPage);

    $before = '<nav id="pagination-nav" aria-label="Page navigation" class="text-center">' .
        '<ul id="pagination-list" class="pagination">' .
        '<li><span class="clickable" ' .
        ($currentPage !== 1 ? 'onclick="search(' . ($currentPage - 1) . ')"' : '') .
        'aria-hidden="true">&laquo;</span></li>';

    $inBetween = '';

    for ($i = 1; $i <= $numPages; $i++) {
        $inBetween = '<li' .
            ($currentPage === $i ? ' class="active"' : '') .
            '><span class="clickable" onclick="search(' . $i . ')">' . $i . '</span>' .
            '</li>';
    }

    $after = '<li><span class="clickable" ' .
        ($currentPage !== $numPages ? 'onclick="search(' . ($currentPage + 1) . ')"' : '') .
        'aria-hidden="true">&raquo;</span></li>' .

        '</ul>' .
        '</nav>';

    return $before . $inBetween . $after;
}

function searchUsers($searchString, $resultsPerPage, $page, $orderBy)
{
    $numResults = getNumberOfUsersByName($searchString)['count'];
    $resultOffset = $resultsPerPage * ($page - 1);

    if ($orderBy == 3 || $orderBy == 4)  // 3 == Order by Answers - Ascending | 4 == Order by Answers - Descending
        $users = getUserByNameOrderedByAnswers($searchString, $resultOffset, $resultsPerPage, $orderBy);
    else if ($orderBy == 1 || $orderBy == 2)  // 1 == Order by Questions - Ascending | 2 == Order by Questions - Descending
        $users = getUserByNameOrderedByQuestions($searchString, $resultOffset, $resultsPerPage, $orderBy);
    else  //No order
        $users = getUserByName($searchString, $resultOffset, $resultsPerPage);


    $return = '<div class="panel panel-default">';

    foreach ($users as $user) {
        $return .=
            '<div class="list-group-item">' .
            '<div class="row no-gutter no-side-margin">' .
            '<div class="col-xs-3">' .
            '<img class="center-block img-circle img-responsive img-user-search" src="/images/user-default.png">' .
            '</div>' .
            '<div class="col-xs-9 anchor clickable user-text" href="../users/profile_page.php?id=' . $user['id'] . '">' .
            '<span class="large-text col-xs-12">' . $user['name'] . '</span>' .
            '<span class="small-text col-xs-12">' . $user['email'] . '</span>' .
            '</div>' .
            '</div>' .
            '</div>';
    }

    $pagination = '';
    if ($numResults === 0)
        $return = '<div class="list-group-item">No results found</div>';
    else
        $pagination = generatePagination($numResults, $resultsPerPage, $page);

    $return .= '</div>';
    echo $return . $pagination;
}


