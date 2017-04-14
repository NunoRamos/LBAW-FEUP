<?php
include_once('../config/init.php');
include_once($BASE_DIR .'database/users.php');

if (!$_POST['email'] || !$_POST['password']) {
    $_SESSION['error_messages'][] = 'Invalid login';
    $_SESSION['form_values'] = $_POST;
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

$result = getUser($email);

if($result){
    if(password_verify($password,$result['password'])){
        $_SESSION['email'] = $result['email'];
        $_SESSION['name'] = $result['name'];
        $_SESSION['privilegeLevelId'] = $result['privilegeLevelId'];
        $_SESSION['success_messages'][] = 'Login successful';
    } else {
        $_SESSION['error_messages'][] = 'Login failed';
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);