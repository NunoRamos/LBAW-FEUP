<?php
include_once('../config/init.php');
include_once($BASE_DIR . 'database/users.php');


if (!$_POST['expires'] || !$_POST['reason']) {
    $_SESSION['error_messages']['ban-user'][] = 'All fields are mandatory';

    if (empty($_SERVER['HTTP_REFERER']))
        header('Location: ../pages/users/profile_page.php#ban-user');
    else
        banUserFailed();

    exit;
}

$id =  htmlspecialchars($_POST['id']);
$explanation = htmlspecialchars($_POST['explanation']);
$reason = htmlspecialchars($_POST['reason']);
$expires = htmlspecialchars($_POST['expires']);

try {
    $ban = banUser($explanation, $expires, $reason,$id);
    $_SESSION['success_messages'][] = 'Ban User successful';
} catch (PDOException $e) {
    banUserFailed();

}

header("Location:" . $_SERVER['HTTP_REFERER']);


function banUserFailed()
{
    $_SESSION['form_values']['ban-user'] = $_POST;

    if (strpos($_SERVER['HTTP_REFERER'], '#ban-user') === false)
        header("Location: " . $_SERVER['HTTP_REFERER'] . '#ban-user');
    else
        header("Location: " . $_SERVER['HTTP_REFERER']);

    exit;
}