function toggleTextBox(caller, edit) {
    let button = $(caller);

    let wrapper = button.parentsUntil('.content', '.list-group-item');

    let boxDiv = wrapper.siblings('div.reply-text-box');

    if (boxDiv.children().length === 0) {
        let parentId = button.attr('data-content-id');
        let questionId = $('#question').children().attr('id');

        let formUrl, buttonValue;
        if(edit === 1){
            formUrl = '../../actions/edit_content.php';
            buttonValue = "Edit Text";
        }
        else {
            formUrl = '../../actions/create_reply.php';
            buttonValue = "Post Answer";
        }

        boxDiv.append('<form class="form-horizontal" method="post" action="' + formUrl + '">' +
            '<input type="hidden" name="parent-id" value="' + parentId + '">' +
            '<input type="hidden" name="question-id" value="' + questionId + '">' +
            '<textarea class="form-control container-text" name="container-text" placeholder="Answer"></textarea>' +
            '<input class="btn btn-default submit-answer-btn" type="submit" value="' + buttonValue + ' ">' +
            '</form>');

        boxDiv.find('.container-text').trumbowyg();

        if(edit === 1)
            boxDiv.find('.container-text').trumbowyg('html', button.parentsUntil('.list-group', '.list-group-item').find('.content-text').html());

    } else {
        boxDiv.children().remove();
    }
}
