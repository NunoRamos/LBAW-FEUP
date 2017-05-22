const UP = 1;
const REMOVE = 0;
const DOWN = -1;

$(document).ready(function () {
    $('.vote-modal').on('hidden.bs.modal', removeModalContent)
});

function vote(userId, contentId, newVote) {
    if (userId === 0)
        return;

    const votes = $('div[data-content-id=' + contentId + ']').children().not('.rating').children('span');
    let oldVote = 0;

    if (votes.first().hasClass('positive'))
        oldVote = UP;
    else if (votes.last().hasClass('negative'))
        oldVote = DOWN;

    if (oldVote === newVote)
        removeVote(contentId, userId, newVote);
    else
        addVote(contentId, userId, newVote, oldVote);
}

function addVote(contentId, userId, newVote, oldVote) {
    const ratingIfSuccessful = $('div[data-content-id=' + contentId + ']').find('.rating span').text() - oldVote + newVote;

    $.ajax("../../api/vote.php", {
        data: {
            contentId: contentId,
            isPositive: newVote === UP,
            userId: userId,
        }
    }).then(updateVoteColor.bind(this, contentId, newVote)).then(updateRating.bind(this, contentId, ratingIfSuccessful));
}

function removeVote(contentId, userId, newVote) {
    const ratingIfSuccessful = $('div[data-content-id=' + contentId + ']').find('.rating span').text() - newVote;

    $.ajax("../../api/remove_vote.php", {
        data: {
            contentId: contentId,
            userId: userId,
        }
    }).then(updateVoteColor.bind(this, contentId, REMOVE)).then(updateRating.bind(this, contentId, ratingIfSuccessful));
}

function updateRating(contentId, newRating) {
    $('div[data-content-id=' + contentId + ']').find('.rating span').text(newRating);
}

function updateVoteColor(contentId, vote) {
    const votes = $('div[data-content-id=' + contentId + ']').children().not('.rating').children('span');

    votes.removeClass('negative positive');

    if (vote === UP)
        votes.first().addClass('positive');
    else if (vote === DOWN)
        votes.last().addClass('negative');
}

function getUsersWhoVotedOnContent(contentId) {
    $.ajax({
        method: "GET",
        url: "../../api/get_content_votes.php",
        data: {
            contentId: contentId
        }
    }).done(insertUsersOnModal);
}

function removeModalContent() {
    $('.vote-modal .voters *').remove();
}

function insertUsersOnModal(response) {
    removeModalContent();
    $('.loading').remove();

    $('.voters').append(response);
    addEventToClickableElements();
}

