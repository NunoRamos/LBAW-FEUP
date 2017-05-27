<?php
include_once('../config/init.php');
include_once($BASE_DIR . 'database/users.php');
include_once($BASE_DIR . 'database/content.php');
include_once($BASE_DIR . 'lib/question_search_order.php');
include_once($BASE_DIR . 'lib/user_search_order.php');
include_once($BASE_DIR . 'lib/search_type.php');


$resultsPerPage = intval(htmlspecialchars($_GET['resultsPerPage']));
if (!is_integer($resultsPerPage) || $resultsPerPage < 1)
    $resultsPerPage = 5;

$page = intval(htmlspecialchars($_GET['page']));
if (!is_integer($page) || $page < 1)
    $page = 1;



$offset = $resultsPerPage * ($page - 1);

$smarty->assign('resultsPerPage', $resultsPerPage);
$smarty->assign('currentPage', $page);

$userId = $userId = $smarty->getTemplateVars('USERID');

        $banned = getAllBannedUsers();
        //$results = getOrderedAllBannedUsers($offset, $resultsPerPage);
      //  $smarty->assign('numResults', $results['numResults']);
        $smarty->assign('users', $banned);


$smarty->display('content/admin_tab.tpl');
