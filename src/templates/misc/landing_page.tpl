{include file="common/header.tpl"}
<div class="container col-xs-12 col-md-8 full-screen-xs">
    <div class="panel panel-default">
        <div class="panel-heading panel-style">
            <h3 class="panel-title">Top Questions</h3>
        </div>
        <div class="list-group">
            {foreach $questions as $content}
                {include file="content/common/question_overview.tpl"}
            {/foreach}
        </div>
    </div>
</div>
<div class="container col-xs-12 col-md-4 full-screen-xs">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Top 5 Most Used Tags</h3>
        </div>
        <div class="panel-body list-group">
            {foreach $tags as $tag}
                <a href="../content/search_results.php?activeTags={$tag['name']}"
                   class="list-group-item">{$tag['name']}</a>
            {/foreach}
        </div>
    </div>
</div>
{if $USERID}
    <div class="container col-xs-12 col-md-4 full-screen-xs pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Suggests a Tag</h3>
            </div>
            <div id="form-pending-tag" class="panel-body list-group">
                <input id="new-pending-tag-name" type="text">
                <button id="submit-tag" class="btn btn-default submit-answer-btn">Submit</button>
            </div>
        </div>
    </div>
{/if}
{include file="common/footer.tpl"}
<script src="{$BASE_URL}javascript/clickable_div.js"></script>
<script src="{$BASE_URL}javascript/vote.js"></script>
<script src="{$BASE_URL}javascript/landing_page.js"></script>