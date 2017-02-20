{include file="header.tpl"}
<div class="container col-xs-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Question</h3>
        </div>
        <div class="list-group">
            {$questions=[["id" => "1", "title" => "Network Problems", "author" => "Nuno Ramos", "date" => "20/02/2017", "rate" => "5"],
            ["id" => "2", "title" => "Internet Problems", "author" => "Vasco Ribeiro", "date" => "19/02/2017", "rate" => "-2"]]}
            {$question = $questions[$smarty.get.id-1]}
            {include file="question.tpl"}
        </div>
    </div>
    <div class="col-xs-offset-1">
        <div class="list-group">
            {$answers=[["id" => "1", "text" => "Deixa de ser um noob", "date" => "20/02/2017","author" => "Bernardo Belchior"],
            ["id" => "2", "text" => "Isso é trivial, meu caro", "date" => "20/02/2017","author" => "João Gomes"]]}
            {foreach $answers as $answer}
                {include file="answer.tpl"}
            {/foreach}
        </div>
    </div>
    <div class="col-xs-offset-1">
        <div class="leave-answer-text">Leave your answer:</div>
        <form class="form-horizontal">
            <textarea class="form-control" rows="3" placeholder="Help Me"></textarea>
            <input class="btn btn-default submit-answer-btn" type="submit" value="Post Answer">
        </form>
    </div>
</div>
<div class="container col-xs-12 col-md-4 visible-lg visible-md" data-toogle="collapse">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Suggested Tags</h3>
        </div>
        <div class="panel-body list-group">
            <a href="#" class="list-group-item">Android</a>
            <a href="#" class="list-group-item">iOS</a>
            <a href="#" class="list-group-item">Windows Phone</a>
        </div>
    </div>
</div>

{include file="footer.tpl"}
