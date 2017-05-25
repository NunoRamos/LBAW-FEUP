function toggleTextBox(caller, edit) {
    let button = $(caller);

    let wrapper = button.parentsUntil('.content', '.list-group-item');

    let boxDiv = wrapper.siblings('div.reply-text-box');

    if (boxDiv.children().length === 0) {
        let parentId = button.attr('data-content-id');
        let questionId = $('#question').children().attr('id');

        let formUrl, buttonValue;
        if (edit === 1) {
            formUrl = '../../actions/edit_content.php';
            buttonValue = "Edit Text";
        }
        else {
            formUrl = '../../actions/create_reply.php';
            buttonValue = "Post Answer";
        }

        boxDiv.append('<form class="form-horizontal" method="post" action="' + formUrl + '">' +
            '<input type="hidden" name="content-id" value="' + parentId + '">' +
            '<input type="hidden" name="question-id" value="' + questionId + '">' +
            '<input type="hidden" name="edit-type" value="' + 0 + '">' +
            '<textarea class="form-control content-text" name="content-text" placeholder="Answer"></textarea>' +
            '<input class="btn btn-default submit-answer-btn" type="submit" value="' + buttonValue + ' ">' +
            '</form>');

        boxDiv.find('.content-text').trumbowyg();

        if (edit === 1)
            boxDiv.find('.content-text').trumbowyg('html', button.parentsUntil('.list-group', '.list-group-item').find('.content-text').html());

    } else {
        boxDiv.children().remove();
    }
}

function followContent(clickedElement, contentId) {
    const span = $(clickedElement).children().first();
    $.ajax('../../api/follow_content.php', {
        method: 'POST',
        data: {
            contentId: contentId
        }
    }).done(toggleFollowContent.bind(this, span));
}

function unfollowContent(clickedElement, contentId) {
    const span = $(clickedElement).children().first();
    $.ajax('../../api/unfollow_content.php', {
        method: 'POST',
        data: {
            contentId: contentId
        }
    }).done(toggleFollowContent.bind(this, span));
}

function toggleFollowContent(span) {
    span.toggleClass('glyphicon-star-empty glyphicon-star');
}

function toggleTitleInput(contentId){
    let headerElement = $('#question-title-header');
    let formElement = $('#edit-title-form');

    if(formElement.is(':visible')){
        headerElement.show();
        formElement.hide()
    }
    else {
        headerElement.hide();
        formElement.show();
        $('.edit-title-input').focus();
    }



}
