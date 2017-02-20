{include file="header.tpl"}
<div class="container col-xs-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Question</h3>
        </div>
        <div class="list-group">
            {$question=["id" => "1", "title" => "Network Problems", "author" => "Nuno Ramos", "date" => "20/02/2017",
            "rate" => "5", "text" => "Quando tento aceder à rede não consigo, porque será?"]}
            <div class="list-group-item">
                <div class="row">
                    <div class="col-xs-2 col-sm-1 center-text">
                        <div class="glyphicon glyphicon-triangle-top" aria-hidden="true"></div>
                        <div>{$question["rate"]}</div>
                        <div class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></div>
                    </div>
                    <div class="col-xs-10 col-sm-11">
                        <div class="question-title">{$question["title"]}</div>
                        <div class="question-text">{$question["text"]}</div>
                        <span class="question-author">By {$question["author"]}</span>
                        <span class="pull-right">{$question["date"]}</span>
                    </div>
                </div>
            </div>
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
