{if $content["positive"] === TRUE}
    {$color = "positive-vote-color"}
    {$type = 1}
{else}
    {$color = "normal-vote-color"}
    {$type = 0}
{/if}
<div class="text-center anchor clickable" onclick="addVote({$USERID},{$type})">
    <span class="glyphicon glyphicon-triangle-top {$color}" aria-hidden="true"></span>
</div>
<div class="text-center"><span>{$content["rating"]}</span></div>
{if $content["positive"] === FALSE}
    {$color = "negative-vote-color"}
    {$type = -1}
{else}
    {$color = "normal-vote-color"}
    {$type = 0}
{/if}
<div class="text-center anchor clickable" onclick="addVote({$USERID},{$type})">
    <span class="glyphicon glyphicon-triangle-bottom {$color}" aria-hidden="true"></span>
</div>

