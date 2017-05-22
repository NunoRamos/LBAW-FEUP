const UP = 1;
const DOWN= 0;
const REMOVE_VOTE = -1;

let id;
let newVote;
let oldVote;

$(document).ready(function () {
    $('#users-votes').on('hidden.bs.modal', removeModalContent)
});

function addPositiveVote(userId,contentId){
    newVote = UP;
    vote(userId,contentId);
}

function addNegativeVote(userId,contentId){
    newVote = DOWN;
    vote(userId,contentId);
}

function vote(userId,contentId){

    if(userId == 0)
        return;

    id = contentId;

    oldVote = parseInt($('div[data-content-id=' + id + ']').attr("data-vote-positive"));

    let vote;

    if(oldVote == newVote)
        vote = REMOVE_VOTE;
    else
        vote = newVote;

    $('div[data-content-id=' + id + ']').attr("data-vote-positive", vote);

    $.ajax({
        method: "GET",
        url: "../../api/add_vote.php",
        data: {
            contentId: contentId,
            vote: vote,
            userId: userId,
        }
    }).done(changeVoteColor);
}

function changeVoteColor(){

    let selector = 'div[data-content-id=' + id + ']';
    let rating = parseInt($(selector).find('div.rating span').text());

    switch (newVote){
        case UP:
            if(oldVote == UP){
                $(selector).find('div.positive span').toggleClass("positive-vote");
                rating--;
            }
            else if(oldVote == DOWN){
                $(selector).find('div.positive span').toggleClass("positive-vote");
                $(selector).find('div.negative span').toggleClass("negative-vote");
                rating += 2;
            }
            else {
                $(selector).find('div.positive span').toggleClass("positive-vote");
                rating++;
            }
            break;
        case DOWN:
            if(oldVote == DOWN){
                $(selector).find('div.negative span').toggleClass("negative-vote");
                rating++;
            }
            else if(oldVote == UP){
                $(selector).find('div.positive span').toggleClass("positive-vote");
                $(selector).find('div.negative span').toggleClass("negative-vote");
                rating -= 2;
            }
            else {
                $(selector).find('div.negative span').toggleClass("negative-vote");
                rating--;
            }
            break;
        default:
            break;
    }

    //Updating rating
    $(selector).find('div.rating span').text(rating);
}

function getVotedUsers(contentId){
    $.ajax({
        method: "GET",
        url: "../../api/get_content_votes.php",
        data: {
            contentId: contentId
        }
    }).done(insertUsersOnModal);
}

function removeModalContent(){
    $('#users').remove();
}

function insertUsersOnModal(response){

  removeModalContent();
  $('.loading').remove();

  $('.modal-body').append(response);
    addEventToClickableElements();
}

