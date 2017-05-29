{include file="common/header.tpl"}
<!--
    Select2 for tag selection
    https://github.com/select2/select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css"
      integrity="sha256-xJOZHfpxLR/uhh1BwYFS5fhmOAdIRQaiOul5F/b7v3s=" crossorigin="anonymous">
<link rel="stylesheet" href="{$BASE_URL}css/select2.css">
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
                    <button class="btn btn-xs" onclick="askForAllTags()"><span
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
                    <div class="row list-group-item">
                        <a href="search_results.php" class="col-xs-10">{$tag['name']}</a>
                        {if canEditContent($USERID, $content["id"])}
                            <div class="btn-group col-xs-2">
                                <button class="btn btn-xs" onclick="deleteTag(this,{$tag['id']})"><span
                                            class="glyphicon glyphicon-minus"></span>
                                </button>
                            </div>
                        {/if}
                    </div>
                {/foreach}
            {/if}
        </div>
    </div>
</div>

{include file="common/footer.tpl"}
<script src="https://cdn.jsdelivr.net/select2/4.0.3/js/select2.min.js"
        integrity="sha256-+mWd/G69S4qtgPowSELIeVAv7+FuL871WXaolgXnrwQ=" crossorigin="anonymous"></script>
<script src="{$BASE_URL}lib/trumbowyg/trumbowyg.min.js"></script>
<script src="{$BASE_URL}javascript/question_page.js"></script>
<script src="{$BASE_URL}javascript/clickable_div.js"></script>
<script src="{$BASE_URL}javascript/vote.js"></script>
