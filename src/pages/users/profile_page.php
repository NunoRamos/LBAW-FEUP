<?php
include_once '../../config/init.php';
include_once '../../database/users.php';
include_once '../../database/content.php';

$userId = intval(htmlspecialchars($_GET['id']));

if (!isset($userId)){
    $userId = 0;
}

$smarty->assign('user', getUserById($userId));

$smarty->assign('tags', getAllTags());
$smarty->assign('questions', getUserQuestions($userId));
$smarty->assign('numberQuestions', getNumberUserQuestions($userId));
$smarty->assign('questionsAnswered', getUserQuestionAnswered($userId));
$smarty->assign('numberQuestionsAnswered', getNumberUserReply($userId));


$smarty->display('users/profile_page.tpl');
