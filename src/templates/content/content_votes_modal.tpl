<div id="users" class="panel panel-default">
    {if sizeof($users) === 0}
        <div class="list-group-item text-center">No one voted</div>
    {else}
        {foreach $users as $user}
            {include file="users/common/user_vote_overview.tpl"}
        {/foreach}
    {/if}
</div>