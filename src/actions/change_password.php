<?php
include_once '../config/init.php';
include_once '../database/users.php';
include_once '../database/content.php';
include_once '../database/permissions.php';

$userId = $smarty->getTemplateVars('USERID');

$currPassword = htmlspecialchars($_POST['curr-password']);
$newPassword = htmlspecialchars($_POST['new-password']);

$smarty->assign('ERROR_PASSOWORD', '-1');
header('Location: ' . $smarty->getTemplateVars('BASE_URL')  . 'src/pages/users/settings_page.php');
if (!checkCurrentPassword($userId,$newPassword))
if(checkCurrentPassword($userId,$currPassword)) {
    changePassword($userId, $newPassword);
    header('Location: ' . $smarty->getTemplateVars('BASE_URL')  . 'src/pages/users/profile_page.php');
}else
    header('Location: ' . $smarty->getTemplateVars('BASE_URL')  . 'src/pages/users/settings_page.php');
else{

}








