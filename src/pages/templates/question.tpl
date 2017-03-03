<a href="question_page.php" class="list-group-item">
    <div class="row no-gutter no-side-margin">
        <div class="col-xs-1">
            <div class="text-center"><span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span></div>
            <div class="text-center"><span>{$question["rate"]}</span></div>
            <div class="text-center"><span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span></div>
        </div>
        <div class="col-xs-11">
            <div class="question-title col-xs-12 col-sm-9">{$question["title"]}</div>
            <div class="col-xs-12 col-sm-3 text-align-right no-gutter text-align-left-xs">
                <span class="col-xs-6 col-sm-12 align-left-xs">{$question["author"]}</span>
                <span class="col-xs-6 col-sm-12">{$question["date"]}</span>
            </div>
        </div>
    </div>
</a>
