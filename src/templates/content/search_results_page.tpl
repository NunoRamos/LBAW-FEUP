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
                <button id="search-type-questions" type="button" value="{$SEARCH_FOR_QUESTIONS}"
                        class="list-group-item search-type highlight selected">Questions
                </button>
                <button id="search-type-users" type="button" value="{$SEARCH_FOR_USERS}"
                        class="list-group-item search-type highlight">Users
                </button>
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
                <form class="form-horizontal question-filter filter-list">
                    <h5><strong>Sort By</strong></h5>
                    <a class="filter highlight selected" value="{$SIMILARITY}">Best Match</a>
                    <a class="filter highlight" value="{$RATING_ASC}">Rating - Ascending</a>
                    <a class="filter highlight" value="{$RATING_DESC}">Rating - Descending</a>
                    <a class="filter highlight" value="{$NUM_REPLIES_ASC}">Answers - Ascending</a>
                    <a class="filter highlight" value="{$NUM_REPLIES_DESC}">Answers - Descending</a>
                </form>
                <form class="form-horizontal user-filter filter-list">
                    <h5><strong>Sort By</strong></h5>
                    <a class="filter highlight selected" value="{$NUM_REPLIES_ASC}">Best Match</a>
                    <a class="filter highlight" value="{$NUM_REPLIES_ASC}">Answers - Ascending</a>
                    <a class="filter highlight" value="{$NUM_REPLIES_DESC}">Answers - Descending</a>
                    <!-- FIXME: -->
                    <a class="filter highlight" value="{$NUM_REPLIES_ASC}">Questions - Ascending</a>
                    <a class="filter highlight" value="{$NUM_REPLIES_ASC}">Questions - Descending</a>
                    <!-- FIXME: -->
                </form>
                <form class="form-horizontal question-filter filter-list">
                    <h5><strong>Tags</strong></h5>
                    <!-- Inline width is MANDATORY for responsiveness. https://select2.github.io/examples.html#responsive -->
                    <select id="tags-select" multiple="multiple" style="width: 100%;">
                        {foreach $tags as $tag}
                            <option value="{$tag['id']}">{$tag['name']}</option>
                        {/foreach}
                    </select>
                </form>
            </div>
        </div>
    </div>
    <nav id="main-div" class="col-xs-12 col-sm-8 col-md-9">
        <div id="search-question-panel-sister">
            <div class="input-group form-group">
                <input id="search-bar" type="text" name="search" class="form-control" placeholder="Search"
                       value="{$inputString}"/>
                <span class="input-group-btn">
                        <button id="search-results-button" class="btn btn-default" type="submit"><i
                                    class="glyphicon glyphicon-search"></i></button>
            </span>
            </div>
        </div>

        <div id="search-question-panel" class="panel panel-default loading">
            <img src="/images/rolling.svg"/>
        </div>
        <nav id="pagination-nav" aria-label="Page navigation" class="text-center">
            <ul id="pagination-list" class="pagination">

            </ul>
        </nav>
</div>

{include file="common/footer.tpl"}
<script src="https://cdn.jsdelivr.net/select2/4.0.3/js/select2.min.js"
        integrity="sha256-+mWd/G69S4qtgPowSELIeVAv7+FuL871WXaolgXnrwQ=" crossorigin="anonymous"></script>
<script src="{$BASE_URL}javascript/search_results_page.js"></script>
<script src="{$BASE_URL}javascript/clickable_div.js"></script>
