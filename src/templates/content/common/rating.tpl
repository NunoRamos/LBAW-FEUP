
<div class="text-center anchor clickable positive" onclick="addPositiveVote({$USERID},{$content["id"]})">
    <span class="glyphicon glyphicon-triangle-top {if $content["positive"] === TRUE}positive-vote{/if}" aria-hidden="true"></span>
</div>
<div class="text-center"><span>{$content["rating"]}</span></div>

<div class="text-center anchor clickable negative" onclick="addNegativeVote({$USERID},{$content["id"]})">
    <span class="glyphicon glyphicon-triangle-bottom {if $content["positive"] === FALSE}negative-vote{/if}" aria-hidden="true"></span>
</div>

