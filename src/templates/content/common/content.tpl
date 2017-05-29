<div data-content-id="{$content.id}" class="list-group small-bottom-margin">
    <div class="list-group-item row no-gutter no-side-margin">
        <div class="col-xs-1">
            {include file="content/common/rating.tpl"}
        </div>
        <div class="col-xs-11 no-gutter">
            <div class="col-xs-10 no-gutter">
                <div class="col-xs-12 text-left">
                    <a class="small-text"
                       href="../users/profile_page.php?id={$content["creatorId"]}">{getUserNameById($content.creatorId)}</a>
                    <span class="small-text">{$content["creationDate"]}</span>
                </div>
                <div class="content-text text-wrap">
                    {if $content.deleted}
                        [deleted]
                    {else}
                        {$content["text"]}
                    {/if}
                </div>
            </div>
            <div class="col-xs-2 text-align-right no-gutter btn-toolbar">
                {assign "canDeleteContent" canDeleteContent($USERID, $content.id)}
                {assign "canEditContent" canEditContent($USERID, $content.id)}
                {assign "canReply" canReply($USERID, $content.id, $content.questionId)}
                {assign "canFollowContent" canFollowContent($USERID, $content.id)}
                {assign "followsContent" followsContent($USERID, $content.id)}
                {if $canDeleteContent || $canEditContent || $canReply || $canFollowContent}
                    <span class="dropdown-toggle glyphicon glyphicon-chevron-down pull-right"
                          data-toggle="dropdown"></span>
                    <ul id="edit-options" class="dropdown-menu dropdown-responsive">
                        {if $canDeleteContent}
                            <li>
                                <form action="{$BASE_URL}actions/delete_content.php" method="post">
                                    <input type="hidden" value="{$content.id}" name="content-id">
                                    <input id="delete-content-input" type="submit" value="Delete">
                                </form>
                            </li>
                        {/if}
                        {if $canEditContent}
                            <li>
                                <span data-content-id="{$content.id}" onclick="toggleTextBox(this,1)">Edit</span>
                            </li>
                        {/if}
                        {if $canReply}
                            <li>
                                <span data-content-id="{$content.id}" onclick="toggleTextBox(this,0)">Comment</span>
                            </li>
                        {/if}
                        {if $canFollowContent}
                            {if $followsContent}
                                {assign "text" "Unfollow"}
                            {else}
                                {assign "text" "Follow"}
                            {/if}
                            <li>
                                <span onclick="{if $followsContent}unfollowContent(this, {$content.id}){else}followContent(this, {$content.id}){/if}"
                                      data-content-id="{$content.id}">{$text}</span>
                            </li>
                        {/if}
                    </ul>
                {/if}
            </div>
        </div>
    </div>
    <div class="reply-text-box"></div>
    <div class="reply-indentation reply-top-margin">
        {foreach $content['children'] as $content}
            {include file="content/common/content.tpl"}
        {/foreach}
    </div>
</div>
