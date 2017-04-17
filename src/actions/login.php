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

$user = getUserByEmail($email);

if($user){
    if(password_verify($password,$user['password'])){
        session_regenerate_id(true);
        $_SESSION['userId'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['privilegeLevelId'] = $user['privilegeLevelId'];
        $_SESSION['success_messages'][] = 'Login successful';
    } else {
        $_SESSION['error_messages'][] = 'Login failed';
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);