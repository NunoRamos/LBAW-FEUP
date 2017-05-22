<div data-content-id="{$content.id}" class="list-group small-bottom-margin">
    <div class="list-group-item row no-gutter no-side-margin">
        <div class="col-xs-1">
            {include file="content/common/rating.tpl"}
        </div>
        <div class="col-xs-11 no-gutter">
            <div class="col-xs-10 no-gutter">
                <div class="col-xs-12 text-left">
                    <a class="small-text" href="#">{getUserNameById($content.creatorId)}</a>
                    <span class="small-text">{$content["creationDate"]}</span>
                </div>
                <div class="content-text text-wrap">

                    {if $content.deleted}
                        [deleted]
                    {else}
                        {$content["text"]}
                    {/if}
                </div>
            </div>
            <div class="col-xs-2 text-align-right no-gutter btn-toolbar">
                {if canDeleteContent($USERID, $content.id)}
                    <form class="btn-group pull-right" action="{$BASE_URL}actions/delete_content.php" method="post">
                        <input type="hidden" value="{$content.id}" name="content-id">
                        <button type="submit" class="btn btn-danger btn-xs"><span
                                    class="glyphicon glyphicon-trash"></span>
                        </button>
                    </form>
                {/if}
                {if canEditContent($USERID, $content.id)}
                    <div class="btn-group pull-right">
                        <button data-content-id="{$content.id}" class="btn btn-xs" onclick="toggleTextBox(this,1)"><span
                                    class="glyphicon glyphicon-pencil"></span>
                        </button>
                    </div>
                {/if}
                {if canReply($USERID)}
                    <div class="btn-group pull-right">
                        <button data-content-id="{$content.id}" class="btn btn-xs" onclick="toggleTextBox(this,0)"><span
                                    class="glyphicon glyphicon-comment"></span>
                        </button>
                    </div>
                {/if}
            </div>
        </div>
    </div>
    <div class="reply-text-box"></div>
    <div class="reply-indentation reply-top-margin">
        {foreach $content['children'] as $content}
            {include file="content/common/content.tpl"}
        {/foreach}
    </div>
</div>
