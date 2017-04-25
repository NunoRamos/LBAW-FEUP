function toggleReplyBox(caller) {
    let button = $(caller);
    let parentId = button.attr('data-contentid');

    let div = button.parentsUntil('.panel-body', '.list-group');

    let replyBox = div.children('form');

    if (replyBox.length === 0) {
        div.append('<form class="form-horizontal" method="post" action="../../actions/create_reply.php">' +
            '<input type="hidden" name="parent-id" value="' + parentId + '">' +
            '<textarea class="form-control reply-text" name="reply-text" placeholder="Answer"></textarea>' +
            '<input class="btn btn-default submit-answer-btn" type="submit" value="Post Answer">' +
            '</form>');

        div.find('.reply-text').trumbowyg();
    } else {
        replyBox.remove();
    }
}
