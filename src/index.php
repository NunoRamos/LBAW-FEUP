<?php
require 'libs/Smarty.class.php';

$smarty = new Smarty;

$smarty->assign("page_title", "Reply Planet");
$smarty->assign("page_content", "Smarty Test");

$smarty->display('templates/index.tpl');
?>