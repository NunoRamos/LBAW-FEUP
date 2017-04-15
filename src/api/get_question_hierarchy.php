<?php
include_once('../config/init.php');
include_once($BASE_DIR .'database/questions.php');

echo json_encode(getQuestionHierarchy(htmlspecialchars($_GET['id'])));
