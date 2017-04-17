{include file="common/header.tpl"}
<link rel="stylesheet" href="/lib/trumbowyg/ui/trumbowyg.min.css">

{$content=["id" => "1", "title" => "Network Problems", "author" => "Nuno Ramos", "date" => "20/02/2017",
"rating" => "5", "text" => "Quando tento aceder à rede não consigo, porque será?", "indentation" => "0"]}

<div class="container col-xs-12 col-md-8 full-screen-xs">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title inline">{$content["title"]}</h3>
            {if canDeleteOwnContent() || canDeleteAnyContent()}
                <button class="btn btn-danger btn-xs pull-right"><span class="glyphicon glyphicon-trash"></span>
                </button>
            {/if}
        </div>
        <div class="panel-body">
            <div class="small-bottom-margin medium-left-padding">
                {include file="content/common/content.tpl"}
            </div>

            {$answers=[["id" => "1", "text" => "Deixa de ser um noob", "date" => "20/02/2017","author" => "Bernardo Belchior", "indentation" => "1", "rating" => "5"],
            ["id" => "2", "text" => "Tambem nao precisas de ficar chateado", "date" => "25/02/2017","author" => "Nuno Ramos", "indentation" => "2", "rating" => "-25"],
            ["id" => "3", "text" => "Isso é trivial, meu caro", "date" => "20/02/2017","author" => "João Gomes", "indentation" => "1", "rating" => "-10"]]}
            {foreach $answers as $content}
                {include file="content/common/content.tpl"}
            {/foreach}
            <div class="col-xs-12">
                <form class="form-horizontal">
                    <textarea id="reply-text" class="form-control" rows="3" placeholder="Answer"></textarea>
                    <input class="btn btn-default submit-answer-btn" type="submit" value="Post Answer">
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container col-xs-12 col-md-4 full-screen-xs">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Suggested Tags</h3>
        </div>
        <div class="panel-body list-group">
            <a href="search_results.php" class="list-group-item">Android</a>
            <a href="search_results.php" class="list-group-item">iOS</a>
            <a href="search_results.php" class="list-group-item">Windows Phone</a>
        </div>
    </div>
</div>

{include file="common/footer.tpl"}
<script src="/lib/trumbowyg/trumbowyg.min.js"></script>
<script src="/javascript/question_page.js"></script>
