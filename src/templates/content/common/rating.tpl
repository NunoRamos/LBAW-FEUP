<div data-content-id="{$content["id"]}" data-vote-positive="{if $content["positive"] === FALSE}0{elseif $content["positive"] === TRUE}1{else}-1{/if}">
    <div class="text-center anchor clickable positive" onclick="addPositiveVote({$USERID},{$content["id"]})">
        <span class="glyphicon glyphicon-triangle-top {if $content["positive"] === TRUE}positive-vote{/if}" aria-hidden="true"></span>
    </div>
    <div class="text-center rating"><span>{$content["rating"]}</span></div>

    <div class="text-center anchor clickable negative" onclick="addNegativeVote({$USERID},{$content["id"]})">
        <span class="glyphicon glyphicon-triangle-bottom {if $content["positive"] === FALSE}negative-vote{/if}" aria-hidden="true"></span>

    </div>
</div>

