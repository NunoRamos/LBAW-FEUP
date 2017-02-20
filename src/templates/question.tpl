<a href="index.php?page=question_page&id={$question["id"]}" class="list-group-item">
    <div class="row">
        <div class="col-xs-1 center-text">
            <div class="glyphicon glyphicon-triangle-top" aria-hidden="true"></div>
            <div>{$question["rate"]}</div>
            <div class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></div>
        </div>
        <div class="col-xs-11">
            <div class="question-title">{$question["title"]}</div>
            <span>By {$question["author"]}</span>
            <span class="pull-right">{$question["date"]}</span>
        </div>
    </div>
</a>
