<div data-content-id="{$content["id"]}" data-vote-positive="{if $content["positive"] === FALSE}0{elseif $content["positive"] === TRUE}1{else}-1{/if}" class="row no-gutter no-side-margin">
    <div class="col-xs-1">
        {include file="content/common/rating.tpl"}
    </div>
    <div class="col-xs-11 anchor clickable" href="../content/question_page.php?id={$content.id}">
        <div class="col-xs-12">
            <a class="small-text"
               href="../users/profile_page.php?id={$content["creatorId"]}"><span>{getUserNameById($content["creatorId"])}</span></a>
            <span class="small-text">{$content["creationDate"]}</span>
        </div>
        <span class="large-text col-xs-12">{$content["title"]}</span>
    </div>
</div>
