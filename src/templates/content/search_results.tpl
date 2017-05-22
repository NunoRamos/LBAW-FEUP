<div class="panel panel-default">
    {if $numResults === 0}
        <div class="list-group-item text-center">No results found</div>
    {else}
        {if isset($users)}
            {foreach $users as $user}
                {include file="content/common/user_vote_overview.tpl"}
            {/foreach}
        {else}
            {foreach $questions as $content}
                {include file="content/common/question_overview.tpl"}
            {/foreach}
        {/if}
    {/if}
</div>

{if $numResults !== 0}
    {$numPages = $numResults/$resultsPerPage}
    {include file="content/common/pagination.tpl"}
{/if}
