<?php
include_once('../config/init.php');
include_once($BASE_DIR . 'database/users.php');

if (!$_POST['email'] || !$_POST['password']) {
    $_SESSION['error_messages']['sign-in'] = 'The email and password combination does not match.';

    if (empty($_SERVER['HTTP_REFERER']))
        header('Location: ../pages/misc/landing_page.php#sign-in');
    else
        signInFailed();

    exit;
}

$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

if (($user = login($email, $password)) !== false) {
    session_regenerate_id(true);
    $_SESSION['userId'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['privilegeLevelId'] = $user['privilegeLevelId'];
    $_SESSION['success_messages'][] = 'Sign in successful';
} else {
    $_SESSION['error_messages']['sign-in'][] = 'The email and password combination does not match.';
    signInFailed();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);


function signInFailed()
{
    $_SESSION['form_values']['sign-in'] = $_POST;

    if (strpos($_SERVER['HTTP_REFERER'], '#sign-in') === false)
        header("Location: " . $_SERVER['HTTP_REFERER'] . '#sign-in');
    else
        header("Location: " . $_SERVER['HTTP_REFERER']);

    exit;
}