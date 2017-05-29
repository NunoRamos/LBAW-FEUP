<?php
include_once('../config/init.php');
include_once($BASE_DIR . 'database/content.php');
include_once($BASE_DIR . 'database/permissions.php');
include_once($BASE_DIR . 'lib/edit_content_type.php');
include_once($BASE_DIR . 'lib/edit_question_tag_type.php');

$userId = $_SESSION['userId'];
$contentId = intval($_POST['contentId']);

if (!isset($userId) || !isset($_POST['editType']) || !canEditContent($userId, $contentId)) {
    http_response_code(403);
    exit;
}

switch ($_POST['editType']) {
    case EditQuestionTagType::ADD_TAGS:
        addTagsToQuestion($contentId, $_POST['tags']);
        break;
    case EditQuestionTagType::REMOVE_TAG:
        $tagId = intval($_POST['tagId']);
        removeTagFromQuestion($tagId, $contentId);
        break;
    default:
        break;
}


function addTagsToQuestion($contentId, $tags)
{
    foreach ($tags as $tag)
        addTagToQuestion($tag['id'], $contentId);

}