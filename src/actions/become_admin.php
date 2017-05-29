<?php
include_once '../config/init.php';
include_once '../database/users.php';
include_once '../database/content.php';
include_once '../database/permissions.php';

$userId = $smarty->getTemplateVars('USERID');


becomeAdmin($userId);

header('Location: ' . $smarty->getTemplateVars('BASE_URL')  . 'src/pages/users/settings_page.php');



