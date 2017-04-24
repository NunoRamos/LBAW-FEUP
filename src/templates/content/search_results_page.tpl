{include file="common/header.tpl"}
<!--
    Select2 for tag selection
    https://github.com/select2/select2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css"
      integrity="sha256-xJOZHfpxLR/uhh1BwYFS5fhmOAdIRQaiOul5F/b7v3s=" crossorigin="anonymous">
<link rel="stylesheet" href="{$BASE_URL}css/select2.css">

<div class="container-fluid">
    <div class="col-xs-12 col-sm-4 col-md-3">
        <!-- Result Type -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>Result Type</span>
                <button class="btn btn-default btn-xs pull-right" data-toggle="collapse"
                        data-target=".results-collapse">
                    <span class="collapse in results-collapse no-animation"><i
                                class="glyphicon glyphicon-resize-small"></i></span>
                    <span class="collapse results-collapse"><i class="glyphicon glyphicon-resize-full"></i></span>
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
                <button class="btn btn-default btn-xs pull-right" data-toggle="collapse"
                        data-target=".filters-collapse">
                    <span class="collapse in filters-collapse"><i
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
                    <!-- Inline width is MANDATORY for responsiveness. https://select2.github.io/examples.html#responsive -->
                    <select id="tags-select" multiple="multiple" style="width: 100%;">
                        <!-- Add these options dinamically  -->
                        <option value="android">Android</option>
                        <option value="ios">iOS</option>
                        <option value="java">Java</option>
                        <option value="bootstrap">Bootstrap</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-8 col-md-9">
        <div id="Search-Question-Panel-Sister">
            <div class="input-group form-group">
                <input id="Search-Bar" type="text" name="search" class="form-control" placeholder="Search" value="{$inputString}"/>
                <span class="input-group-btn">
                        <button id="Search-Results-Button" class="btn btn-default" type="submit"><i
                                    class="glyphicon glyphicon-search"></i></button>
            </span>
            </div>
        </div>

        <div id="Search-Question-Panel" class="panel panel-default"></div>

        {if count($questions) > 10}
            <nav aria-label="Page navigation" class="text-center">
                <ul class="pagination">
                    <li>
                        <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li>
                        <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        {/if}
    </div>
</div>

{include file="common/footer.tpl"}

<script src="https://cdn.jsdelivr.net/select2/4.0.3/js/select2.min.js"
        integrity="sha256-+mWd/G69S4qtgPowSELIeVAv7+FuL871WXaolgXnrwQ=" crossorigin="anonymous"></script>
<script src="{$BASE_URL}javascript/search_results_page.js"></script>
<script src="{$BASE_URL}javascript/clickable_div.js"></script>
