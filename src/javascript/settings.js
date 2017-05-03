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