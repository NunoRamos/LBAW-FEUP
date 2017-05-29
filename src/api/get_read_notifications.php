<?php
include_once('../config/init.php');
include_once($BASE_DIR . 'database/users.php');
include_once($BASE_DIR . 'database/content.php');

if (!isset($_SESSION['userId'])) {
    http_response_code(403);
    exit();
}


$userId = $_SESSION['userId'];
$notifications = getReadNotifications($_SESSION['userId']);
$return = Array();

foreach ($notifications as $notification) {
    $notificationContent = ['date' => $notification['date']];

    if ($notification['contentId'] != null) {
        $question = getQuestionFromContent($notification['contentId'], $userId);
        $notificationContent['text'] = getUserNameById($notification['triggererId']) . ' replied to your question "' . $question['title'] . '".';
        $notificationContent['contentId'] = $notification['contentId'];
    } else {
        $notificationContent['text'] = getUserNameById($notification['triggererId']) . ' voted on your content.';
        $notificationContent['contentId'] = getVoteTarget($notification['voteId'])['contentId'];
    }

    $return[] = $notificationContent;
}

echo json_encode($return);
