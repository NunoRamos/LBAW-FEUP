{include file="header.tpl"}

<div class="container-fluid">
    <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>Result Type</span>
                <button class="btn btn-default btn-xs pull-right visible-xs" data-toggle="collapse"
                        data-target=".results-collapse">
                    <span class="collapse in results-collapse no-animation"><i
                                class="glyphicon glyphicon-resize-small"></i></span>
                    <span class="collapse results-collapse no-animation"><i class="glyphicon glyphicon-resize-full"></i></span>
            </div>
            <div class="list-group collapse in results-collapse">
                <button type="button" class="list-group-item">Questions</button>
                <button type="button" class="list-group-item">Users</button>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>Filters</span>
                <button class="btn btn-default btn-xs pull-right visible-xs" data-toggle="collapse"
                        data-target=".filters-collapse">
                    <span class="collapse in filters-collapse no-animation"><i
                                class="glyphicon glyphicon-resize-small"></i></span>
                    <span class="collapse filters-collapse no-animation"><i
                                class="glyphicon glyphicon-resize-full"></i></span>
            </div>
            <div class="panel-body collapse in filters-collapse">
                <div class="panel panel-default no-bottom-margin">
                    <div class="panel-heading">Sort By</div>
                    <div class="list-group">
                        <button type="button" class="list-group-item">Popularity</button>
                        <button type="button" class="list-group-item">Answers - Ascending</button>
                        <button type="button" class="list-group-item">Answers - Descending</button>
                        <button type="button" class="list-group-item">Rating - Ascending</button>
                        <button type="button" class="list-group-item">Rating - Descending</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container col-xs-12 col-sm-8 col-md-9">

        <form action="">
            <div class="input-group form-group">
                <input type="text" name="search" class="form-control" placeholder="Search"/>
                <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i
                                    class="glyphicon glyphicon-search"></i></button>
                    </span>
            </div>
        </form>

        {$questions=[["id" => "1", "title" => "Network Problems", "author" => "Nuno Ramos", "date" => "20/02/2017", "rate" => "5"],
        ["id" => "2", "title" => "Internet Problems", "author" => "Vasco Ribeiro", "date" => "19/02/2017", "rate" => "-2"]]}
        {foreach $questions as $question}
            {include file="question.tpl"}
        {/foreach}
    </div>

</div>
{include file="footer.tpl"}
