<?php
//session_set_cookie_params(3600, '/~lbaw1612');
session_start();

error_reporting(E_ERROR | E_WARNING); // E_NOTICE by default

$BASE_DIR = '/home/nuno/Documents/GitHub/LBAW-FEUP/src/';
$BASE_URL = '/';

$conn = new PDO('pgsql:host=dbm.fe.up.pt;dbname=lbaw1612', 'lbaw1612', 'password');
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$conn->exec('SET SCHEMA \'public\'');

include_once($BASE_DIR . 'lib/smarty/Smarty.class.php');

$smarty = new Smarty;
$smarty->template_dir = $BASE_DIR . 'templates/';
$smarty->compile_dir = $BASE_DIR . 'templates_c/';
$smarty->assign('BASE_URL', $BASE_URL);

$smarty->assign('ERROR_MESSAGES', $_SESSION['error_messages']);
$smarty->assign('FIELD_ERRORS', $_SESSION['field_errors']);
$smarty->assign('SUCCESS_MESSAGES', $_SESSION['success_messages']);
$smarty->assign('FORM_VALUES', $_SESSION['form_values']);
$smarty->assign('USERID', $_SESSION['userId']);
$smarty->assign('EMAIL', $_SESSION['email']);
$smarty->assign('NAME', $_SESSION['name']);
$smarty->assign('PRIVILEGELEVELID', $_SESSION['privilegeLevelId']);

unset($_SESSION['success_messages']);
unset($_SESSION['error_messages']);
unset($_SESSION['field_errors']);
unset($_SESSION['form_values']);
unset($_SESSION['userId']);
unset($_SESSION['email']);
unset($_SESSION['name']);
unset($_SESSION['privilegeLevelId']);

