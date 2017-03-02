{include file="header.tpl"}
<link rel="stylesheet" href="../../trumbowyg/ui/trumbowyg.min.css">

{$question=["id" => "1", "title" => "Network Problems", "author" => "Nuno Ramos", "date" => "20/02/2017",
"rate" => "5", "text" => "Quando tento aceder à rede não consigo, porque será?"]}

<div class="container col-xs-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{$question["title"]}</h3>
        </div>
        <div class="panel-body">
            <div class="list-group small-bottom-margin">
                <div class="list-group-item">
                    <div class="row no-gutter no-right-margin">
                        <div class="col-xs-2 col-sm-1 center-text">
                            <div class="glyphicon glyphicon-triangle-top" aria-hidden="true"></div>
                            <div>{$question["rate"]}</div>
                            <div class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></div>
                        </div>
                        <div class="col-xs-10 col-sm-11 no-gutter">
                            <div class="question-text col-xs-12 col-sm-9">{$question["text"]}</div>
                            <div class="col-xs-12 col-sm-3 text-align-right text-align-left-xs no-gutter">
                                <a class="col-xs-6 col-sm-12 pull-right pull-left-xs align-left-xs" href="#">{$question["author"]}</a>
                                <span class="col-xs-6 col-sm-12 pull-right">{$question["date"]}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {$answers=[["id" => "1", "text" => "Deixa de ser um noob", "date" => "20/02/2017","author" => "Bernardo Belchior", "indentation" => "1", "rate" => "5"],
            ["id" => "2", "text" => "Tambem nao precisas de ficar chateado", "date" => "25/02/2017","author" => "Nuno Ramos", "indentation" => "2", "rate" => "-25"],
            ["id" => "3", "text" => "Isso é trivial, meu caro", "date" => "20/02/2017","author" => "João Gomes", "indentation" => "1", "rate" => "-10"]]}
            {foreach $answers as $answer}
                {include file="answer.tpl"}
            {/foreach}
            <div class="col-xs-offset-1">
                <div class="leave-answer-text">Leave your answer</div>
                <form class="form-horizontal">
                    <textarea id="reply-text" class="form-control" rows="3" placeholder="Help Me"></textarea>
                    <input class="btn btn-default submit-answer-btn" type="submit" value="Post Answer">
                </form>
            </div>
        </div>
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
<script src="../../trumbowyg/trumbowyg.min.js"></script>
<script src="javascript/question_page.js"></script>
