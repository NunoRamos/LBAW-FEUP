{include file="header.tpl"}

<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="tab-content panel-body">
            <div class="tab-pane fade in active container-fluid" id="admin-user-search">
                <h4 class="col-xs-12 col-md-4 search-text-size">Search for a Banned User:</h4>
                <form action="">
                    <div class="input-group form-group">
                        <input type="text" name="search" class="form-control" placeholder="Search"/>
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i
                                    class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                </form>
                <table class="table table-hover col-xs-12">

                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Banned Until</th>
                        <th>Reason</th>
                    </tr>
                    </thead>

                    {$users_banned=[["id" => "1", "username" => "Benardo Belchior", "banned_until" => "20/02/2017", "ban_reason" => "Inappropriate comments"],
                    ["id" => "2", "username" => "João Gomes", "banned_until" => "19/02/2017", "ban_reason" => "Make commits to devel when he shouldn't"]]}
                    {foreach $users_banned as $user}
                        <tr>
                            <td><a href="#">{$user["username"]}</a></td>
                            <td>{$user["banned_until"]}</td>
                            <td>{$user["ban_reason"]}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{include file="footer.tpl"}