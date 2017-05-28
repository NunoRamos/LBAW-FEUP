{include file="common/header.tpl"}
<link rel="stylesheet" href="{$BASE_URL}lib/trumbowyg/ui/trumbowyg.min.css">

<div id="question" class="container col-xs-12 col-md-8 full-screen-xs">
    <div id="{$content["id"]}" class="panel panel-default">
        <div id="title-container" class="panel-heading">
            <h3 id="question-title-header" class="panel-title inline">{$content["title"]}</h3>
            {assign "questionId" $content["id"]}
            <form id="edit-title-form" style="display: none" class="panel-title inline" method="post" action="../../actions/edit_content.php">
                <input type="hidden" name="content-id" value="{$content["id"]}">
                <input type="hidden" name="edit-type" value="{$TITLE}">
                <input class="edit-title-input" name="title" value="{$content["title"]}">
                <input class="btn btn-default submit-answer-btn btn-xs" type="submit" value="Edit Title">
            </form>
            {if canEditContent($USERID, $content["id"])}
                <div class="btn-group pull-right">
                    <button data-content-id="{$content["id"]}" class="btn btn-xs" onclick="toggleTitleInput()"><span
                                class="glyphicon glyphicon-pencil"></span>
                    </button>
                </div>
            {/if}
        </div>
        <div id="main-body" class="panel-body">
            <div class="small-bottom-margin">
                {include file="content/common/content.tpl"}
            </div>
        </div>
    </div>
</div>
<div class="container col-xs-12 col-md-4 full-screen-xs">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title inline">Question Tags</h3>
            {if canEditContent($USERID, $content["id"])}
                <div class="btn-group pull-right">
                    <button class="btn btn-xs" onclick="toggleAddTags()"><span
                                class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
            {/if}
        </div>
        <div id="tags" class="panel-body list-group">
            {if sizeof($questionTags)==0}
                <p class="list-group-item">No tags for this question</p>
            {else}
                {foreach $questionTags as $tag}
                    <div>
                        <a href="search_results.php" class="list-group-item inline">{$tag['name']}</a>
                        <div class="btn-group pull-right">
                            <button class="btn btn-xs" onclick="deleteTag(this,{$tag['id']})"><span
                                        class="glyphicon glyphicon-minus"></span>
                            </button>
                        </div>
                    </div>
                {/foreach}
            {/if}
        </div>
    </div>
</div>

{include file="common/footer.tpl"}
<script src="{$BASE_URL}lib/trumbowyg/trumbowyg.min.js"></script>
<script src="{$BASE_URL}javascript/question_page.js"></script>
<script src="{$BASE_URL}javascript/clickable_div.js"></script>
<script src="{$BASE_URL}javascript/vote.js"></script>
