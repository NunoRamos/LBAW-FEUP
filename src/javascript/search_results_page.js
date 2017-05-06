const SEARCH_FOR_QUESTIONS = 0;
const SEARCH_FOR_USERS = 1;

const RATING_ASC = 0;
const RATING_DESC = 1;
const NUM_REPLIES_ASC = 2;
const NUM_REPLIES_DESC = 3;
const SIMILARITY = 4;


$(document).ready(function () {
    $('#tags-select').select2();

    $('#Search-Bar').on('input', newInput);

    $('#Search-Results-Button').on('click', newInput);

    $('.filter').on('click', requestOrderBy);

    $('.Search-Type').on('click', requestSearchType);

    $('select').on('select2:select', newInput);
    $('select').on('select2:unselect', newInput);

    search();
});


let currentPage = 1;
let numberOfPages;
let orderBy = 0;
let searchType = 'Questions';

function getActiveTags() {
    let tags = $('#tags-select').select2('data');
    let ret = [];

    for (let i = 0; i < tags.length; i++) {
        ret.push(tags[i].id);
    }

    return ret;
}

function requestSearchType() {
    if (searchType === $(this).text())
        return;

    searchType = $(this).text();
    const normalColor = '#555';
    const activeColor = '#337ab7';

    if (searchType === 'Questions') {
        $('#Search-Type-Users').css('color', normalColor);
        $('#Search-Type-Questions').css('color', activeColor);

        $('.user-filter').css('display', 'none');
        $('.question-filter').css('display', 'inline');
    }
    else if (searchType === 'Users') {
        $('#Search-Type-Questions').css('color', normalColor);
        $('#Search-Type-Users').css('color', activeColor);

        $('.user-filter').css('display', 'inline');
        $('.question-filter').css('display', 'none');
    }

    currentPage = 1;
    orderBy = 0;

    search();
}

function newInput() {
    currentPage = 1;
    orderBy = 0;

    activeTags = getActiveTags();
    search();
}

function requestOrderBy() {
    currentPage = 1;

    //Coloring old filter with normal color
    repaintingFilterToNormal();

    if (searchType === "Questions") {
        if ($(this).text() === "Answers - Ascending") {
            orderBy = NUM_REPLIES_ASC;
        }
        else if ($(this).text() === "Answers - Descending") {
            orderBy = NUM_REPLIES_DESC;
        }
        else if ($(this).text() === "Rating - Ascending") {
            orderBy = RATING_ASC;
        }
        else if ($(this).text() === "Rating - Descending") {
            orderBy = RATING_DESC;
        }
    }
    else if (searchType === "Users") {
        if ($(this).text() === "Answers - Ascending") {
            if (orderBy == 1)
                orderBy = 0;
            else orderBy = 1;
        }
        else if ($(this).text() === "Answers - Descending") {
            if (orderBy == 2)
                orderBy = 0;
            else orderBy = 2;
        }
        else if ($(this).text() === "Questions - Ascending") {
            if (orderBy == 3)
                orderBy = 0;
            else orderBy = 3;
        }
        else if ($(this).text() === "Questions - Descending") {
            if (orderBy == 4)
                orderBy = 0;
            else orderBy = 4;
        }
    }


    //Coloring new filter with active color
    paintingNewFilter();

    search();
}

function previousRequest() {

    if (currentPage === 1)
        return;

    currentPage--;

    search();
}

function nextRequest() {

    if (currentPage === numberOfPages)
        return;

    currentPage++;

    search();
}

function paginationRequest(page) {

    currentPage = page;

    search();
}

function search() {
    let selectedTags = getActiveTags();

    var input = $('#Search-Bar').val();

    if (input === '' && activeTags.length === 0)
        return;

    $('#Search-Question-Panel').children().remove();
    $('#Pagination-Nav').children().remove();

    console.log(input);

    if (searchType == 'Questions') {
        $.ajax({
            method: "GET",
            url: "../../api/search_questions.php",
            data: {
                inputString: input,
                page: currentPage,
                orderBy: orderBy,
                searchType: searchType,
                activeTags: selectedTags
            }
        }).done(buildSearchQuestionsResults);
    }
    else if (searchType == 'Users') {
        $.ajax({
            method: "GET",
            url: "../../api/search_questions.php",
            data: {inputString: input, page: currentPage, orderBy: orderBy, searchType: searchType}
        }).done(buildSearchUserResults);
    }
}

function repaintingFilterToNormal() {

    if (orderBy == 0)
        return;

    var orderByString = '';

    if (orderBy == 1) {
        orderByString = "Answers - Ascending";
    }
    else if (orderBy == 2) {
        orderByString = "Answers - Descending";
    }
    else if (orderBy == 3) {
        orderByString = "Rating - Ascending";
    }
    else if (orderBy == 4) {
        orderByString = "Rating - Descending";
    }

    $('.filter:contains(' + orderByString + ')').css('color', '#000')
}

function paintingNewFilter() {

    if (orderBy == 0)
        return;

    var orderByString = '';

    if (orderBy == 1) {
        orderByString = "Answers - Ascending";
    }
    else if (orderBy == 2) {
        orderByString = "Answers - Descending";
    }
    else if (orderBy == 3) {
        orderByString = "Rating - Ascending";
    }
    else if (orderBy == 4) {
        orderByString = "Rating - Descending";
    }

    $('.filter:contains(' + orderByString + ')').css('color', '#337ab7')
}

function buildSearchQuestionsResults(response) {

    var json = JSON.parse(response);

    $('#Search-Question-Panel').children().remove();
    $('#Pagination-Nav').children().remove();

    if (json['questions'].length == 0) {
        $('#Search-Question-Panel').append('<div class="list-group-item">No results found</div>');
    }
    else {
        let i = 0;
        for (let question of json['questions']) {
            $('#Search-Question-Panel').append(
                '<div class="list-group-item">' +
                '<div class="row no-gutter no-side-margin">' +
                '<div class="col-xs-1">' +
                '<div class="text-center anchor clickable" href="../../actions/add_vote.php?questionId=' + question.id + '&vote=1"><span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span></div>' +
                '<div class="text-center"><span>' + question.rating + '</span></div>' +
                '<div class="text-center anchor clickable" href="../../actions/add_vote.php?questionId=' + question.id + '&vote=0"><span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span></div>' +
                '</div>' +
                '<div class="col-xs-11 anchor clickable" href="question_page.php?id=' + question.id + '">' +
                '<div class="col-xs-12">' +
                '<a class="small-text" href="../users/profile_page.php?id=' + json['users'][i].id + '"><span>' + json['users'][i].name + ' </span></a>' +
                '<span class="small-text">| ' + question.creationDate + '</span>' +
                '</div>' +
                '<span class="large-text col-xs-12">' + question.title + '</span>' +
                '</div>' +
                '</div>' +
                '</div>'
            );
            i++;
        }
        clickEvent();

        numberOfPages = json['numberOfPages'];

        if (numberOfPages > 1) {
            pagination();
        }
    }

}

function buildSearchUserResults(response) {
    var json = JSON.parse(response);

    $('#Search-Question-Panel').children().remove();
    $('#Pagination-Nav').children().remove();

    if (json['users'].length == 0) {
        $('#Search-Question-Panel').append('<div class="list-group-item">No results found</div>');
    }
    else {
        for (let user of json['users']) {
            $('#Search-Question-Panel').append(
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
        clickEvent();

        numberOfPages = json['numberOfPages'];

        if (numberOfPages > 1) {
            pagination();
        }
    }

}

function pagination() {
    $('#Pagination-Nav').append(
        '<ul id="Pagination-List" class="pagination">' +
        '<li id="Previous-Item">' +
        '<span class="clickable" onclick="previousRequest()" aria-hidden="true">&laquo;</span>' +
        '</li>' +
        '<li>' +
        '<span class="clickable" onclick="nextRequest()" aria-hidden="true">&raquo;</span>' +
        '</li>' +
        '</ul>');

    for (i = numberOfPages; i > 0; i--) {
        var classes = "";
        if (currentPage == i)
            classes = "active";

        $('#Previous-Item').after('<li class="' + classes + '">' +
            '<span onclick="paginationRequest(' + i + ')" class="clickable">' + i + '</span>' +
            '</li>');
    }
}