<?php
include_once('../config/init.php');
include_once($BASE_DIR . 'database/users.php');

if (!isset($_SESSION['userId'])) {
    http_response_code(403);
    exit();
}


$notifications = getUnreadNotifications($_SESSION['userId']);
$return = Array();

foreach ($notifications as $notification) {
    $notificationContent = ['date' => $notification['date']];

    if ($notification['contentId'] != null) {
        $notificationContent['text'] = 'Someone replied to your question.';
        $notificationContent['contentId'] = $notification['contentId'];
    } else {
        $notificationContent['text'] = 'Someone voted on your content.';
        $notificationContent['contentId'] = getVoteTarget($notification['voteId']);
    }

    $return[] = $notificationContent;
}

echo json_encode($return);
