const REMOVE_TAG = 0;
const ADD_TAGS = 1;

$(document).ready(function () {
    const contentId = $('#question').children('div').attr('id');
    $('#tags-select').select2({
        ajax: {
            url: '/api/get_unused_tags.php?contentId=' + contentId,
            dataType: 'json',
            processResults: function (data, params) {
                return {
                    results: data
                };
            }
        }
    });
});

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

function toggleTitleInput() {
    $('#question-title-header').toggle();
    $('#edit-title-form').toggle();
    $('.edit-title-input').focus();
}


function toggleTagEditMode() {
    $('#add-tags').toggle();
    $('#tags-select').val(null).trigger('change');

    const tags = $('#tags');
    tags.children().remove('p');
    if (tags.children('span').length === 0)
        tags.append('<p class="list-group-item">This question has no tags.</p>');
}

function saveNewTags() {
    let tags = $('#tags-select').select2('data').map(function (object) {
        return {"id": object.id, "text": object.text}
    });

    if (tags.length === 0)
        return;

    let contentId = $('#question').find('div').attr('id');

    $.ajax('../../api/edit_question_tags.php', {
        method: 'POST',
        data: {
            tags: tags,
            editType: ADD_TAGS,
            contentId: contentId
        }
    }).done(addNewTags.bind(this, tags));
}

function addNewTags(tags) {
    for (let i = 0; i < tags.length; i++) {
        $('#tags').append($('<span class="list-group-item">' +
            '<a href="search_results.php' + tags[i].id + '">' + tags[i].text + '</a>' +
            '<button class="btn btn-xs pull-right" onclick="deleteTag(this,' + tags[i].id + ')">' +
            '<span class="glyphicon glyphicon-minus"></span>' +
            '</button>' +
            '</span>'));
    }

    toggleTagEditMode();
}

function deleteTag(clickedElement, tagId) {
    let contentId = $('#question').find('div').attr('id');
    let tagContainer = $(clickedElement).parent();

    $.ajax('../../api/edit_question_tags.php', {
        method: 'POST',
        data: {
            tagId: tagId,
            editType: REMOVE_TAG,
            contentId: contentId
        }
    }).done(removeTag.bind(this, tagContainer));
}

function removeTag(tagContainer) {
    const tags = $('#tags');
    tagContainer.remove();

    if (tags.children('span').length === 0)
        tags.append('<p class="list-group-item">This question has no tags.</p>');
}
