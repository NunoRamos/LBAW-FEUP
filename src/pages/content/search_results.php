<?php
include_once '../../config/init.php';
include_once($BASE_DIR .'database/users.php');
include_once($BASE_DIR .'database/content.php');

if (!$_GET['inputString'])
    $inputString = '';
else $inputString = $_GET['inputString'];

$smarty->assign('inputString', $inputString);
$smarty->assign('tags', getAllTags());

$smarty->display('content/search_results_page.tpl');
