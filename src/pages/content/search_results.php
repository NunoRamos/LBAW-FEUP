<?php
include_once '../../config/init.php';
include_once($BASE_DIR . 'database/users.php');
include_once($BASE_DIR . 'database/content.php');
include_once($BASE_DIR . 'lib/search_type.php');
include_once($BASE_DIR . 'lib/order.php');

if (!isset($_GET['inputString']))
    $inputString = '';
else $inputString = $_GET['inputString'];

$allTags = getAllTags();

if (isset($_GET['activeTags'])) {
    $activeTags = $_GET['activeTags'];
    $smarty->assign('selectedTag', $activeTags);
    //Removing selected tags
    unset($allTags[array_search($activeTags, $allTags)]);
}

$smarty->assign('inputString', $inputString);
$smarty->assign('tags', $allTags);
$smarty->assign('SEARCH_FOR_QUESTIONS', SearchType::QUESTIONS);
$smarty->assign('SEARCH_FOR_USERS', SearchType::USERS);
$smarty->assign('RATING_ASC', Order::RATING_ASC);
$smarty->assign('RATING_DESC', Order::RATING_DESC);
$smarty->assign('NUM_REPLIES_ASC', Order::NUM_REPLIES_ASC);
$smarty->assign('NUM_REPLIES_DESC', Order::NUM_REPLIES_DESC);
$smarty->assign('SIMILARITY', Order::SIMILARITY);

$smarty->display('content/search_results_page.tpl');
