<?php
include_once('../config/init.php');
include_once($BASE_DIR . 'database/users.php');

if (!$_POST['name'] || !$_POST['email'] || !$_POST['password']) {
    $_SESSION['error_messages'][] = 'All fields are mandatory';
    $_SESSION['form_values'] = $_POST;
    if(empty($_SERVER['HTTP_REFERER']))
        header('Location: ../pages/misc/landing_page.php');
    else
        header("Location:" . $_SERVER['HTTP_REFERER']);

    exit;
}

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

try {
    $user = register($email, $password,$name);
    session_regenerate_id(true);
    $_SESSION['userId'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['privilegeLevelId'] = $user['privilegeLevelId'];
    $_SESSION['success_messages'][] = 'Sign up successful';
} catch (PDOException $e){
    if(strpos($e->getMessage(),'User_email_key')){
        $_SESSION['error_messages'][] = 'Duplicate email.';
        $_SESSION['field_errors']['email'] = 'Email already exists.';
    }
}

header("Location:" . $_SERVER['HTTP_REFERER']);