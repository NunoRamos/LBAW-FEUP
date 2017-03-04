{include file="header.tpl"}

<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Notifications</h4>
    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#unread">Unread <span class="badge">3</span></a></li>
            <li><a data-toggle="tab" href="#all">All <span class="badge">6</span></a></li>
        </ul>

        <div class="tab-content">
            <div id="unread" class="tab-pane fade in active">
                <div class="list-group">
                    <a href="#" class="list-group-item">First item</a>
                    <a href="#" class="list-group-item">Second item</a>
                    <a href="#" class="list-group-item">Third item</a>
                </div>
            </div>
            <div id="all" class="tab-pane fade">
                <div class="list-group">
                    <a href="#" class="list-group-item">First item</a>
                    <a href="#" class="list-group-item">Second item</a>
                    <a href="#" class="list-group-item">Third item</a>
                    <a href="#" class="list-group-item">Fourth item</a>
                    <a href="#" class="list-group-item">Fifth item</a>
                    <a href="#" class="list-group-item">Sixth</a>
                </div>
            </div>

        </div>
    </div>
</div>

{include file="footer.tpl"}
