<div class="list-group small-bottom-margin col-xs-offset-{$content["indentation"]} col-xs-{"12"-$content["indentation"]}">
    <div class="list-group-item row no-gutter no-side-margin">
        <div class="col-xs-1">
            {include file="rating.tpl"}
        </div>
        <div class="col-xs-11">
            <div class="col-xs-12 col-sm-8">{$content["text"]}</div>
            <div class="col-xs-12 col-sm-4 text-align-right text-align-left-xs no-gutter stick-to-bottom">
                <a class="col-xs-6 col-sm-12 answer-author align-left-xs" href="#">{$content["author"]}</a>
                <span class="col-xs-6 col-sm-12 answer-date">{$content["date"]}</span>
            </div>
        </div>
    </div>
</div>
