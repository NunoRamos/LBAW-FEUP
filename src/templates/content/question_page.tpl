{include file="common/header.tpl"}
<!--
    Select2 for tag selection
    https://github.com/select2/select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css"
      integrity="sha256-xJOZHfpxLR/uhh1BwYFS5fhmOAdIRQaiOul5F/b7v3s=" crossorigin="anonymous">
<link rel="stylesheet" href="{$BASE_URL}css/select2.css">
<link rel="stylesheet" href="{$BASE_URL}lib/trumbowyg/ui/trumbowyg.min.css">

<div id="question" data-content-id="{$content["id"]}" class="container col-xs-12 col-md-8 full-screen-xs">
    <span id="token" class="hidden">{$TOKEN}</span>
    <div id="{$content["id"]}" class="panel panel-default">
        <div id="title-container" class="panel-heading">
            {if canCloseQuestion($USERID, $content["id"])}
                <div class="btn-group pull-right">
                    <form class="inline" action="../../actions/toggle_question_closure.php" method="post">
                        <input type="hidden" name="token" value="{$TOKEN}">
                        <input type="hidden" name="content-id" value="{$content['id']}">
                        <button class="btn btn-xs lock">
                            <img class="full-width"
                                 {if isQuestionClosed($content["id"])}src="https://cdn2.iconfinder.com/data/icons/font-awesome/1792/unlock-alt-128.png"
                                 {else}src="https://cdn4.iconfinder.com/data/icons/font-awesome-2/2048/f023-128.png"{/if}>
                        </button>
                    </form>
                </div>
            {/if}
            {if canEditContent($USERID, $content["id"])}
                <div class="btn-group small-right-margin pull-right">
                    <button class="btn btn-xs" onclick="toggleTitleInput()">
                        <span class="glyphicon glyphicon-black glyphicon-pencil"></span>
                    </button>
                </div>
            {/if}
            <h3 id="question-title-header" class="panel-title">{$content["title"]}</h3>
            {assign "questionId" $content["id"]}
            <form id="edit-title-form" style="display: none" class="" method="post"
                  action="../../actions/edit_content.php">
                <input type="hidden" name="content-id panel-title" value="{$content["id"]}">
                <input type="hidden" name="edit-type" value="{$TITLE}">
                <div class="pull-right small-right-margin">
                    <button class="btn btn-xs" type="submit">
                        <span class="glyphicon glyphicon-black glyphicon-floppy-disk"></span>
                    </button>
                </div>
                <div class="edit-title-input">
                    <input name="title" class="full-width" value="{$content["title"]}" title="Title">
                </div>
            </form>
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
            {$canEditContent = canEditContent($USERID, $content["id"])}
            {if $canEditContent}
                <div class="btn-group pull-right">
                    <button class="btn btn-xs" onclick="toggleTagEditMode()"><span
                                class="glyphicon glyphicon-black glyphicon-plus"></span>
                    </button>
                </div>
            {/if}
        </div>
        <div id="tags-panel-body" class="panel-body list-group">
            <div id="tags">
                {if sizeof($questionTags)==0}
                    <p class="list-group-item">This question has no tags.</p>
                {else}
                    {foreach $questionTags as $tag}
                        <span class="list-group-item">
                            <a href="search_results.php?activeTags={$tag['id']}">{$tag['name']}</a>
                            {if canEditContent($USERID, $content["id"])}
                                <button class="btn btn-xs pull-right" onclick="deleteTag(this,{$tag['id']})"><span
                                            class="glyphicon glyphicon-black glyphicon-minus"></span>
                            </button>
                            {/if}
                    </span>
                    {/foreach}
                {/if}
            </div>
            {if $canEditContent}
                <div id="add-tags" style="display: none;">
                    <!-- Inline width is MANDATORY for responsiveness. https://select2.github.io/examples.html#responsive -->
                    <select id="tags-select" multiple="multiple" style="width: 100%;"></select>
                    <input class="btn btn-default submit-answer-btn" onclick="saveNewTags()" type="submit"
                           value="Add Tags">
                </div>
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
