<?php
include_once '../../config/init.php';
include_once($BASE_DIR .'database/users.php');
include_once($BASE_DIR .'database/content.php');

$smarty->display('users/profile_page.tpl');
