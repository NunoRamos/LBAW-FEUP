<?php
include_once('../config/init.php');
include_once($BASE_DIR . 'database/content.php');

$userId = $_SESSION['userId'];
$contentId = intval($_POST['contentId']);

if (!isset($contentId)) {
    http_response_code('400');
    exit;
}

unfollowContent($userId, $contentId);
