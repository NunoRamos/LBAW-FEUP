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

$userId = $_SESSION['userId'];
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$bio = stripProhibitedTags($_POST['bio']);

try {
    editPersonalDetails($userId, $name, $email, $bio);
} catch (PDOException $e) {
    $_SESSION['error_messages']['personal-details'] = 'Chosen email is already in use.';
    redirect();
}

$_SESSION['email'] = $email;
$_SESSION['name'] = $name;

redirect();

function redirect()
{
    if (strpos($_SERVER['HTTP_REFERER'], '#personal-details') === false)
        header("Location: " . $_SERVER['HTTP_REFERER'] . '#personal-details');
    else
        header("Location: " . $_SERVER['HTTP_REFERER']);
}
