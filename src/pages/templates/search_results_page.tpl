{include file="header.tpl"}

<div class="container-fluid">
    <div class="col-xs-12 col-sm-4 col-md-3">
        <!-- Result Type -->
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
        <!-- Filters -->
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
                <form class="form-horizontal filter-list">
                    <h5><strong>Sort By</strong></h5>
                    <a class="filter">Popularity</a>
                    <a class="filter">Answers - Ascending</a>
                    <a class="filter">Answers - Descending</a>
                    <a class="filter">Rating - Ascending</a>
                    <a class="filter">Rating - Descending</a>
                </form>

                <form class="form-horizontal filter-list">
                    <h5><strong>Tags</strong></h5>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search"/>
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i
                                    class="glyphicon glyphicon-search"></i></button></span>
                    </div>

                    <!-- Results -->
                    <a class="filter">Android</a>
                    <a class="filter">iOS</a>
                    <a class="filter">Java</a>
                    <a class="filter">Bootstrap</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-8 col-md-9">
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
