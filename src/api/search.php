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

$offset = $resultsPerPage * ($page - 1);

$smarty->assign('resultsPerPage', $resultsPerPage);
$smarty->assign('currentPage', $page);

$userId = $userId = $smarty->getTemplateVars('USERID');

switch ($_GET['searchType']) {
    case SearchType::QUESTIONS:
        $results = searchQuestions($searchString, $selectedTags, $orderBy, $resultsPerPage, $offset, $userId);
        $smarty->assign('numResults', $results['numResults']);
        $smarty->assign('questions', $results['questions']);
        break;
    case SearchType::USERS:
        $results = getOrderedUsersByName($searchString, $offset, $resultsPerPage, $orderBy);
        $smarty->assign('numResults', $results['numResults']);
        $smarty->assign('users', $results['users']);
        break;
    default:
        $smarty->assign('numResults', 0);
        break;
}

$smarty->display('content/search_results.tpl');
