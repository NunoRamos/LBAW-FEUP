<?php
include_once '../../config/init.php';
include_once($BASE_DIR .'database/users.php');

if (!$_GET['inputString']) {
    $_SESSION['error_messages'][] = 'All fields are mandatory';
    $_SESSION['form_values'] = $_POST;
    header("Location:" . $_SERVER['HTTP_REFERER']);
    exit;
}

$inputString = $_GET['inputString'];

$smarty->assign('inputString', $inputString);

$smarty->display('content/search_results_page.tpl');
