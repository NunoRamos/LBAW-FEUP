<?php
include_once '../config/init.php';
include_once '../database/content.php';

if (!isset($_GET['id'])) {
    exit;
}

$id = htmlspecialchars($_GET['id']);


unbanUser($id);

