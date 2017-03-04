{include file="header.tpl"}

<div class="container">
    <div class="row row-centered">
        <div class="col-sm-12 col-xs-12 well">

            <div class="col-sm-3"><img src="../img/user-default.png" width="200em" height="200em"
                                       class="img-circle img-responsive img-profile">
            </div>
            <div class="col-sm-9 col-xs-12">
                <h1 class="name-center"><strong>João Gomes</strong>
                    <a href="#" class="btn btn-primary btn-danger button-right img-profile">Ban User</a>
            </div>

            <div class="col-sm-8 col-xs-12 divider">
                <div class="col-xs-4 col-sm-4 emphasis text-center">
                    <h2><strong>200</strong></h2>
                    <p>
                        <small>Followers</small>
                    </p>
                </div>
                <div class="col-xs-4 col-sm-4 emphasis text-center">
                    <h2><strong>245</strong></h2>
                    <p>
                        <small>Questions</small>
                    </p>

                </div>
                <div class="col-xs-4 col-sm-4 emphasis text-center">
                    <h2><strong>43</strong></h2>
                    <p>
                        <small>Answers</small>
                    </p>
                </div>
            </div>

        </div>

    </div>
    <div class="row row-centered">
        <div class="col-sm-4 ">
            <div class="panel panel-default ">
                <div class="panel-heading center-text">
                    <h1 class="panel-title">Bio</h1>
                </div>
              <ul class="list-group">
                <li class="list-group-item padding-bio">
                  <cite title="Porto, Portugal"><i class="glyphicon glyphicon-map-marker">
                          </i>              Porto, Portugal</cite>
                </li>
               <li class="list-group-item padding-bio">
                    <i class="glyphicon glyphicon-envelope"></i>              gomes@example.com

                  <li class="list-group-item padding-bio">
                      <i class="glyphicon glyphicon-globe"></i>
                      <a href="http://www.jquery2dotnet.com">              www.jquery2dotnet.com</a> </li>
                  <li class="list-group-item padding-bio">
                    <i class="glyphicon glyphicon-gift"></i>              June 02, 1996</li>
              </ul>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li><a href="#">Questions</a></li>
                        <li><a href="#">Answers</a></li>
                    </ul>
                </div>

                <div class="list-group">
                    {$questions=[["id" => "1", "title" => "Network Problems", "author" => "Nuno Ramos", "date" => "20/02/2017", "rating" => "5"],
                    ["id" => "2", "title" => "Internet Problems", "author" => "Vasco Ribeiro", "date" => "19/02/2017", "rating" => "-2"]]}
                    {foreach $questions as $content}
                        {include file="question_overview.tpl"}
                    {/foreach}
                </div>
            </div>

        </div>
    </div>
    {include file="footer.tpl"}
