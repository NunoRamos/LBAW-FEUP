$(document).ready(function () {
    addEventToClickableElements();
});

function addEventToClickableElements() {
    $('.anchor').on('click', function () {
        window.location.href = $(this).attr('href');
    });
}