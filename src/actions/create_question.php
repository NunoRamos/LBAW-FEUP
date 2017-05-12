<?php
include_once '../config/init.php';
include_once '../database/users.php';
include_once '../database/content.php';
include_once '../database/permissions.php';

$userId = $smarty->getTemplateVars('USERID');

$text = stripProhibitedTags($_POST['question-text']);
$title = htmlspecialchars($_POST['title']);
$tags = $_POST['tags'];

if (is_array($tags)) {
    foreach ($tags as $tag)
        $tag = htmlspecialchars($tag);
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}


if (canCreateQuestion($userId)) {
    $questionId = createQuestion($userId, (new \DateTime())->format('Y-m-d H:i:s'), $text, $title, $tags);
    header('Location: ' . $smarty->getTemplateVars('BASE_URL') . 'pages/content/question_page.php?id=' . $questionId);
} else {
    header('Location: ' . $smarty->getTemplateVars('BASE_URL') . 'pages/content/create_question.php');
}


