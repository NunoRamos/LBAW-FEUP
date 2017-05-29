<?php
include_once('../config/init.php');
include_once($BASE_DIR . 'database/users.php');

global $lastToken;
$token = $_POST['token'];

if (strcmp($lastToken, $token) !== 0) {
    http_response_code(403);
    exit;
}

if (!$_POST['name'] || !$_POST['email'] || !$_POST['password']) {
    $_SESSION['error_messages']['sign-up'][] = 'All fields are mandatory';

    if (empty($_SERVER['HTTP_REFERER']))
        header('Location: ../pages/misc/landing_page.php#sign-up');
    else
        signUpFailed();

    exit;
}

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$repeatPassword = htmlspecialchars($_POST['repeat-password']);

if (strlen($password) < 8) {
    $_SESSION['error_messages']['sign-up'][] = 'Password is too short.';
    $_SESSION['field_errors']['sign-up']['password'] = 'Password is too short.';
    signUpFailed();
}

if (strcmp($password, $repeatPassword) !== 0) {
    $_SESSION['error_messages']['sign-up'][] = 'Passwords do not match.';
    $_SESSION['field_errors']['sign-up']['password'] = 'Passwords do not match.';
    signUpFailed();
}

try {
    $user = register($email, $password, $name);
    session_regenerate_id(true);
    $_SESSION['userId'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['privilegeLevelId'] = $user['privilegeLevelId'];
    $_SESSION['success_messages'][] = 'Sign up successful';
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'User_email_key')) {
        $_SESSION['error_messages']['sign-up'][] = 'Email already in use.';
        $_SESSION['field_errors']['sign-up']['email'] = 'Email already in use.';
    }
    signUpFailed();
}

header("Location:" . $_SERVER['HTTP_REFERER']);


function signUpFailed()
{
    $_SESSION['form_values']['sign-up'] = $_POST;

    if (strpos($_SERVER['HTTP_REFERER'], '#sign-up') === false)
        header("Location: " . $_SERVER['HTTP_REFERER'] . '#sign-up');
    else
        header("Location: " . $_SERVER['HTTP_REFERER']);

    exit;
}