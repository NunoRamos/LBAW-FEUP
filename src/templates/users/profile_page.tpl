{include file="../common/header.tpl"}

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="inline">Profile</h4>
        <a href="#" class="btn btn-primary btn-danger pull-right">Ban User</a>
    </div>
    <div class="panel-body">
        <div class="col-xs-12 col-sm-4">
            <img class="center-block img-circle img-responsive img-profile" src="/images/user-default.png">
        </div>
        <div class="col-xs-12 col-sm-8">
            <h1 class="large-padding-bottom">Joao Gomes</h1>
            <div id="bio" class="panel panel-default">
                <div class="panel-heading">Bio</div>
                <div class="well no-bottom-margin">
                    <i class="glyphicon glyphicon-map-marker"> </i> Porto, Portugal<br>
                    <i class="glyphicon glyphicon-envelope"></i> gomes@example.com<br>
                    <i class="glyphicon glyphicon-globe"></i> www.jquery2dotnet.com<br>
                    <i class="glyphicon glyphicon-gift"></i> June 02, 1996
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Questions Made</h5>
            </div>
            <div class="list-group">
                {$questions=[["id" => "1", "title" => "Network Problems", "author" => "Nuno Ramos", "date" => "20/02/2017", "rating" => "5"],
                ["id" => "2", "title" => "Internet Problems", "author" => "Vasco Ribeiro", "date" => "19/02/2017", "rating" => "-2"]]}
                {foreach $questions as $content}
                    <div class="list-group-item anchor clickable" href="question_page.php">
                        {include file="../content/common/question_overview.tpl"}
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Answers Given</h5>
            </div>
            <div class="list-group">
                {$questions=[["id" => "1", "title" => "Network Problems", "author" => "Nuno Ramos", "date" => "20/02/2017", "rating" => "5"],
                ["id" => "2", "title" => "Internet Problems", "author" => "Vasco Ribeiro", "date" => "19/02/2017", "rating" => "-2"]]}
                {foreach $questions as $content}
                    <div class="list-group-item anchor clickable" href="question_page.php">
                        {include file="../content/common/question_overview.tpl"}
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>

{include file="../common/footer.tpl"}
<script src="{$BASE_URL}javascript/clickable_div.js"></script>
