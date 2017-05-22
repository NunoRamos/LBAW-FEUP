{assign "POSITIVE_VOTE_VALUE" "1"}
{assign "NEGATIVE_VOTE_VALUE" "-1"}
{if !isset($USERID)}
    {assign "userId" "0"}
{else}
    {assign "userId" $USERID}
{/if}
<div data-content-id="{$content["id"]}">
    <div class="text-center anchor clickable" onclick="vote({$userId},{$content["id"]}, {$POSITIVE_VOTE_VALUE})">
        <span class="glyphicon glyphicon-triangle-top {if $content["positive"] === TRUE}positive{/if}"
              aria-hidden="true"></span>
    </div>
    <div class="text-center rating" data-toggle="modal" data-target="#votes-{$content["id"]}"
         onclick="getUsersWhoVotedOnContent({$content["id"]})"><span>{$content["rating"]}</span></div>
    <div class="text-center anchor clickable" onclick="vote({$userId},{$content["id"]}, {$NEGATIVE_VOTE_VALUE})">
        <span class="glyphicon glyphicon-triangle-bottom {if $content["positive"] === FALSE}negative{/if}"
              aria-hidden="true"></span>
    </div>
</div>

<!-- Modal -->
<div class="modal fade vote-modal" id="votes-{$content["id"]}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title large-text col-xs-8">Votes</span>
                <button type="button" class="close col-xs-1" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="voters">
                <div class="loading">
                    <img src="{$BASE_URL}images/rolling.svg"/>
                </div>
                {foreach $users as $user}
                    {include file="content/common/user_vote_overview.tpl"}
                {/foreach}
            </div>
        </div>
    </div>
</div>

