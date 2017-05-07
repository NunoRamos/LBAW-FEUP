const SEARCH_FOR_QUESTIONS = 0;
const SEARCH_FOR_USERS = 1;

let currentPage = 1;
let resultsPerPage = 1;
let lastSearchResults = 1;
let orderBy = 0;
let searchType = 0;
let questions = [];

$(document).ready(function () {
    $('#tags-select').select2();

    $('#search-bar').on('input', searchBoxChanged);

    $('#search-results-button').on('click', searchBoxChanged);

    $('.filter').on('click', filterChanged);

    $('.search-type').on('click', resultTypeChanged);

    $('select').on('select2:select', searchBoxChanged).on('select2:unselect', searchBoxChanged);

    search();
});


function getActiveTags() {
    let tags = $('#tags-select').select2('data');
    let ret = [];

    for (let i = 0; i < tags.length; i++) {
        ret.push(tags[i].id);
    }

    return ret;
}

function resultTypeChanged() {
    const newSearchType = parseInt($(this).attr('value'));

    if (searchType === newSearchType)
        return;

    searchType = newSearchType;
    $('#search-type-users').toggleClass('selected');
    $('#search-type-questions').toggleClass('selected');
    $('.user-filter').toggle();
    $('.question-filter').toggle();

    currentPage = 1;
    orderBy = 0;

    search();
}

function searchBoxChanged() {
    currentPage = 1;
    orderBy = 0;
    search();
}

function filterChanged() {
    currentPage = 1;

    $(this).siblings().removeClass('selected');
    $(this).addClass('selected');
    orderBy = $(this).attr('value');

    search();
}

function previousPage() {
    if (currentPage === 1)
        return;

    currentPage--;

    search();
}

function nextPage() {
    if (currentPage === numberOfPages)
        return;

    currentPage++;
}

function changeToPage(page) {
    currentPage = page;
}

function search() {
    let selectedTags = getActiveTags();

    const input = $('#search-bar').val();

    if (input === '' && selectedTags.length === 0) {
        insertNoResultsFound();
        insertPagination();
        return;
    }

    $('#search-question-panel').children().remove();
    $('#pagination-nav').children().remove();

    if (searchType === SEARCH_FOR_QUESTIONS) {
        $.ajax({
            method: "GET",
            url: "../../api/search.php",
            data: {
                inputString: input,
                orderBy: orderBy,
                searchType: searchType,
                selectedTags: selectedTags
            }
        }).done(buildSearchQuestionsResults);
    }
    else if (searchType === SEARCH_FOR_USERS) {
        $.ajax({
            method: "GET",
            url: "../../api/search.php",
            data: {
                inputString: input,
                orderBy: orderBy,
                searchType: searchType
            }
        }).done(buildSearchUserResults);
    }
}

function buildSearchQuestionsResults(response) {
    questions = JSON.parse(response);
    const searchQuestionPanel = $('#search-question-panel');

    searchQuestionPanel.children().remove();
    $('#pagination-nav').children().remove();

    if (questions.length === 0) {
        insertNoResultsFound();
    }
    else {
        let i = 0;
        for (let question of questions) {
            searchQuestionPanel.append(
                '<div class="list-group-item">' +
                '<div class="row no-gutter no-side-margin">' +
                '<div class="col-xs-1">' +
                '<div class="text-center anchor clickable" href="../../actions/add_vote.php?questionId=' + question.id + '&vote=1"><span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span></div>' +
                '<div class="text-center"><span>' + question.rating + '</span></div>' +
                '<div class="text-center anchor clickable" href="../../actions/add_vote.php?questionId=' + question.id + '&vote=0"><span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span></div>' +
                '</div>' +
                '<div class="col-xs-11 anchor clickable" href="question_page.php?id=' + question.id + '">' +
                '<div class="col-xs-12">' +
                '<a class="small-text" href="../users/profile_page.php?id=' + questions.creatorId + '"><span>' + question.creatorName + ' </span></a>' +
                '<span class="small-text">| ' + question.creationDate + '</span>' +
                '</div>' +
                '<span class="large-text col-xs-12">' + question.title + '</span>' +
                '</div>' +
                '</div>' +
                '</div>'
            );
            i++;
        }

        addEventToClickableElements();
    }

    insertPagination();
}

function insertNoResultsFound() {
    $('#search-question-panel').append('<div class="list-group-item">No results found</div>');
}

function buildSearchUserResults(response) {
    const json = JSON.parse(response);
    const searchQuestionPanel = $('#search-question-panel');

    searchQuestionPanel.children().remove();
    $('#pagination-nav').children().remove();

    if (json['users'].length === 0) {
        insertNoResultsFound();
    } else {
        for (let user of json['users']) {
            searchQuestionPanel.append(
                '<div class="list-group-item">' +
                '<div class="row no-gutter no-side-margin">' +
                '<div class="col-xs-3">' +
                '<img class="center-block img-circle img-responsive img-user-search" src="/images/user-default.png">' +
                '</div>' +
                '<div class="col-xs-9 anchor clickable user-text" href="../users/profile_page.php?id=' + user.id + '">' +
                '<span class="large-text col-xs-12">' + user.name + '</span>' +
                '<span class="small-text col-xs-12">' + user.email + '</span>' +
                '</div>' +
                '</div>' +
                '</div>'
            );
        }
        addEventToClickableElements();
    }

    insertPagination();
}

function insertPagination() {
    $('#pagination-nav').append(
        '<ul id="pagination-list" class="pagination">' +
        '<li id="previous-item">' +
        '<span class="clickable" onclick="previousPage()" aria-hidden="true">&laquo;</span>' +
        '</li>' +
        '<li>' +
        '<span class="clickable" onclick="nextPage()" aria-hidden="true">&raquo;</span>' +
        '</li>' +
        '</ul>');

    $('#previous-item').after('<li class="active">' +
        '<span onclick="changeToPage(1)" class="clickable">1</span>' +
        '</li>');

    let numberOfPages = Math.floor(lastSearchResults / resultsPerPage);

    for (let i = numberOfPages; i > 1; i--) {
        $('#previous-item').after('<li>' +
            '<span onclick="changeToPage(' + i + ')" class="clickable">' + i + '</span>' +
            '</li>');
    }
}