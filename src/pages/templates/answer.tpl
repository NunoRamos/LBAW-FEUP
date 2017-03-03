<div class="list-group small-bottom-margin col-xs-offset-{$answer["indentation"]} col-xs-{"12"-$answer["indentation"]}">
    <div class="list-group-item row no-gutter no-right-margin">
        <div class="col-xs-2 col-sm-1 center-text">
            <div class="glyphicon glyphicon-triangle-top" aria-hidden="true"></div>
            <div>{$answer["rate"]}</div>
            <div class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></div>
        </div>
        <div class="col-xs-10 col-sm-11 no-gutter">
            <div class="col-xs-12 col-sm-8">{$answer["text"]}</div>
            <div class="col-xs-12 col-sm-4 text-align-right text-align-left-xs no-gutter">
                <a class="col-xs-6 col-sm-12 answer-author align-left-xs" href="#">{$answer["author"]}</a>
                <span class="col-xs-6 col-sm-12 answer-date">{$answer["date"]}</span>
            </div>
        </div>
    </div>
</div>
