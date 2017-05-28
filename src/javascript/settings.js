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

   /* var thumb = $('#thumb');

    new AjaxUpload('imageUpload', {
        action: $('#newHotnessForm').attr('action'),
        name: 'image',
        onSubmit: function(file, extension) {
            $('#preview').addClass('loading');
        },
        onComplete: function(file, response) {
            thumb.load(function(){
                $('#preview').removeClass('loading');
                thumb.unbind();
            });
            thumb.attr('src', response);
        }
    });*/
});

function validatePassword() {
    let newPassword = $("#new-password").val();
    let repeatPassword = $("#new-repeat-password").val();
    let currPassword = $("#curr-password").val();
    let errorMessage = $("#new-password-failed");


    if (repeatPassword !== newPassword) {
        errorMessage.text("Passwords do not match");
        errorMessage.show();
        return false;
    }

 /*   if (currPassword == newPassword) {
        errorMessage.text("New password is the same to the current password");
        errorMessage.show();
        return false;
    }*/
    return true;
}




function removePendingTag(id) {

    $.ajax({
        method: "GET",
        url: "../../api/remove_pending_tag.php",
        data: {
            id:id,
        }
    }).done(removePendingTagDiv(id));

}

function addPendingTag(id) {

    $.ajax({
        method: "GET",
        url: "../../api/add_pending_tag.php",
        data: {
            id:id,
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
            id:id,
        }
    }).done(removeBannedUserDiv(id));

}

function removeBannedUserDiv(id){
    $("#ban-user-tr-"+id).remove();
}

function previewFile(){
    var preview = document.querySelector('#upload'); //selects the query named img
    var file    = document.querySelector('input[type=file]').files[0]; //sames as here
    var reader  = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
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