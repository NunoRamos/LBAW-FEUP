<?php
include_once('../config/init.php');
include_once($BASE_DIR . 'database/content.php');

$userId = $_SESSION['userId'];

if (!isset($userId) || !isset($_POST['contentId'])) {
    http_response_code(403);
    exit;
}

$contentId = intval(htmlspecialchars($_POST['contentId']));

readNotification($userId, $contentId);
