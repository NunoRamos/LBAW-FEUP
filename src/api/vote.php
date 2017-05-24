<?php
include_once '../config/init.php';
include_once '../database/content.php';

if (!isset($_GET['contentId']) || !isset($_GET['isPositive']) || !isset($_GET['userId'])) {
    http_response_code(403);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

$contentId = htmlspecialchars($_GET['contentId']);
$userId = htmlspecialchars($_GET['userId']);
$isPositive = htmlspecialchars($_GET['isPositive']);

if ($isPositive != 0 && $isPositive != 1)
    exit;

if (isset($userId) && isset($contentId))
    vote($userId, $contentId, $isPositive);
