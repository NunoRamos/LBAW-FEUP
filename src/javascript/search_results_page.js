$(document).ready(function () {
    $('#tags-select').select2();

    ajaxRequest();

    $('#Search-Bar').on('input', newInput);

    $('#Search-Results-Button').on('click', newInput);

    $('.filter').on('click', requestOrderBy);

    $('.Search-Type').on('click', requestSearchType);
});

var atualPage = 1;
var numberOfPages;
var orderBy = 0;
var searchType = 'Questions';
var activeTags = [];

function getActiveTags(){

    let tags = $('.select2-selection__choice');
    let ret = [];

    for(let i=0;i<tags.length;i++){
        ret.push(tags.get(i).title);
    }

    return ret;
}

function requestSearchType(){

    if(searchType == $(this).text()){
        return;
    }

    searchType = $(this).text();
    var normalColor = '#555';
    var activeColor = '#337ab7';

    if(searchType == 'Questions'){
        $('#Search-Type-Users').css('color', normalColor);
        $('#Search-Type-Questions').css('color', activeColor);

        $('.user-filter').css('display','none');
        $('.question-filter').css('display','inline');
    }
    else if(searchType == 'Users'){
        $('#Search-Type-Questions').css('color', normalColor);
        $('#Search-Type-Users').css('color', activeColor);

        $('.user-filter').css('display','inline');
        $('.question-filter').css('display','none');
    }

    atualPage = 1;
    orderBy = 0;

    ajaxRequest();
}

function newInput(){
    atualPage = 1;
    orderBy = 0;

    activeTags = getActiveTags();

    ajaxRequest();
}

function requestOrderBy(){
    atualPage = 1;

    //Coloring old filter with normal color
    repaintingFilterToNormal();

    if(searchType == "Questions"){
        if($(this).text() == "Answers - Ascending"){
            if(orderBy == 1)
                orderBy = 0;
            else orderBy = 1;
        }
        else if($(this).text() == "Answers - Descending"){
            if(orderBy == 2)
                orderBy = 0;
            else orderBy = 2;
        }
        else if($(this).text() == "Rating - Ascending"){
            if(orderBy == 3)
                orderBy = 0;
            else orderBy = 3;
        }
        else if($(this).text() == "Rating - Descending"){
            if(orderBy == 4)
                orderBy = 0;
            else orderBy = 4;
        }
    }
    else if(searchType == "Users"){
        if($(this).text() == "Answers - Ascending"){
            if(orderBy == 1)
                orderBy = 0;
            else orderBy = 1;
        }
        else if($(this).text() == "Answers - Descending"){
            if(orderBy == 2)
                orderBy = 0;
            else orderBy = 2;
        }
        else if($(this).text() == "Questions - Ascending"){
            if(orderBy == 3)
                orderBy = 0;
            else orderBy = 3;
        }
        else if($(this).text() == "Questions - Descending"){
            if(orderBy == 4)
                orderBy = 0;
            else orderBy = 4;
        }
    }


    //Coloring new filter with active color
    paintingNewFilter();

    ajaxRequest();
}

function previousRequest(){

    if(atualPage == 1)
        return;

    atualPage--;

    ajaxRequest();
}

function nextRequest(){

    if(atualPage == numberOfPages)
        return;

    atualPage++;

    ajaxRequest();
}

function paginationRequest(page){

    atualPage = page;

    ajaxRequest();
}

function ajaxRequest() {

    var input = $('#Search-Bar').val();

    if(input == '')
        return;

    $('#Search-Question-Panel').children().remove();
    $('#Pagination-Nav').children().remove();

    console.log(input);

    if(searchType == 'Questions'){
        $.ajax({
            method: "GET",
            url: "../../api/search_questions.php",
            data: { inputString: input, page: atualPage, orderBy: orderBy, searchType: searchType, tags: activeTags }
        }).done(buildSearchQuestionsResults);
    }
    else if(searchType == 'Users'){
        $.ajax({
            method: "GET",
            url: "../../api/search_questions.php",
            data: { inputString: input, page: atualPage, orderBy: orderBy, searchType: searchType }
        }).done(buildSearchUserResults);
    }
}

function repaintingFilterToNormal(){

    if(orderBy == 0)
        return;

    var orderByString = '';

    if(orderBy == 1){
        orderByString = "Answers - Ascending";
    }
    else if(orderBy == 2){
        orderByString = "Answers - Descending";
    }
    else if(orderBy == 3){
        orderByString = "Rating - Ascending";
    }
    else if(orderBy == 4){
        orderByString = "Rating - Descending";
    }

    $('.filter:contains('+orderByString+')').css('color', '#000')
}

function paintingNewFilter(){

    if(orderBy == 0)
        return;

    var orderByString = '';

    if(orderBy == 1){
        orderByString = "Answers - Ascending";
    }
    else if(orderBy == 2){
        orderByString = "Answers - Descending";
    }
    else if(orderBy == 3){
        orderByString = "Rating - Ascending";
    }
    else if(orderBy == 4){
        orderByString = "Rating - Descending";
    }

    $('.filter:contains('+orderByString+')').css('color', '#337ab7')
}

function buildSearchQuestionsResults(response){

    var json = JSON.parse(response);

    $('#Search-Question-Panel').children().remove();
    $('#Pagination-Nav').children().remove();

    if(json['questions'].length == 0){
        $('#Search-Question-Panel').append('<div class="list-group-item">No results found</div>');
    }
    else {
        let i = 0;
        for(let question of json['questions']){
            $('#Search-Question-Panel').append(
                '<div class="list-group-item">'+
                '<div class="row no-gutter no-side-margin">'+
                '<div class="col-xs-1">'+
                '<div class="text-center anchor clickable" href="../../actions/add_vote.php?questionId='+question.id+'&vote=1"><span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span></div>'+
                '<div class="text-center"><span>'+ question.rating +'</span></div>'+
                '<div class="text-center anchor clickable" href="../../actions/add_vote.php?questionId='+question.id+'&vote=0"><span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span></div>'+
                '</div>'+
                '<div class="col-xs-11 anchor clickable" href="question_page.php?id='+question.id+'">'+
                '<div class="col-xs-12">'+
                '<a class="small-text" href="../users/profile_page.php?id='+json['users'][i].id+'"><span>'+json['users'][i].name+' </span></a>'+
                '<span class="small-text">| '+ question.creationDate+'</span>'+
                '</div>'+
                '<span class="large-text col-xs-12">'+question.title+'</span>'+
                '</div>'+
                '</div>'+
                '</div>'
            );
            i++;
        }
        clickEvent();

        numberOfPages = json['numberOfPages'];

        console.log(json['tags']);

        if(numberOfPages > 1){
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
                '<img class="center-block img-circle img-responsive img-user-search" src="/images/user-default.png">'+
                '</div>'+
                '<div class="col-xs-9 anchor clickable user-text" href="../users/profile_page.php?id=' + user.id + '">' +
                '<span class="large-text col-xs-12">' + user.name+ '</span>' +
                '<span class="small-text col-xs-12">' + user.email+ '</span>' +
                '</div>' +
                '</div>' +
                '</div>'
            );
        }
        clickEvent();

        numberOfPages = json['numberOfPages'];

        console.log(numberOfPages);

        if(numberOfPages > 1){
            pagination();
        }
    }

}

function pagination(){
    $('#Pagination-Nav').append(
        '<ul id="Pagination-List" class="pagination">'+
        '<li id="Previous-Item">'+
        '<span class="clickable" onclick="previousRequest()" aria-hidden="true">&laquo;</span>'+
        '</li>'+
        '<li>'+
        '<span class="clickable" onclick="nextRequest()" aria-hidden="true">&raquo;</span>'+
        '</li>'+
        '</ul>');

    for(i=numberOfPages; i>0;i--){
        var classes = "";
        if(atualPage == i)
            classes = "active";

        $('#Previous-Item').after('<li class="'+classes+'">' +
            '<span onclick="paginationRequest('+i+')" class="clickable">'+i+'</span>' +
            '</li>');
    }
}