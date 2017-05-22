<?php
include_once '../config/init.php';
include_once '../database/content.php';

if (!isset($_GET['contentId'])) {
    exit;
}

$contentId = htmlspecialchars($_GET['contentId']);

$users = getVotedUsers($contentId);

$smarty->assign('users', $users);

$smarty->display('content/modal_content_votes.tpl');