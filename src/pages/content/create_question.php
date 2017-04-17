<?php
include_once '../../config/init.php';
include_once '../../database/users.php';
include_once '../../database/content.php';

$userId = $smarty->getTemplateVars('USERID');
if (isset($userId))
    $smarty->display('content/create_question_page.tpl');
else
    http_response_code(403);