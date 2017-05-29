
$(document).ready(function () {


  getUnreadNotifications();
  getReadNotifications();
});


function getUnreadNotifications() {
    $.ajax('../../api/get_notifications.php').done(function (data) {
        let notifications = JSON.parse(data);

        if (notifications.length === 0) {
            $('#notification-unread').append(
                '<li class="list-group-item"><span>No unread notifications!</span></li>'

            );
        }

        for (let notification of notifications) {
            if (notification.hasOwnProperty('contentId') && notification.hasOwnProperty('text'))
                $('#notification-unread').append(
                    '<li class="list-group-item"><a href="../content/question_page.php?id=' + notification.contentId + '">' + notification.text + '</a></li>'

                );
        }

    });
}

function getReadNotifications() {
    $.ajax('../../api/get_read_notifications.php').done(function (data) {
        let notifications = JSON.parse(data);

        if (notifications.length === 0) {
            $('#notification-read').append(
                '<li class="list-group-item"><span>No read notifications!</span></li>'

            );
        }

        for (let notification of notifications) {
            if (notification.hasOwnProperty('contentId') && notification.hasOwnProperty('text'))
                $('#notification-read').append(
                    '<li class="list-group-item"><a href="../content/question_page.php?id=' + notification.contentId + '">' + notification.text + '</a></li>'

                );
        }

    });
}

