{include file="common/header.tpl"}
<script src="{$BASE_URL}javascript/notifications_page.js"></script>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4>All Notifications</h4>
    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#unread">Unread <span class="badge">{getNumberOfUnreadNotifications($USERID)}</span></a></li>
            <li><a data-toggle="tab" href="#all">All <span class="badge">{getNumberOfReadNotifications($USERID)}</span></a></li>
        </ul>

        <div class="tab-content">
            <div id="unread" class="tab-pane fade in active">
                <div id="notification-unread" class="list-group">

                </div>
            </div>
            <div id="all" class="tab-pane fade">
                <div id="notification-read" class="list-group">

                </div>
            </div>

        </div>
    </div>
</div>

{include file="common/footer.tpl"}
