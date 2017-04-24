$(document).ready(function () {
    clickEvent();
});

function clickEvent(){
    $('.anchor').on('click', function () {
        window.location.href = $(this).attr('href');
    });
}