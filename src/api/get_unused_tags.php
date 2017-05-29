<?php
include_once('../config/init.php');
include_once($BASE_DIR . 'database/content.php');
include_once($BASE_DIR . 'database/permissions.php');

$contentId = intval($_GET['contentId']);

if (!isset($contentId)) {
    http_response_code(403);
    exit;
}

echo json_encode(getAllTagsExceptQuestionTags($contentId));
