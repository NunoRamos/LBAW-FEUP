<a href="question_page.php" class="list-group-item">
    <div class="row no-gutter no-right-margin">
        <div class="col-xs-2 col-sm-1 center-text">
            <div class="glyphicon glyphicon-triangle-top" aria-hidden="true"></div>
            <div>{$question["rate"]}</div>
            <div class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></div>
        </div>
        <div class="col-xs-10 col-sm-11 no-gutter">
            <div class="question-title col-xs-12 col-sm-9">{$question["title"]}</div>
            <div class="col-xs-12 col-sm-3 text-align-right no-gutter">
                <span class="col-xs-6 col-sm-12">{$question["author"]}</span>
                <span class="col-xs-6 col-sm-12">{$question["date"]}</span>
            </div>
        </div>
    </div>
</a>
