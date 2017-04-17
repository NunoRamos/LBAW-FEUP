{include file="common/header.tpl"}
<link rel="stylesheet" href="{$BASE_URL}lib/trumbowyg/ui/trumbowyg.min.css">

<div class="container col-xs-12 col-md-8 full-screen-xs">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title inline">{$content["title"]}</h3>
            {assign $content.indentation 0}
        </div>
        <div class="panel-body">
            <div class="small-bottom-margin medium-left-padding">
                {include file="content/common/content.tpl"}
            </div>
            {foreach $answers as $content}
                {include file="content/common/content.tpl"}
            {/foreach}
            <div class="col-xs-12">
                <form class="form-horizontal">
                    <textarea id="reply-text" class="form-control" rows="3" placeholder="Answer"></textarea>
                    <input class="btn btn-default submit-answer-btn" type="submit" value="Post Answer">
                </form>
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
