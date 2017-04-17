<?php
include_once '../../config/init.php';
include_once '../../database/content.php';
include_once '../../database/users.php';

$smarty->assign('questions', getMostRecentQuestions(10));
$smarty->display('misc/landing_page.tpl');
