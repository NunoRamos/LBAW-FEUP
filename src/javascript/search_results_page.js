const SEARCH_FOR_QUESTIONS = 0;
const SEARCH_FOR_USERS = 1;

let currentPage = 1;
const resultsPerPage = 10;
let orderBy = 0;
let searchType = 0;

$(document).ready(function () {
    $('#tags-select').select2();

    $('#search-bar').on('input', search);

    $('#search-results-button').on('click', search);

    $('.filter').on('click', filterChanged);

    $('.search-type').on('click', resultTypeChanged);

    $('select').on('select2:select', search).on('select2:unselect', search);

    search();
});

function clearSearchResults() {
    $('#search-bar-container').siblings().remove();
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

    searchType = newSearchType;
    $('#search-type-users').toggleClass('selected');
    $('#search-type-questions').toggleClass('selected');
    $('.user-filter').toggle();
    $('.question-filter').toggle();

    search();
}

function filterChanged() {
    $(this).siblings().removeClass('selected');
    $(this).addClass('selected');
    orderBy = $(this).attr('value');

    search();
}

function insertLoadingIcon() {
    $('#search-bar-container').after('<div class="panel panel-default loading"><img src="/images/rolling.svg"/></div>');
}

function searchFailed() {
    $('#search-bar-container').after('<div class="panel panel-default text-center"><div class="list-group-item">Could not connect to server.</div></div>');
}

function search() {
    let selectedTags = getSelectedTags();

    const input = $('#search-bar').val();

    clearSearchResults();

    if (input === '' && selectedTags.length === 0) {
        emptySearch();
        return;
    }

    insertLoadingIcon();

    if (searchType === SEARCH_FOR_QUESTIONS) {
        $.ajax({
            url: "/api/search.php",
            dataType: "html",
            data: {
                inputString: input,
                orderBy: orderBy,
                searchType: searchType,
                selectedTags: selectedTags,
                page: currentPage,
                resultsPerPage: resultsPerPage
            }
        }).done(insertSearchResults)
            .fail(searchFailed);
    } else if (searchType === SEARCH_FOR_USERS) {
        $.ajax({
            url: "/api/search.php",
            dataType: "html",
            data: {
                inputString: input,
                orderBy: orderBy,
                searchType: searchType,
                page: currentPage,
                resultsPerPage: resultsPerPage
            }
        }).done(insertSearchResults)
            .fail(searchFailed);
    }
}

function insertSearchResults(response) {
    const searchBarContainer = $('#search-bar-container');
    searchBarContainer.siblings().remove();

    clearSearchResults();

    searchBarContainer.after(response);
    addEventToClickableElements();
}

function emptySearch() {
    $('#search-bar-container').after('<div class="panel panel-default"><div class="list-group-item text-center">Search something!</div></div>');
}
