{include file="header.tpl"}

<div class="container">
    <div class="row row-centered ">
        <div class="col-md-12 well">

            <div class="col-md-3"><img src="../img/user-default.png" width="200em" height="200em" class="img-circle"></div>
            <div class="col-xs-4">
                <h1><strong>João Gomes</strong></h1>
            </div>
            <div class="col-xs-8 divider">
                <div class="col-xs-4 col-sm-4 emphasis">
                    <h2><strong> 20,7K </strong></h2>
                    <p><small>Followers</small></p>
                </div>
                <div class="col-xs-4 col-sm-4 emphasis">
                    <h2><strong>245</strong></h2>
                    <p><small>Questions</small></p>

                </div>
                <div class="col-xs-4 col-sm-4 emphasis">
                    <h2><strong>43</strong></h2>
                    <p><small>Answers</small></p>
                </div>
            </div>

        </div>

    </div>
    <div class="row row-centered ">
        <div class="col-md-3">
            <div class="panel panel-default ">
                <div class="panel-heading center-text">
                    <h1 class="panel-title">Bio</h1>
                </div>
                <div class="container"
                <cite title="Porto, Portugal">Porto, Portugal<i class="glyphicon glyphicon-map-marker">
                    </i></cite>
                <p>
                    <i class="glyphicon glyphicon-envelope"></i> gomes@example.com
                    <br />
                    <i class="glyphicon glyphicon-globe"></i><a href="http://www.jquery2dotnet.com"> www.jquery2dotnet.com</a>
                    <br />
                    <i class="glyphicon glyphicon-gift"></i> June 02, 1996</p>
            </div>
        </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li><a href="#">Questions</a></li>
                        <li><a href="#">Answers</a></li>
                    </ul>
                </div>

                <div class="list-group">
                    {$questions=[["id" => "1", "title" => "Network Problems", "author" => "Nuno Ramos", "date" => "20/02/2017", "rate" => "5"],
                    ["id" => "2", "title" => "Internet Problems", "author" => "Vasco Ribeiro", "date" => "19/02/2017", "rate" => "-2"]]}
                    {foreach $questions as $question}
                        {include file="question.tpl"}
                    {/foreach}
                </div>
            </div>

        </div>

    </div>
</div>
{include file="footer.tpl"}
