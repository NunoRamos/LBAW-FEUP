$(document).ready(function () {
    if (window.location.href.indexOf('#signup') != -1) {
        $('#sign-in-modal').modal('show');
        console.log($('#sign-up'));
        $('#sign-up-tab').tab('show');
    }

    if (window.location.href.indexOf('#signin') != -1) {
        $('#sign-in-modal').modal('show');
    }

    let notificationDropdown = $('#notification-dropdown');
    notificationDropdown.on('show.bs.dropdown', getNotifications);
    notificationDropdown.on('hidden.bs.dropdown', deleteNotifications);
});

function validateSignUp() {
    let password = $("#password").val();
    let repeatPassword = $("#repeat-password").val();
    let errorMessage = $("#register-failed");

    if (password.length < 8) {
        errorMessage.text("Password needs to be greater or equal to 8 characters");
        errorMessage.show();
        return false;
    }

    if (repeatPassword !== password) {
        errorMessage.text("Passwords do not match");
        errorMessage.show();
        return false;
    }

    return true;
}

function getNotifications() {
    $.ajax('../../api/get_notifications.php').done(function (data) {
        let notifications = JSON.parse(data);

        for (let notification of notifications) {
            if (notification.hasOwnProperty('contentId') && notification.hasOwnProperty('text'))
                $('#notification-menu').append(
                    '<li class="notification"><a href="/pages/content/question_page.php?id=' + notification.contentId + '">' + notification.text + '</a></li>' +
                    '<li class="divider"></li>'
                );
        }

    }).fail(function () {
        $('#notification-menu').append('<li class="dropdown-header">Could not get notifications...</li>');
    });
}

function deleteNotifications() {
    $('#notification-menu li.divider ~ li').remove();
}
