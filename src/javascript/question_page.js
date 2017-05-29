const REMOVE_TAG = 0;
const ADD_TAGS = 1;
const GET_QUESTION_TAGS = 2;

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

function askForAllTags() {
    let tagsOptions = $('#tags-select');
    let contentId = $('#question div').attr('id');

    if(tagsOptions.length === 0){
        $.ajax('../../api/edit_question_tags.php', {
            method: 'POST',
            data: {
                editType: GET_QUESTION_TAGS,
                contentId: contentId
            }
        }).done(toggleAddTags);
    }
    else {
        tagsOptions.parent().remove();
        $('#add-tags').remove();
        if($('#tags div').length === 0){
            $('#tags').append('<p class="list-group-item">No tags for this question</p>');
        }
    }

}

function toggleAddTags(response) {

    if($('#tags p').length === 1){
        $('#tags p').remove();
    }

    $('#tags').append(response + '<input id="add-tags" class="btn btn-default submit-answer-btn" onclick="addTags()" type="submit" value="Add Tags">');

    $('#tags-select').select2();
}

function getSelectedTags() {
    let tags = $('#tags-select').select2('data');
    let ret = [];

    for (let i = 0; i < tags.length; i++) {
        let position = [];
        position.push(tags[i].id);
        position.push(tags[i].text);
        ret.push(position);
    }

    return ret;
}

function addTags() {
    let tags = getSelectedTags();

    if(tags.length === 0)
        return;

    let contentId = $('#question div').attr('id');

    $.ajax('../../api/edit_question_tags.php', {
        method: 'POST',
        data: {
            tags: tags,
            editType: ADD_TAGS,
            contentId: contentId
        }
    }).done(addNewTags.bind(this, tags));
}

function addNewTags(tags, response) {
    let select2 = $('#tags-selection');

    for(let i= 0; i < tags.length; i++){
        console.log(tags[i]);

        $('<div class="row list-group-item">' +
            '<a href="search_results.php" class="col-xs-10">' + tags[i][1] + '</a>' +
            '<div class="btn-group col-xs-2">' +
                '<button class="btn btn-xs" onclick="deleteTag(this,' + tags[i][0] + ')">' +
                '<span class="glyphicon glyphicon-minus"></span>' +
                '</button>' +
            '</div>' +
        '</div>').insertBefore('#tags-selection');
    }

    $('#tags-selection').remove();
    $('#add-tags').remove();

    $('#tags').append(response + '<input id="add-tags" class="btn btn-default submit-answer-btn" onclick="addTags()" type="submit" value="Add Tags">');
    $('#tags-select').select2();
}

function deleteTag(clickedElement, tagId) {
    let contentId = $('#question div').attr('id');

    let tagDiv = $(clickedElement).parent().parent();

    $.ajax('../../api/edit_question_tags.php', {
        method: 'POST',
        data: {
            tagId: tagId,
            editType: REMOVE_TAG,
            contentId: contentId
        }
    }).done(removeTag.bind(this, tagDiv));
}

function removeTag(tagDIv) {
    tagDIv.remove();

    let tagsContainer = $('#tags div');

    if(tagsContainer.length === 0)
        $('#tags').append('<p class="list-group-item">No tags for this question</p>');

}
