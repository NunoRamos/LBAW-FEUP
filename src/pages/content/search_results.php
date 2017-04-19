<?php
include_once '../../config/init.php';
include_once($BASE_DIR .'database/users.php');

$smarty->display('content/search_results_page.tpl');
