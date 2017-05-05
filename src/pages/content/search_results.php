<?php
include_once '../../config/init.php';
include_once($BASE_DIR .'database/users.php');
include_once($BASE_DIR .'database/content.php');

if(!isset($_GET['inputString']))
    $inputString = '';
else $inputString = $_GET['inputString'];

$allTags = getAllTags();

if(isset($_GET['activeTags'])){
    $activeTags = $_GET['activeTags'];
    $smarty->assign('selectedTag', $activeTags);
    //Removing selected tags
    unset($allTags[array_search($activeTags, $allTags)]);
}

$smarty->assign('inputString', $inputString);

$smarty->assign('tags', $allTags);

$smarty->display('content/search_results_page.tpl');
