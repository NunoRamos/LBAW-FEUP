<?php
include_once '../config/init.php';
include_once '../database/users.php';
include_once '../database/content.php';
include_once '../database/permissions.php';

$userId = $smarty->getTemplateVars('USERID');


$photo = htmlspecialchars($_FILES["fileToUpload"]["name"]);
$target_dir = "../images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {

}


if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        editPhoto($userId, $photo);

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


header('Location: ' . $smarty->getTemplateVars('BASE_URL') . 'pages/users/settings_page.php');



