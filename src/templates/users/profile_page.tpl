{include file="../common/header.tpl"}
<div class="row col-xs-12 col-sm-12">
	<div class="col-xs-12 col-sm-3 pull-left">
		<img class="center-block img-responsive img-profile" src="{$BASE_URL}images/user-default.png" alt="User Image">
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<ul class="list-inline">
				<div class="col-xs-12 col-sm-4">
					<div class="col-xs-12 col-sm-6">
						<ul>
							<h5 class="text-center">Perguntas</h5>
							<h4  class="text-center strong">{getNumberUserQuestions($USERID)}</h4>
						</ul>
					</div>
					<div class="col-xs-12 col-sm-6">
						<ul>
							<h5 class="text-center">Respostas</h5>
							<h4  class="text-center strong">{getNumberUserReply($USERID)}</h4>
						</ul>
					</div>
				</div>
				{if $PRIVILEGELEVELID >= 2}
				<div class="pull-right">
					<a href="#" class="btn btn-primary btn-danger pull-right">Ban User</a>
				</div>
				{/if}
			</ul>
			<br>
			<br>
		</div>
	</div>
</div>
	
<div class="row">
    <div class="col-xs-12 col-sm-3">
        <div class="panel panel-default">
			<div class="well no-bottom-margin">
				<h2 class="center">{$NAME}</h2>
                <i class="glyphicon glyphicon-map-marker"> </i> Porto, Portugal<br>
                <i class="glyphicon glyphicon-envelope"></i> {$EMAIL}<br>
                <i class="glyphicon glyphicon-globe"></i> www.jquery2dotnet.com<br>
                <i class="glyphicon glyphicon-gift"></i> June 02, 1996
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
					<li class="active panel-title"><a data-toggle="tab" href="#questions">My Questions</a></li>
					<li><a data-toggle="tab" class="panel-title" href="#answers">Answered Questions</a></li>
				</ul>
            </div>
			<div class="tab-content">
            <div id="questions" class="tab-pane fade in active list-group">
                {$questions=getUserQuestions($USERID)}
                {foreach $questions as $content}
                    <div class="list-group-item anchor clickable" href="question_page.php">
                        {include file="../content/common/question_overview.tpl"}
                    </div>
                {/foreach}
            </div>
			<div id="answers" class="tab-pane fade list-group">
                {$questions=getUserQuestionAnswered($USERID)}
                {foreach $questions as $content}
                    <div class="list-group-item anchor clickable" href="question_page.php">
                        {include file="../content/common/question_overview.tpl"}
                    </div>
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
			{$tags=getAllTags()}
              {foreach $tags as $tag}
                <a href="../content/search_results.php?activeTags={$tag['name']}" class="list-group-item">{$tag['name']}</a>
            {/foreach}
        </div>
    </div>
    </div>
</div>

{include file="../common/footer.tpl"}
<script src="{$BASE_URL}javascript/clickable_div.js"></script>
