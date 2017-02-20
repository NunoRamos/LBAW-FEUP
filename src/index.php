<?php
require 'libs/Smarty.class.php';

$smarty = new Smarty;

$smarty->assign("page_title", "Reply Planet");

switch ($_GET['page']) {
    case 'question_page':
        $smarty->display('templates/question_page.tpl');
        break;
    default:
        $smarty->display('templates/landing_page.tpl');
        break;
}
