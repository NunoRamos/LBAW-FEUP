{include file="../common/header.tpl"}



<!--<div class="col-xs-12 col-sm-3 full-screen-xs">
        <div class="panel panel-default">
            <img class="center-block img-responsive img-profile" src="{$BASE_URL}images/user-default.png" alt="User Image">
        </div>
        <div class="panel panel-default">
            <!--  {if $USERID}
                {if $PRIVILEGELEVELID = 3}
                    <button type="button" class="btn btn-primary btn-danger pull-right" data-toggle="modal"
                            data-target="#ban-user-modal">Ban User
                    </button>
                    <form action="{$BASE_URL}actions/become_moderator.php" >

                        <input type="submit" class="btn btn-primary btn-danger pull-right"
                               id="#button-become-Moderator" value="Become Admin">

                    </form>
                    <form action="{$BASE_URL}actions/become_admin.php" >

                        <input type="submit" class="btn btn-primary btn-danger pull-right"
                               id="#button-become-admin" value="Become Admin">

                    </form>
                {/if}
            {/if}

            <div class="well no-bottom-margin">
                <h2 class="center">{$user['name']}</h2>
                <h4 class="center">Score: {$rating}</h4>
                <i class="glyphicon glyphicon-envelope"></i> {$user['email']}<br>
                <i class="glyphicon glyphicon-paperclip"></i> {$user['bio']}<br>
                <i class="glyphicon glyphicon-time"></i> {$user['signupDate']}
            </div>
        </div>
    </div>-->
<div class="container col-sm-3 col-xs-12 full-screen-xs">
    <div class="panel panel-default">
        <div class="panel-heading panel-style">
            <h3 class="panel-title">Nuno Ramos</h3>
        </div>
        <img class="center-block img-responsive img-profile"
             src="{$BASE_URL}images/user-default.png" alt="User Image"><!-- src="{$BASE_URL}{if isset($user["photo"]) && !is_null($user["photo"])}images/{$user["photo"]}{else}images/user-default.png{/if}" -->
        <div class="panel-body">
            <div class="row some-margin" title="Email">
                <span class="glyphicon glyphicon-envelope col-xs-2"></span>
                <span class="col-xs-10">{$user['email']}</span>
            </div>
            <div class="row some-margin" title="Bio">
                <span class="glyphicon glyphicon-paperclip col-xs-2"></span>
                <span class="col-xs-10">{$user['bio']}</span>
            </div>
            <div class="row some-margin" title="Creation Date">
                <span class="glyphicon glyphicon-time col-xs-2"></span>
                <span class="col-xs-10">{$user['signupDate']}</span>
            </div>
            <div class="row some-margin" title="Score">
                <span class="glyphicon glyphicon-heart-empty col-xs-2"></span>
                <span class="col-xs-10">{{$rating}}</span>
            </div>
        </div>
    </div>
</div>

<div class="container col-sm-8 col-xs-12 full-screen-xs">
    <div class="panel panel-default">
        <div class="panel-heading panel-style">
            <h3 class="panel-title">Questions ({$numberQuestions})</h3>
        </div>
        <div class="remove-panel-padding panel-body">
            {if sizeof($questions) == 0}
                <p class="list-group-item">No questions created.</p>
            {else}
                {foreach $questions as $content}
                    {include file="content/common/question_overview.tpl"}
                {/foreach}
            {/if}
        </div>
    </div>
</div>

<div class="container col-sm-8 col-sm-offset-3 col-xs-12 full-screen-xs">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Answered Questions ({$numberQuestionsAnswered})</h3>
        </div>
        <div class="remove-panel-padding panel-body">
            {if sizeof($questionsAnswered) == 0}
                <p class="list-group-item">No questions answered.</p>
            {else}
                {foreach $questionsAnswered as $content}
                    {include file="content/common/question_overview.tpl"}
                {/foreach}
            {/if}
        </div>
    </div>
</div>

<div class="modal fade" id="ban-user-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bottom-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <ul class="nav nav-tabs nav-justified">
                    <li role="presentation" class="active"><a href="#ban-user" data-toggle="tab">Ban User</a></li>
                </ul>
            </div>
            <div class="modal-body">
                <div class="tab-content row">
                    <form id="ban-user" class="modal-form tab-pane fade in active col-xs-12"
                          method="post" action="{$BASE_URL}actions/ban_user.php">
                        <input type="hidden" class="form-control" name="id" value="15" />
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-thumbs-down"></div>
                            <input type="text" class="form-control" name="explanation" placeholder="Explanation"
                                   value="{$FORM_VALUES['ban-user']['explanation']}">
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-time"></div>
                            <input type="date" class="form-control" name="expires" placeholder="Ban Expires Date" required
                                   value="{$FORM_VALUES['ban-user']['expires']}">
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-ban-circle"></div>
                            <select class="form-control" name="reason">
                                <option value="bad_language">Bad Language</option>
                                <option value="inappropriate_content">Inappropriate Content</option>
                                <option value="spam">Spam</option>
                                <option value="disrespect_against_others">Disrespect Against Others</option>
                            </select>
                        </div>
                        {foreach $ERROR_MESSAGES['ban-user'] as $error_message}
                            <div class="alert alert-danger" role="alert">
                                <span class="text-center">{$error_message}</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                            </div>
                        {/foreach}
                        <button type="submit" class="btn btn-default btn-danger col-xs-12">Ban User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


{include file="../common/footer.tpl"}
<script src="{$BASE_URL}javascript/clickable_div.js"></script>
