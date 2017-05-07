<?php
include_once '../../config/init.php';
include_once '../../database/content.php';
include_once '../../database/users.php';

$smarty->assign('reply', getMostRecentQuestions(10));
$smarty->assign('tags', getAllTags());
$smarty->display('misc/landing_page.tpl');
