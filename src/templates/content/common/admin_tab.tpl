<div id = "banned-users-table" class="panel-body">

<h3>Banned Users</h3>
<hr class="divider">
<table class="table table-hover col-xs-12">
    <thead>
    <tr>
        <th>Username</th>
        <th>Banned Until</th>
        <th>Reason</th>
    </tr>
    </thead>

<tbody>

{foreach $users as $user}
    <div id ="banned-users">
        <tr id ="ban-user-tr-{$user['userId']}">
            <td><a href="#">{getUserNameById($user['userId'])}</a></td>
            <td>{$user['expires']}</td>
            <td>{$user['reason']}</td>
            <td><a id="unban-user-button"class="btn btn-primary btn-danger pull-right ban-user-button" onclick="unbanUser({$user['userId']})">Unban User</a></td>
        </tr>

{/foreach}

    </div>
</tbody>

</table>
{if $numResults !== 0}
    {$numPages = $numResults/$resultsPerPage}
    {include file="content/common/pagination.tpl"}
{/if}
</div>