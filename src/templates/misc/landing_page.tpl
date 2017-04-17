{include file="common/header.tpl"}
<div class="container col-xs-12 col-md-8 full-screen-xs">
    <div class="panel panel-default">
        <div class="panel-heading panel-style">
            <h3 class="panel-title">Top Questions</h3>
        </div>
        <div class="list-group">
            {$questions=[["id" => "1", "title" => "Network Problems", "author" => "Nuno Ramos", "date" => "20/02/2017", "rating" => "5"],
            ["id" => "2", "title" => "Internet Problems", "author" => "Vasco Ribeiro", "date" => "19/02/2017", "rating" => "-2"],
            ["id" => "3", "title" => "How to Reverse animation?", "author" => "Bernardo Belchior", "date" => "20/03/2017", "rating" => "10"],
            ["id" => "4", "title" => "Can i run Azure Functions in code?", "author" => "João Gomes", "date" => "12/02/2017", "rating" => "2"],
            ["id" => "5", "title" => "xml transformation with dynamic xml data", "author" => "Nuno Ramos", "date" => "14/01/2017", "rating" => "4"],
            ["id" => "6", "title" => "Breakpoints in Android SDK. Android Studio", "author" => "Bernardo Belchior", "date" => "15/08/2016", "rating" => "5"],
            ["id" => "7", "title" => "regex select only if string not start with //", "author" => "Vasco Ribeiro", "date" => "25/10/2016", "rating" => "5"]]}
            {foreach $questions as $content}
                <div class="list-group-item anchor clickable" href="../content/question_page.php">
                    {include file="content/common/question_overview.tpl"}
                </div>
            {/foreach}
        </div>
    </div>
</div>
<div class="container col-xs-12 col-md-4 full-screen-xs">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Suggested Tags</h3>
        </div>
        <div class="panel-body list-group">
            <a href="../content/search_results.php" class="list-group-item">Android</a>
            <a href="../content/search_results.php" class="list-group-item">iOS</a>
            <a href="../content/search_results.php" class="list-group-item">Windows Phone</a>
        </div>
    </div>
</div>
{include file="{$BASE_DIR}common/footer.tpl"}
<script src="{$BASE_DIR}javascript/clickable_div.js"></script>