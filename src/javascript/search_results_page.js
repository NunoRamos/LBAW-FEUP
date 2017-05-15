const SEARCH_FOR_QUESTIONS = 0;
const SEARCH_FOR_USERS = 1;

let currentPage = 1;
let resultsPerPage = 1;
let orderBy = 0;
let searchType = 0;
let reply = [];

$(document).ready(function () {
    $('#tags-select').select2();

    $('#search-bar').on('input', searchBoxChanged);

    $('#search-results-button').on('click', searchBoxChanged);

    $('.filter').on('click', filterChanged);

    $('.search-type').on('click', resultTypeChanged);

    $('select').on('select2:select', searchBoxChanged).on('select2:unselect', searchBoxChanged);

    search();
});

function clearSearchResults() {
    $('#search-question-panel').children().remove();
}

function clearPagination() {
    $('#pagination-list').children().remove();
}

function getSelectedTags() {
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

    clearSearchResults();
    clearPagination();

    searchType = newSearchType;
    $('#search-type-users').toggleClass('selected');
    $('#search-type-questions').toggleClass('selected');
    $('.user-filter').toggle();
    $('.question-filter').toggle();

    search();
}

function searchBoxChanged() {
    search();
}

function filterChanged() {
    $(this).siblings().removeClass('selected');
    $(this).addClass('selected');
    orderBy = $(this).attr('value');

    search();
}

function search(page) {
    if (!page)
        currentPage = 1;
    else
        currentPage = page;

    let selectedTags = getSelectedTags();

    const input = $('#search-bar').val();

    if (input === '' && selectedTags.length === 0) {
        insertNoResultsFound();
        insertPagination();
        return;
    }

    clearSearchResults();
    clearPagination();

    if (searchType === SEARCH_FOR_QUESTIONS) {
        $.ajax({
            method: "GET",
            url: "../../api/search.php",
            data: {
                inputString: input,
                orderBy: orderBy,
                searchType: searchType,
                selectedTags: selectedTags,
                resultsOffset: currentPage - 1,
                resultsPerPage: resultsPerPage
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
                searchType: searchType,
                resultsOffset: currentPage - 1,
                resultsPerPage: resultsPerPage
            }
        }).done(buildSearchUserResults);
    }
}

function buildSearchQuestionsResults(response) {
    reply = JSON.parse(response);
    const searchQuestionPanel = $('#search-question-panel');

    clearSearchResults();
    clearPagination();

    if (reply.numResults > 0) {
        for (let question of reply.results) {
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
                '<a class="small-text" href="../users/profile_page.php?id=' + question.creatorId + '"><span>' + question.creatorName + '</span></a>' +
                '<span class="small-text"> | ' + question.creationDate + '</span>' +
                '</div>' +
                '<span class="large-text col-xs-12">' + question.title + '</span>' +
                '</div>' +
                '</div>' +
                '</div>'
            );
        }

        addEventToClickableElements();
    } else {
        insertNoResultsFound();
    }

    insertPagination(reply.numResults);
}

function insertNoResultsFound() {
    $('#search-question-panel').append('<div class="list-group-item">No results found</div>');
}

function buildSearchUserResults(response) {
    const json = JSON.parse(response);
    const searchQuestionPanel = $('#search-question-panel');

    clearSearchResults();
    clearPagination();

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

function insertPagination(numResults) {
    if (!numResults)
        numResults = 1;

    const numberOfPages = Math.ceil(numResults / resultsPerPage);

    const paginationList = $('#pagination-list');

    paginationList.append(
        '<li><span class="clickable" ' +
        (currentPage !== 1 ? 'onclick="search(' + (currentPage - 1) + ')"' : '') +
        ' aria-hidden="true">&laquo;</span></li>');


    console.log(numberOfPages);
    for (let i = 1; i <= numberOfPages; i++) {
        paginationList.append('<li' +
            (currentPage === i ? ' class="active"' : '') +
            '><span class="clickable" onclick="search(' + i + ')">' + i + '</span>' +
            '</li>');
    }

    paginationList.append(
        '<li><span class="clickable" ' +
        (currentPage !== numberOfPages ? 'onclick="search(' + (currentPage + 1) + ')"' : '') +
        ' aria-hidden="true">&raquo;</span></li>');

}