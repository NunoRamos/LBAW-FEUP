<?php
include_once ('../config/init.php');
include_once ($BASE_DIR . 'database/content.php');
include_once ($BASE_DIR . 'database/permissions.php');
include_once($BASE_DIR . 'lib/edit_content_type.php');
include_once($BASE_DIR . 'lib/edit_question_tag_type.php');

$userId = $smarty->getTemplateVars('USERID');

if (!isset($userId) || !isset($_POST['editType'])){
    http_response_code(403);
    exit;
}

switch ($_POST['editType']) {
    case EditQuestionTagType::ADD_TAGS:
        break;
    case EditQuestionTagType::REMOVE_TAG:
        $tagId = intval($_POST['tagId']);
        $contentId = intval($_POST['contentId']);
        removeTagFromQuestion($tagId, $contentId);
        break;
    default:
        break;
}