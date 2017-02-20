{include file="header.tpl"}
<div class="container col-xs-12 col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Top Questions</h3>
        </div>
        <div class="panel-body list-group">
            {$questions=[["id" => "1", "title" => "Network Problems", "author" => "Nuno Ramos", "date" => "20/02/2017", "rate" => "5"],
                            ["id" => "2", "title" => "Internet Problems", "author" => "Vasco Ribeiro", "date" => "19/02/2017", "rate" => "-2"]]}
            {foreach $questions as $question}
                {include file="question.tpl"}
            {/foreach}
        </div>
    </div>
</div>
<div class="container col-xs-12 col-md-4">
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
