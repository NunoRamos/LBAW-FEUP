const SEARCH_FOR_QUESTIONS = 0;
const SEARCH_FOR_USERS = 1;

let currentPage = 1;
const resultsPerPage = 5;
let orderBy = 0;
let searchType = 0;

$(document).ready(function () {

   // $('#search-results-button').on('click', search);

    search();
});






function search() {

        $.ajax({
            url: "../../api/search_banned_users.php",
            dataType: "html",
            data: {
                orderBy: orderBy,
                searchType: searchType,
                page: currentPage,
                resultsPerPage: resultsPerPage
            }
        }).done()


}

function insertSearchResults(response) {
    const searchBarContainer = $('#banned-users');
    searchBarContainer.siblings().remove();



    searchBarContainer.after(response);
    addEventToClickableElements();
}


