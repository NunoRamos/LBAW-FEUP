{include file="common/header.tpl"}

<script src="{$BASE_URL}javascript/settings.js"></script>

<div class="container">

    <div class="row">

        <div class="col-md-3">
            <p class="lead">{$NAME}</p>
            <div class="list-group nav " id ="edit-profile-nav">
                <a href="#edit-personal-info" class="list-group-item">Edit Personal Info</a>
                <a href="#settings" class="list-group-item">Settings</a>
                <a href="#ola" class="list-group-item">Exemplo 2</a>
            </div>
        </div>

        <div class="col-md-9">

                <div id='edit-personal-info' class="panel panel-default tab-content settings-tab ">
                    <div class="panel-heading">Edit Personal Info</div>
                    <div class="panel-body">
                        <h3>Personal Details</h3>
                        <hr class="divider">
                        <div class="row">
                            <form class="form-horizontal col-xs-12 col-sm-6" method="post" action="../../actions/update_personal_info.php">
                                <div class="form-group">
                                    <label for="name" class="control-label col-xs-12 col-sm-3">Name</label>
                                    <div class="col-xs-12 col-sm-9">
                                        <input id="name" class="form-control" value="{getUserNameById($USERID)}" name="name"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="control-label col-xs-12 col-sm-3">Email</label>
                                    <div class="col-xs-12 col-sm-9">
                                        <input id="email" type="email" class="form-control" value="{getUserEmailById($USERID)}" name ="email"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="bio" class="control-label col-xs-12 col-sm-3">Bio</label>
                                    <div class="col-xs-12 col-sm-9">
                                        <input id="bio" class="form-control" value="{getUserBioById($USERID)}" name = "bio"/>
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
                    </div>
                </div>
            <div id='settings' class="panel panel-default tab-content settings-tab ">
                <div class="panel-heading">Settings</div>
                <div class="panel-body">
                    <h3>Change Password</h3>
                    <hr class="divider">
                    <form class="form-horizontal center-block" method="post" action="../../actions/change_password.php" onsubmit="return validatePassword()">
                        <div class="form-group">
                            <label for="curr-password" class="control-label col-xs-12 col-sm-2">Current Password</label>
                            <div class="col-xs-12 col-sm-4">
                                <input id="curr-password" class="form-control" type="password" placeholder="Current Password" name = "curr-password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new-password" class="control-label col-xs-12 col-sm-2">New Password</label>
                            <div class="col-xs-12 col-sm-4">
                                <input id="new-password" class="form-control" type="password" placeholder="New Password" name = "new-password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new-repeat-password" class="control-label col-xs-12 col-sm-2">Repeat Password</label>
                            <div class="col-xs-12 col-sm-4">
                                <input id="new-repeat-password" class="form-control" type="password"
                                       placeholder="Repeat Password" name = "new-repeat-password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="new-password-failed" class="alert alert-danger text-center col-xs-12 col-sm-offset-2 col-sm-4" role="alert"
                                 style="display:none;">
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
        </div>
    </div>
</div>

{include file="common/footer.tpl"}
