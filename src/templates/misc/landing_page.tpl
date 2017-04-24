{include file="common/header.tpl"}
<div class="container col-xs-12 col-md-8 full-screen-xs">
    <div class="panel panel-default">
        <div class="panel-heading panel-style">
            <h3 class="panel-title">Top Questions</h3>
        </div>
        <div class="list-group">
            {foreach $questions as $content}
                <div class="list-group-item anchor clickable" href="../content/question_page.php?id={$content.id}">
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
        {foreach $tags as $tag}
            <a href="../content/search_results.php" class="list-group-item">{$tag['name']}</a>
            {/foreach}
        </div>
    </div>
</div>
{include file="common/footer.tpl"}
<script src="{$BASE_URL}javascript/clickable_div.js"></script>