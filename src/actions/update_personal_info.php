<?php
include_once '../config/init.php';
include_once '../database/users.php';
include_once '../database/content.php';
include_once '../database/permissions.php';

$userId = $smarty->getTemplateVars('USERID');

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$bio = htmlspecialchars($_POST['bio']);

editName($userId,$name);
editBio($userId,$bio);
editEmail($userId,$email);

header('Location: ' . $smarty->getTemplateVars('BASE_URL')  . 'src/pages/users/settings_page.php');



