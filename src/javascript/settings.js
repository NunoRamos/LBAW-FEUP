$(document).ready(function () {
    $('.nav .list-group-item:first').addClass('active');
    $('.settings-tab').slice(1).hide();
    $('#edit-profile-nav a').click(function (event) {
        event.preventDefault();
        var content = $(this).attr('href');
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
        $(content).show();
        $(content).siblings('.tab-content').hide();
    });
});

function validatePassword() {
    let password = $("#new-password").val();
    let repeatPassword = $("#new-repeat-password").val();
    let errorMessage = $("#new-password-failed");

    console.log("entrou");

    if (repeatPassword !== password) {
        errorMessage.text("Passwords do not match");
        errorMessage.show();
        return false;
    }

    return true;
}