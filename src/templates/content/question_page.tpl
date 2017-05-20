{include file="common/header.tpl"}
<link rel="stylesheet" href="{$BASE_URL}lib/trumbowyg/ui/trumbowyg.min.css">

<div id="question" class="container col-xs-12 col-md-8 full-screen-xs">
    <div id="{$content["id"]}" class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title inline">{$content["title"]}</h3>
            {assign "questionId" $content["id"]}
        </div>
        <div class="panel-body">
            <div class="small-bottom-margin">
                {include file="content/common/content.tpl"}
            </div>
        </div>
    </div>
</div>
<div class="container col-xs-12 col-md-4 full-screen-xs">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Suggested Tags</h3>
        </div>
        <div class="panel-body list-group">
            <a href="search_results.php" class="list-group-item">Android</a>
            <a href="search_results.php" class="list-group-item">iOS</a>
            <a href="search_results.php" class="list-group-item">Windows Phone</a>
        </div>
    </div>
</div>

{include file="common/footer.tpl"}
<script src="{$BASE_URL}lib/trumbowyg/trumbowyg.min.js"></script>
<script src="{$BASE_URL}javascript/question_page.js"></script>
<script src="{$BASE_URL}javascript/vote.js"></script>
