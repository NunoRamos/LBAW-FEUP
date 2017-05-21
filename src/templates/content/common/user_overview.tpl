<div class="list-group-item">
    <div class="row no-gutter no-side-margin">
        <div class="col-xs-3">
            <img class="center-block img-circle img-responsive img-user-search" src="{if isset($user["photo"])}user["photo"]{else}/images/user-default.png{/if}">
        </div>
        <div class="col-xs-9 anchor clickable user-text" href="../users/profile_page.php?id={$user['id']}">
            <span class="large-text col-xs-12">{$user['name']}</span>
            <span class="small-text col-xs-12">{$user['email']}</span>
            {if isset($user['positive'])}
                {if $user['positive'] === TRUE}
                    <span class="small-text positive-vote col-xs-12">Up</span>
                {else}
                    <span class="small-text negative-vote col-xs-12">Down</span>
                {/if}
            {/if}
        </div>
    </div>
</div>
