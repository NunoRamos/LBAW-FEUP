<?php
include_once('../config/init.php');

unset($_SESSION['email']);
unset($_SESSION['name']);

header("Location:" . $_SERVER['HTTP_REFERER']);