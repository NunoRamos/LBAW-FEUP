{include file="common/header.tpl"}

<script src="{$BASE_URL}javascript/settings.js"></script>
<script src="{$BASE_URL}javascript/jquery.js"></script>
<script src="{$BASE_URL}javascript/fileuploader.js"></script>

<div class="container">

    <div class="row">

        <div class="col-md-3">
            <p class="lead">{$NAME}</p>
            <div class="list-group nav " id ="edit-profile-nav">
                <a href="#edit-personal-info" class="list-group-item">Edit Personal Info</a>
                <a href="#settings" class="list-group-item">Settings</a>
                <a href="#moderator" class="list-group-item">Moderator Settings</a>
                <a href="#admin" class="list-group-item">Admin Settings</a>
            </div>
        </div>

        <div class="col-md-9">

                <div id='edit-personal-info' class="panel panel-default tab-content settings-tab ">
                    <div class="panel-heading">Edit Personal Info</div>
                    <div class="panel-body">
                        <h3>Personal Details</h3>
                        <hr class="divider">
                        <div class="row col-sm-offset-2 col-sm-10">
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
                        </div>
                    </div>
                    <div class="panel-body ">
                        <h3>Change profile picture</h3>
                        <hr class="divider">
                        <div class="row  col-sm-12">
                            <div class ="form-horizontal col-sm-offset-4">
                                <form action="../../actions/upload_img.php"  method="post" enctype="multipart/form-data">
                                    <img id = "upload" class="img-circle form-group col-sm-offset-2" src="{$BASE_URL}images/user-default.png" height="200" width="200" alt="Image preview">
                                    <div class="row form-groupcol-sm-offset-4">
                                    <div class="col-sm-4">
                                        <div id ="btn-upload" class="btn btn-default"  onclick="uploadImage()">Choose your Image</div>
                                        <input type="file" name="fileToUpload" id="fileToUpload" class="form-group" onchange="previewFile()" style="display: none">
                                    </div>
                                        <div class="col-sm-3">
                                            <input type="submit" class= "btn btn-default" value="Save Image" name="submit">
                                        </div>
                                    </div>
                                </form>
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
                        {if $ERROR_PASSWORD == '-1'}
                            <div class="form-group">
                                <div id="new-password-failed" class="alert alert-danger text-center col-xs-12 col-sm-offset-2 col-sm-4" role="alert"> Current and new password are the same!
                                </div>
                            </div>
                         {else}
                         <div class="form-group">
                            <div id="new-password-failed" class="alert alert-danger text-center col-xs-12 col-sm-offset-2 col-sm-4" role="alert"
                                 style="display:none;">
                            </div>
                        </div>
                        {/if}
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-offset-2 col-sm-4">
                                <input class="btn btn-default form-control" type="submit" value="Change Password">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div id='moderator' class="panel panel-default tab-content settings-tab ">
                <div class="panel-heading">Moderator Settings</div>
                <div class="panel-body">
                    <h3>Pending Tags</h3>
                    <hr class="divider">
                    <div class="row">
                        <div class="panel-body row">
                            {$pendingTags = getAllPendingTags()}
                            {foreach $pendingTags as $tag}
                                {include file="content/common/tag_choice.tpl"}
                            {/foreach}
                        </div>

                    </div>

            </div>
            </div>
            <div id='admin' class="panel panel-default tab-content settings-tab ">
                <div class="panel-heading">Admin Settings</div>
                <div class="panel-body">
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
                        {$users_banned=getAllBannedUsers()}

                        {foreach $users_banned as $user}
                            <div >
                                <tr id ="ban-user-tr-{$user['userId']}">
                                <td><a href="#">{getUserNameById($user['userId'])}</a></td>
                                <td>{$user['expires']}</td>
                                <td>{$user['reason']}</td>
                                <td><a id="unban-user-button"class="btn btn-primary btn-danger pull-right ban-user-button" onclick="unbanUser({$user['userId']})">Unban User</a></td>
                            </tr>
                            </div>
                        {/foreach}
                        </tbody>
                    </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

{include file="common/footer.tpl"}
