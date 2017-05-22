<?php
include_once '../../config/init.php';
include_once '../../database/permissions.php';
include_once '../../database/content.php';
include_once '../../database/users.php';

if (is_array($_GET['id'])) {
    http_response_code(400);
    exit();
}

$contentId = intval(htmlspecialchars($_GET['id']));

/* The parameter is not an integer */
if ($contentId == 0) {
    http_response_code(400);
    exit();
}

$userId = $userId = $smarty->getTemplateVars('USERID');
$question = getQuestionFromContent($contentId, $userId);
$questionTags = getQuestionTags($contentId);

if (!isset($question['title'])) {
    http_response_code(400);
    exit();
}

readNotifications($question['contentId']);
$replies = getDescendantsOfContent($question['contentId'],$userId);
$question['children'] = $replies;

$smarty->assign('content', $question);
$smarty->assign('questionTags', $questionTags);
$smarty->display('content/question_page.tpl');

