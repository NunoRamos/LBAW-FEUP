<?php
include_once('../config/init.php');
include_once($BASE_DIR .'database/users.php');

if (!$_POST['name'] || !$_POST['email'] || !$_POST['password']) {
    $_SESSION['error_messages'][] = 'All fields are mandatory';
    $_SESSION['form_values'] = $_POST;
    header("Location:" . $_SERVER['HTTP_REFERER']);
    exit;
}

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$privilegeLevelId = 1;

$password_hash = password_hash($password,PASSWORD_DEFAULT);

try {
    createUser($email,$password_hash,$name,$privilegeLevelId);
} catch (PDOException $e){
    if(strpos($e->getMessage(),'User_email_key')){
        $_SESSION['error_messages'][] = 'Duplicate email';
        $_SESSION['field_errors']['email'] = 'Email already exists';
    }
}

$_SESSION['email'] = $email;
$_SESSION['name'] = $name;
$_SESSION['privilegeLevelId'] = $privilegeLevelId;

header("Location:" . $_SERVER['HTTP_REFERER']);