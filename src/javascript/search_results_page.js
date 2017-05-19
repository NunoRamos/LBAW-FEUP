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
    $('#search-bar-container').siblings().remove();
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

function insertLoadingIcon() {
    $('#search-bar-container').after('<div class="panel panel-default"><div class="loading"><img src="/images/rolling.svg"/></div></div>');
}

function search(page) {
    if (!page)
        currentPage = 1;
    else
        currentPage = page;

    let selectedTags = getSelectedTags();

    const input = $('#search-bar').val();

    clearSearchResults();
    clearPagination();

    if (input === '' && selectedTags.length === 0) {
        insertNoResultsFound();
        insertPagination();
        return;
    }

    insertLoadingIcon();

    if (searchType === SEARCH_FOR_QUESTIONS) {
        $.ajax({
            method: "GET",
            url: "/api/search.php",
            data: {
                inputString: input,
                orderBy: orderBy,
                searchType: searchType,
                selectedTags: selectedTags,
                page: currentPage,
                resultsPerPage: resultsPerPage
            }
        }).done(insertSearchResults);
    }
    else if (searchType === SEARCH_FOR_USERS) {
        $.ajax({
            method: "GET",
            url: "/api/search.php",
            data: {
                inputString: input,
                orderBy: orderBy,
                searchType: searchType,
                page: currentPage,
                resultsPerPage: resultsPerPage
            }
        }).done(insertSearchResults);
    }
}

function insertSearchResults(response) {
    const searchBarContainer = $('#search-bar-container');
    searchBarContainer.siblings().remove();

    clearSearchResults();

    searchBarContainer.after(response);
    addEventToClickableElements();
}

function insertNoResultsFound() {
    $('#search-bar-container').after('<div class="panel panel-default"><div class="list-group-item">No results found</div></div>');
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