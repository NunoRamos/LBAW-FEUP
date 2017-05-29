<?php
include_once '../../config/init.php';
include_once '../../database/content.php';
include_once '../../database/users.php';

$userId = $smarty->getTemplateVars('USERID');

if (!isset($userId)){
    $userId = 0;
}

$smarty->assign('questions', getMostRecentQuestions(10,$userId));

$smarty->assign('tags', getMostUsedTags(5));
$smarty->display('misc/landing_page.tpl');
