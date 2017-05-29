<?php
include_once '../config/init.php';
include_once '../database/users.php';
include_once '../database/content.php';
include_once '../database/permissions.php';

global $lastToken;
$token = $_POST['token'];

if (strcmp($lastToken, $token) !== 0) {
    http_response_code(403);
    exit;
}

$userId = $smarty->getTemplateVars('USERID');

$currPassword = htmlspecialchars($_POST['curr-password']);
$newPassword = htmlspecialchars($_POST['new-password']);
$repeatPassword = htmlspecialchars($_POST['repeat-password']);

if (strlen($newPassword) < 8)
    $_SESSION['error_messages']['account-settings'] = 'New password must be at least 8 characters long.';
if (!checkCurrentPassword($userId, $currPassword))
    $_SESSION['error_messages']['account-settings'] = 'The password provided does not match your current password.';
else if (strcmp($newPassword, $repeatPassword) !== 0)
    $_SESSION['error_messages']['account-settings'] = 'New password and its repetition do not match.';
else
    changePassword($userId, $newPassword);

if (strpos($_SERVER['HTTP_REFERER'], '#account-settings') === false)
    header("Location: " . $_SERVER['HTTP_REFERER'] . '#account-settings');
else
    header("Location: " . $_SERVER['HTTP_REFERER']);
