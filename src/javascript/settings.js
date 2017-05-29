const SEARCH_FOR_TAGS = 1;
const SEARCH_FOR_USERS = 0;
let currentPage = 1;
const resultsPerPage = 5;
const tagsPerPage = 12;
let searchType = 0;

$(document).ready(function () {
    $('#bio').trumbowyg();
    $('#settings-tabs').find('a.list-group-item.highlight').on('show.bs.tab', changeTab);

    if (window.location.href.indexOf('#personal-details') !== -1)
        $('a[href="#personal-details"]').tab('show');
    else if (window.location.href.indexOf('#update-picture') !== -1)
        $('a[href="#update-picture"]').tab('show');
    else if (window.location.href.indexOf('#account-settings') !== -1)
        $('a[href="#account-settings"]').tab('show');
    else if (window.location.href.indexOf('moderation-area') !== -1)
        $('a[href="#moderation-area"]').tab('show');
    else if (window.location.href.indexOf('administration-area') !== -1)
        $('a[href="#administration-area"]').tab('show');


search()
});

function changeTab(e) {
    $(e.target).siblings().removeClass('selected');
    $(e.target).addClass('selected');
}

function validatePassword() {
    const newPassword = $("#new-password").val();
    const repeatPassword = $("#new-repeat-password").val();
    const errorMessage = $("#password-error-message");

    errorMessage.children().remove();

    if (newPassword.length < 8) {
        errorMessage.append(createErrorMessage('New password must be at least 8 characters long.'));
        return false;
    }


    if (repeatPassword !== newPassword) {
        errorMessage.append(createErrorMessage('Passwords do not match.'));
        return false;
    }


    return true;
}

function removePendingTag(id) {

    $.ajax({
        method: "GET",
        url: "../../api/remove_pending_tag.php",
        data: {
            id: id,
        }
    }).done(removePendingTagDiv(id));

}

function addPendingTag(id) {

    $.ajax({
        method: "GET",
        url: "../../api/add_tag.php",
        data: {
            id: id,
        }
    }).done(removePendingTagDiv(id));
}

function removePendingTagDiv(id) {
    $('div[data-tag-id=' + id + ']').remove();
}

function unbanUser(id) {


    $.ajax({
        method: "GET",
        url: "../../api/unban_user.php",
        data: {
            id: id,
        }
    }).done(removeBannedUserDiv(id));

}

function removeBannedUserDiv(id) {
    $("#ban-user-tr-" + id).remove();
}

function previewFile() {
    var preview = document.querySelector('#upload'); //selects the query named img
    var file = document.querySelector('input[type=file]').files[0]; //sames as here
    var reader = new FileReader();
    var extension = file.name.substring(file.name.lastIndexOf('.'));
    reader.onloadend = function () {


        // Only process image files.
        var validFileType = ".jpg , .png , .jpeg";
        if (!(validFileType.toLowerCase().indexOf(extension) < 0)) {

        preview.src = reader.result;}
    }

    if (file) {
        reader.readAsDataURL(file); //reads the data as a URL
    } else {
        preview.src = "";
    }
}

function uploadImage() {
    $("#fileToUpload").trigger('click');
}
function createErrorMessage(message) {
    return $('<div class="alert alert-danger" role="alert">' +
        '<span class="text-center">' + message +
        '</span>' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span' +
        'aria-hidden="true">&times;</span></button>' +
        '</div>');
}


function changeTypeToBanUsers() {
    searchType = SEARCH_FOR_USERS;
    search();
}


function changeTypeToPendingTags() {
    searchType = SEARCH_FOR_TAGS;
    search();
}

    function search() {

    if(searchType == SEARCH_FOR_USERS) {

        $.ajax({
            url: "../../api/search_banned_users.php",
            dataType: "html",
            data: {
                page: currentPage,
                resultsPerPage: resultsPerPage
            }
        }).done(insertSearchBannedUsers)

    }else if (searchType == SEARCH_FOR_TAGS){
        $.ajax({
            url: "../../api/search_pending_tags.php",
            dataType: "html",
            data: {
                page: currentPage,
                resultsPerPage: tagsPerPage
            }
        }).done(insertSearchPendingTags)

    }

    }

    function insertSearchBannedUsers(response) {
    const searchBarContainer = $('#title-admin');
    searchBarContainer.siblings().remove();


    searchBarContainer.after(response);
    addEventToClickableElements();
}
function insertSearchPendingTags(response) {
    const searchBarContainer = $('#title-moderator');
    searchBarContainer.siblings().remove();


    searchBarContainer.after(response);
    addEventToClickableElements();
}