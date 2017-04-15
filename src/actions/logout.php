<?php
include_once('../config/init.php');

$_SESSION = array();
session_regenerate_id(true);

header("Location:" . $smarty->getTemplateVars('BASE_URL'));