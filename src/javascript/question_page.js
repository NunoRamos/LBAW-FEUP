function toggleReplyBox(caller) {
    let button = $(caller);

    let replyWrapper = button.parentsUntil('.content', '.list-group-item');

    let replyBoxDiv = replyWrapper.siblings('div.reply-text-box');
    console.log(replyBoxDiv);

    if (replyBoxDiv.children().length === 0) {
        let parentId = button.attr('data-contentid');
        let questionId = $('#question').children().attr('id');

        replyBoxDiv.append('<form class="form-horizontal" method="post" action="../../actions/create_reply.php">' +
            '<input type="hidden" name="parent-id" value="' + parentId + '">' +
            '<input type="hidden" name="question-id" value="' + questionId + '">' +
            '<textarea class="form-control reply-text" name="reply-text" placeholder="Answer"></textarea>' +
            '<input class="btn btn-default submit-answer-btn" type="submit" value="Post Answer">' +
            '</form>');

        replyBoxDiv.find('.reply-text').trumbowyg();
    } else {
        replyBoxDiv.children().remove();
    }
}
