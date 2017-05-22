{if !isset($USERID)}
    {assign "userId" "0"}
{else}
    {assign "userId" $USERID}
{/if}
<div data-content-id="{$content["id"]}"
     data-vote-positive="{if $content["positive"] === FALSE}0{elseif $content["positive"] === TRUE}1{else}-1{/if}">
    <div class="text-center anchor clickable positive" onclick="addPositiveVote({$userId},{$content["id"]})">
        <span class="glyphicon glyphicon-triangle-top {if $content["positive"] === TRUE}positive-vote{/if}"
              aria-hidden="true"></span>
    </div>
    <div class="text-center rating" data-toggle="modal" data-target="#users-votes"
         onclick="getUsersWhoVotedOnContent({$content["id"]})"><span>{$content["rating"]}</span></div>
    <div class="text-center anchor clickable negative" onclick="addNegativeVote({$userId},{$content["id"]})">
        <span class="glyphicon glyphicon-triangle-bottom {if $content["positive"] === FALSE}negative-vote{/if}"
              aria-hidden="true"></span>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="users-votes" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title large-text col-xs-8">Votes</span>
                <button type="button" class="close col-xs-1" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="loading">
                    <img src="{$BASE_URL}images/rolling.svg"/>
                </div>
                {foreach $users as $user}
                    {include file="content/common/user_overview.tpl"}
                {/foreach}
            </div>
        </div>
    </div>
</div>

