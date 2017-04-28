<?php
include_once '../../config/init.php';
include_once($BASE_DIR .'database/users.php');

if (!$_GET['inputString'])
    $inputString = '';
else $inputString = $_GET['inputString'];

$smarty->assign('inputString', $inputString);

$smarty->display('content/search_results_page.tpl');
