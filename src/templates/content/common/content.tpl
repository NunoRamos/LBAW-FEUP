<div class="list-group small-bottom-margin col-xs-offset-{$content["indentation"]} col-xs-{"12"-$content["indentation"]}">
    <div class="list-group-item row no-gutter no-side-margin">
        <div class="col-xs-1">
            {include file="content/common/rating.tpl"}
        </div>
        <div class="col-xs-11 no-gutter">
            <div class="col-xs-11 no-gutter">
                <div class="col-xs-12 text-left">
                    <a class="small-text" href="#">{getUserNameById($content.creatorId)}</a>
                    <span class="small-text">{$content["creationDate"]}</span>
                </div>
                <div>
                    {$content["text"]}
                </div>
            </div>
            <div class="col-xs-1 text-align-right no-gutter">
                {if canDeleteContent($USERID, $content.id)}
                    <button class="btn btn-danger btn-xs pull-right"><span class="glyphicon glyphicon-trash"></span>
                    </button>
                {/if}
            </div>
        </div>
    </div>
</div>
