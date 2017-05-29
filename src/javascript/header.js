$(document).ready(function () {
    if (window.location.href.indexOf('#sign-up') !== -1) {
        $('#sign-in-modal').modal('show');
        $('#sign-up-tab').tab('show');
    }

    if (window.location.href.indexOf('#sign-in') !== -1) {
        $('#sign-in-modal').modal('show');
    }

    let notificationDropdown = $('#notification-dropdown');
    notificationDropdown.on('show.bs.dropdown', getNotifications);
    notificationDropdown.on('hidden.bs.dropdown', deleteNotifications);
});

function createErrorMessage(message) {
    return $('<div class="alert alert-danger" role="alert">' +
        '<span class="text-center">' + message +
        '</span>' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span' +
        'aria-hidden="true">&times;</span></button>' +
        '</div>');
}

function validateSignUp() {
    let password = $("#password").val();
    let repeatPassword = $("#repeat-password").val();
    let errorAlert = $("#sign-up-errors");
    errorAlert.children().remove();

    if (password.length < 8) {
        errorAlert.append(createErrorMessage("Password needs to be greater or equal to 8 characters"));
        return false;
    }

    if (repeatPassword !== password) {
        errorAlert.append(createErrorMessage("Passwords do not match"));
        return false;
    }

    return true;
}

function getNotifications() {
    $.ajax('../../api/get_notifications.php').done(function (data) {
        let notifications = JSON.parse(data);

        if (notifications.length === 0) {
            $('#notification-menu').append(
                '<li class="notification"><span>No unread notifications!</span></li>' +
                '<li class="divider"></li>'
            );
        }

        for (let notification of notifications) {
            if (notification.hasOwnProperty('contentId') && notification.hasOwnProperty('text'))
                $('#notification-menu').append(
                    '<li class="notification"><a href="../content/question_page.php?id=' + notification.contentId + '">' + notification.text + '</a></li>' +
                    '<li class="divider"></li>'
                );
        }

       console.log( $('#notification-menu').append(
            '<li class="text-center"><a href="../content/notifications_page.php">View All Notifications</a></li>'));

    }).fail(function () {
        $('#notification-menu').append('<li class="dropdown-header">Could not get notifications.</li>');
    });
}

function deleteNotifications() {
    $('#notification-menu li.divider ~ li').remove();
}
