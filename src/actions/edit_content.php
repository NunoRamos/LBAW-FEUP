<?php
include_once ('../config/init.php');
include_once ($BASE_DIR . 'database/content.php');
include_once ($BASE_DIR . 'database/permissions.php');
include_once($BASE_DIR . 'lib/edit_content_type.php');

$userId = $smarty->getTemplateVars('USERID');

if (!isset($userId) || !isset($_POST['content-id'])){
    http_response_code(403);
    exit;
}

$contentId = intval(htmlspecialchars($_POST['content-id']));

if (!canEditContent($userId,$contentId)){
    http_response_code(403);
    exit;
}

switch ($_GET['edit-type']) {
    case EditContentType::TEXT:
        $text = stripProhibitedTags($_POST['content-text']);
        updateContentText($contentId,$text);
        break;
    case EditContentType::TITLE:
        break;
    case EditContentType::TAGS:
        break;
    default:
        break;
}

header('Location: ' . $_SERVER['HTTP_REFERER']);