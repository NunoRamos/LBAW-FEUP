<?php
include_once '../../config/init.php';
include_once($BASE_DIR . 'database/users.php');
include_once($BASE_DIR . 'database/content.php');
include_once($BASE_DIR . 'lib/search_type.php');
include_once($BASE_DIR . 'lib/question_search_order.php');
include_once($BASE_DIR . 'lib/user_search_order.php');

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

$smarty->assign('QUESTION_RATING_ASC', QuestionSearchOrder::RATING_ASC);
$smarty->assign('QUESTION_RATING_DESC', QuestionSearchOrder::RATING_DESC);
$smarty->assign('QUESTION_NUM_REPLIES_ASC', QuestionSearchOrder::NUM_REPLIES_ASC);
$smarty->assign('QUESTION_NUM_REPLIES_DESC', QuestionSearchOrder::NUM_REPLIES_DESC);
$smarty->assign('QUESTION_SIMILARITY', QuestionSearchOrder::SIMILARITY);

$smarty->assign('USER_NUM_QUESTIONS_ASC', UserSearchOrder::NUM_QUESTIONS_ASC);
$smarty->assign('USER_NUM_QUESTIONS_DESC', UserSearchOrder::NUM_QUESTIONS_DESC);
$smarty->assign('USER_NUM_REPLIES_ASC', UserSearchOrder::NUM_REPLIES_ASC);
$smarty->assign('USER_NUM_REPLIES_DESC', UserSearchOrder::NUM_REPLIES_DESC);
$smarty->assign('USER_JOIN_DATE_DESC', UserSearchOrder::JOIN_DATE_DESC);
$smarty->assign('USER_JOIN_DATE_ASC', UserSearchOrder::JOIN_DATE_ASC);

$smarty->display('content/search_results_page.tpl');
