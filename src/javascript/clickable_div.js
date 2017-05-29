$(document).ready(function () {
    addEventToClickableElements();
});

function addEventToClickableElements() {
    $('.anchor').on('click', function () {

        let href = $(this).attr('href');

        if (typeof href === 'undefined') {
            return;
        }

        window.location.href = href;
    });
}