{include file="common/header.tpl"}

<script src="{$BASE_URL}javascript/settings.js"></script>

<div class="container">

    <div class="row">

        <div class="col-md-3">
            <p class="lead">Bernado Belchior</p>
            <div class="list-group nav">
                <a href="#settings" class="list-group-item">Settings</a>
                <a href="#example" class="list-group-item">Exemplo 1</a>
                <a href="#" class="list-group-item">Exemplo 2</a>
            </div>
        </div>

        <div class="col-md-9">

                <div id='settings' class="panel panel-default tab-content settings-tab">
                    <div class="panel-heading">Settings</div>
                    <div class="panel-body">
                        <h3>Personal Details</h3>
                        <hr class="divider">

                        <div class="row">
                            <form class="form-horizontal col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="control-label col-xs-12 col-sm-3">Name</label>
                                    <div class="col-xs-12 col-sm-9">
                                        <input id="name" class="form-control" value="Bernardo Belchior"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="control-label col-xs-12 col-sm-3">Email</label>
                                    <div class="col-xs-12 col-sm-9">
                                        <input id="email" type="email" class="form-control" value="up201405381@fe.up.pt"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-offset-3 col-sm-9">
                                        <input class="btn btn-default form-control" type="submit" value="Update Details">
                                    </div>
                                </div>
                            </form>

                            <div class="col-sm-6">
                                <img class="hidden-xs img-responsive img-rounded col-xs-6 col-xs-offset-3 well well-sm"
                                     src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Linus_Torvalds_(cropped).jpg"
                                     alt="Profile picture"/>
                            </div>
                        </div>

                        <h3>Change Password</h3>
                        <hr class="divider">
                        <form class="form-horizontal center-block">
                            <div class="form-group">
                                <label for="curr-password" class="control-label col-xs-12 col-sm-2">Current Password</label>
                                <div class="col-xs-12 col-sm-4">
                                    <input id="curr-password" class="form-control" type="password" placeholder="Current Password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="new-password" class="control-label col-xs-12 col-sm-2">New Password</label>
                                <div class="col-xs-12 col-sm-4">
                                    <input id="new-password" class="form-control" type="password" placeholder="New Password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="repeat-password" class="control-label col-xs-12 col-sm-2">Repeat Password</label>
                                <div class="col-xs-12 col-sm-4">
                                    <input id="repeat-password" class="form-control" type="password"
                                           placeholder="Repeat Password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12 col-sm-offset-2 col-sm-4">
                                    <input class="btn btn-default form-control" type="submit" value="Change Password">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id='example' class="panel panel-default tab-content settings-tab">
                    <p>Pintated</p>
                </div>
        </div>
    </div>
</div>

{include file="common/footer.tpl"}
