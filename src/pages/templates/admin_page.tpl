{include file="header.tpl"}

<div class="col-xs-12 col-sm-12 col-md-10">
    <div class="panel panel-default">
        <div class="panel-heading">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#admin-user-search">Users</a></li>
                <li><a data-toggle="tab" href="#admin-tags-management">Tags</a></li>
            </ul>
        </div>
        <div class="tab-content panel-body">
            <div class="tab-pane fade in active" id="admin-user-search">
                <h4 class="">Search for a User</h4>
                <form action="">
                    <div class="input-group form-group">
                        <input type="text" name="search" class="form-control" placeholder="Search"/>
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i
                                    class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="admin-tags-management">
                <h3>We use the class nav-pills instead of nav-tabs which automatically creates a background color for the tab</h3>
            </div>
        </div>
    </div>
</div>

{include file="footer.tpl"}