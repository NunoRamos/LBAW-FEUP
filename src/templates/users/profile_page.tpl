{include file="../common/header.tpl"}

	
<div class="row">
    <div class="col-xs-12 col-sm-3 style="padding:0px">
        <div class="panel panel-default">
			<img class="center-block img-responsive img-profile" src="{$BASE_URL}images/user-default.png" alt="User Image">
		</div>
		<div class="panel panel-default">
			{if $USERID}
			{if $PRIVILEGELEVELID = 3}
			<button type="button" class="btn btn-primary btn-danger pull-right" data-toggle="modal"
                            data-target="#ban-user-modal">Ban User
                    	</button>
			{/if}
			{/if}
			<div class="well no-bottom-margin">
				<h2 class="center">{$user['name']}</h2>
                <i class="glyphicon glyphicon-envelope"></i> {$user['email']}<br>
                <i class="glyphicon glyphicon-paperclip"></i> {$user['bio']}<br>
                <i class="glyphicon glyphicon-time"></i> {$user['signupDate']}
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
					<li class="active panel-title"><a data-toggle="tab" href="#questions">Questions ({$numberQuestions})</a></li>
					<li><a data-toggle="tab" class="panel-title" href="#answers">Answered Questions ({$numberQuestionsAnswered})</a></li>
				</ul>
            </div>
			<div class="tab-content">
            <div id="questions" class="tab-pane fade in active list-group">
                {foreach $questions as $content}
                    {include file="content/common/question_overview.tpl"}
                {/foreach}
            </div>
			<div id="answers" class="tab-pane fade list-group">
                {foreach $questionsAnswered as $content}
                    {include file="content/common/question_overview.tpl"}
                {/foreach}
            </div>
			</div>
        </div>
    </div>
	<div class="col-xs-12 col-sm-3">
        <div class="panel panel-default">
        <div class="panel-heading">
            <h1 class="panel-title">Tags</h1>
        </div>
        <div class="panel-body list-group">
              {foreach $tags as $tag}
                <a href="../content/search_results.php?activeTags={$tag['name']}" class="list-group-item">{$tag['name']}</a>
            {/foreach}
        </div>
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
                          method="post" action="{$BASE_URL}actions/sign-in.php">
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
                            <input type="text" class="form-control" name="reason" placeholder="Ban Reason" required
                                   value="{$FORM_VALUES['ban-user']['reason']}">
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
