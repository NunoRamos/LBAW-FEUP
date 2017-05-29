$(document).ready(function () {

    addEvents();
});

function addPendingTag() {
    let name = $('#new-pending-tag-name').val();

    $.ajax('../../api/add_pending_tag.php', {
        method: 'POST',
        data: {
            name: name
        }
    }).done(handleReturn.bind(this,1));
}

function handleReturn(addSpan) {
    let formPendintTag = $('#form-pending-tag');

    formPendintTag.empty();


    if(addSpan === 1){
        formPendintTag.append('<p class="list-group-item">Your suggestion has been saved!<span id="another-one"> Suggests another one!</span></p>');
        $('#another-one').on('click', handleReturn.bind(this, 0));
    }
    else {
        formPendintTag.append('<input id="new-pending-tag-name" type="text">'+
            '<button id="submit-tag" class="btn btn-default submit-answer-btn">Submit</button>');
        addEvents();
    }

}

function addEvents() {
    $('#submit-tag').on('click', addPendingTag);

    $("#new-pending-tag-name").on('keyup', function (e) {
        if (e.keyCode === 13) {
            addPendingTag();
        }
    });
}