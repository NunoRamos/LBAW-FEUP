$(document).ready(function () {
    $('#tags-select').select2();

    ajaxRequest();

    $('#Search-Bar').on('input', ajaxRequest);

    $('#Search-Results-Button').on('click',ajaxRequest);
});

function ajaxRequest() {

    var input = $('#Search-Bar').val();

    if(input == '')
        return;

    $('#Search-Question-Panel').children().remove();

    console.log(input);

    $.ajax({
        method: "GET",
        url: "../../api/search_questions.php",
        data: { inputString: input }
    }).done(buildSearchResults);
}

function buildSearchResults(response){

    var json = JSON.parse(response);
     
    $('#Search-Question-Panel').children().remove();

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
    }

}
