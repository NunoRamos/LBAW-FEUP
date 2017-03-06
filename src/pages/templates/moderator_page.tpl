{include file="header.tpl"}

<div class="col-xs-12 full-screen-xs">
    <div class="panel panel-default">
        <div class="panel-heading">
            Suggested Tags
        </div>
        <div class="panel-body row">
            {$tags=["C++", "Java", "Typescript", "Gardening", "Cooking", "Scala"]}
            {foreach $tags as $tag}
                {include file="tag_choice.tpl"}
            {/foreach}
        </div>
    </div>
</div>

{include file="footer.tpl"}