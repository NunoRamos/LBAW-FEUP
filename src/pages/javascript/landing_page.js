$(document).ready(function () {
    $('.anchor').on('click', function () {
        window.location.href = $(this).attr('href');
    });
});