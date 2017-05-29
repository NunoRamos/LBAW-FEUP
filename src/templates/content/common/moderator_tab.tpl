<div class="panel-body">
    <h3>Pending Tags</h3>
    <hr class="divider">
    <div class="row">
        <div class="panel-body row">
            {foreach $tags as $tag}
                {include file="content/common/tag_choice.tpl"}
            {/foreach}
        </div>
    </div>
</div>

</table>
{if $numResults !== 0}
    {$numPages = $numResults/$resultsPerPage}
    {include file="content/common/pagination.tpl"}
{/if}
</div>