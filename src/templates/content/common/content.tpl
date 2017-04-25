<div class="list-group small-bottom-margin col-xs-offset-{$content["indentation"]} col-xs-{"12"-$content["indentation"]}">
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
                <div>
                    {$content["text"]}
                </div>
            </div>
            <div class="col-xs-2 text-align-right no-gutter btn-toolbar">
                {if canDeleteContent($USERID, $content.id)}
                    <div class="btn-group pull-right">
                        <button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span>
                        </button>
                    </div>
                {/if}
                {if canReply($USERID)}
                    <div class="btn-group pull-right">
                        <button data-contentid="{$content.id}" class="btn btn-xs" onclick="toggleReplyBox(this)"><span class="glyphicon glyphicon-comment"></span>
                        </button>
                    </div>
                {/if}
            </div>
        </div>
    </div>
</div>
{foreach $content['children'] as $content}
    {include file="content/common/content.tpl"}
{/foreach}