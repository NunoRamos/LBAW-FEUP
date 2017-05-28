{include file="common/header.tpl"}
{$canAcceptPendingTags = canAcceptPendingTags($USERID)}
{$canBanUsers = canBanUsers($USERID)}

<script src="{$BASE_URL}javascript/settings.js"></script>
<script src="{$BASE_URL}javascript/jquery.js"></script>
<script src="{$BASE_URL}javascript/fileuploader.js"></script>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <p class="lead">{$NAME}</p>
            <div class="list-group nav" id="edit-profile-nav">
                <a href="#personal-details" class="list-group-item">Personal Details</a>
                <a href="#account-settings" class="list-group-item">Account Settings</a>
                {if $canAcceptPendingTags}<a href="#moderator" class="list-group-item">Moderation Area</a>{/if}
                {if $canBanUsers}<a href="#admin" class="list-group-item">Administration Area</a>{/if}
            </div>
        </div>

        <div class="col-md-9">
            <input type="hidden" id="token" name="token" value="{$TOKEN}">

            <div id="personal-details" class="panel panel-default tab-content settings-tab ">
                <div class="panel-heading">Personal Details</div>
                <div class="panel-body">
                    <h3>Personal Details</h3>
                    <hr class="divider">
                    <form class="col-xs-12" method="post"
                          action="../../actions/update_personal_info.php">
                        <input type="hidden" name="token" value="{$TOKEN}">

                        <div class="form-group">
                            <div class="input-group col-xs-12 col-sm-5">
                                <div class="input-group-addon glyphicon glyphicon-user"></div>
                                <input id="name" class="form-control" value="{getUserNameById($USERID)}"
                                       name="name" title="Name" placeholder="John Doe" required/>
                            </div>

                            <div class="input-group col-xs-12 col-sm-5">
                                <div class="input-group-addon glyphicon glyphicon-envelope"></div>
                                <input id="email" type="email" class="form-control"
                                       value="{getUserEmailById($USERID)}" name="email" title="Email"
                                       placeholder="john@doe.com" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="bio" class="col-xs-12">Bio</label>
                            <div class="col-xs-12">
                                <input id="bio" class="form-control col-xs-12" value="{getUserBioById($USERID)}"
                                       name="bio"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="btn btn-default form-control" type="submit" value="Update Details">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-body">
                    <h3>Change profile picture</h3>
                    <hr class="divider">
                    <div class="row  col-sm-12">
                        <div class="form-horizontal col-sm-offset-4">
                            <form action="../../actions/upload_img.php" method="post" enctype="multipart/form-data">
                                <img id="upload" class="img-circle form-group col-sm-offset-2"
                                     src="{$BASE_URL}images/user-default.png" height="200" width="200"
                                     alt="Image preview">
                                <div class="row form-groupcol-sm-offset-4">
                                    <div class="col-sm-4">
                                        <div id="btn-upload" class="btn btn-default" onclick="uploadImage()">Choose your
                                            Image
                                        </div>
                                        <input type="file" name="fileToUpload" id="fileToUpload" class="form-group"
                                               onchange="previewFile()" style="display: none">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="submit" class="btn btn-default" value="Save Image" name="submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div id="account-settings" class="panel panel-default tab-content settings-tab ">
                <div class="panel-heading">Account Settings</div>
                <div class="panel-body">
                    <h3>Change Password</h3>
                    <hr class="divider">
                    <form class="form-horizontal center-block" method="post" action="../../actions/change_password.php"
                          onsubmit="return validatePassword()">

                        <input type="hidden" name="token" value="{$TOKEN}">
                        <div class="form-group">
                            <label for="curr-password" class="control-label col-xs-12 col-sm-3">Current Password</label>
                            <div class="col-xs-12 col-sm-5">
                                <input id="curr-password" class="form-control" type="password"
                                       placeholder="Current Password" name="curr-password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new-password" class="control-label col-xs-12 col-sm-3">New Password</label>
                            <div class="col-xs-12 col-sm-5">
                                <input id="new-password" class="form-control" type="password" placeholder="New Password"
                                       name="new-password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new-repeat-password" class="control-label col-xs-12 col-sm-3">Repeat
                                Password</label>
                            <div class="col-xs-12 col-sm-5">
                                <input id="new-repeat-password" class="form-control" type="password"
                                       placeholder="Repeat Password" name="new-repeat-password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-offset-3 col-sm-5">
                                <input class="btn btn-default form-control" type="submit" value="Change Password">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {if $canAcceptPendingTags}
                <div id='moderator' class="panel panel-default tab-content settings-tab ">
                    <div class="panel-heading">Moderation Area</div>
                    <div class="panel-body">
                        <h3>Pending Tags</h3>
                        <hr class="divider">
                        <div class="row">
                            <div class="panel-body row">
                                {foreach getAllPendingTags() as $tag}
                                    {include file="content/common/tag_choice.tpl"}
                                {/foreach}
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
            {if $canBanUsers}
                <div id='admin' class="panel panel-default tab-content settings-tab ">
                    <div class="panel-heading">Administration Area</div>
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
                            {foreach getAllBannedUsers() as $user}
                                <tr id="ban-user-tr-{$user['userId']}">
                                    <td><a href="#">{getUserNameById($user['userId'])}</a></td>
                                    <td>{$user['expires']}</td>
                                    <td>{$user['reason']}</td>
                                    <td><a id="unban-user-button"
                                           class="btn btn-primary btn-danger pull-right ban-user-button"
                                           onclick="unbanUser({$user['userId']})">Unban User</a></td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            {/if}
        </div>
    </div>
</div>
{include file="common/footer.tpl"}
