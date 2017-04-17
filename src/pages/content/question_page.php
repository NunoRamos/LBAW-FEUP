<?php
include_once '../../config/init.php';
include_once '../../database/permissions.php';
include_once '../../database/content.php';
include_once '../../database/users.php';

if (is_array($_GET['id']))
    http_response_code(400);

$questionId = intval(htmlspecialchars($_GET['id']));

if ($questionId == 0) {
    http_response_code(400);
} else {
    $smarty->assign('content', getQuestion($questionId));
    $smarty->assign('answers', getDescendantsOfContent($questionId));
    $smarty->display('content/question_page.tpl');
}
