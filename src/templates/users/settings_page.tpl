{include file="common/header.tpl"}
{$canAcceptPendingTags = canAcceptPendingTags($USERID)}
{$canBanUsers = canBanUsers($USERID)}

<script src="{$BASE_URL}javascript/settings.js"></script>
<link rel="stylesheet" href="{$BASE_URL}lib/trumbowyg/ui/trumbowyg.min.css">


<script src="{$BASE_URL}javascript/clickable_div.js"></script>

<div class="container">
    <div class="row">
        <div class="col-md-3 panel-default">
            <div class="panel-heading">{$NAME}
                <button class="btn btn-default btn-xs pull-right" data-toggle="collapse"
                        data-target=".settings-collapse">
                    <span class="collapse in settings-collapse no-animation"><i
                                class="glyphicon glyphicon-resize-small"></i></span>
                    <span class="collapse settings-collapse"><i class="glyphicon glyphicon-resize-full"></i></span>
            </div>
            <div class="list-group nav collapse in settings-collapse" id="settings-tabs">
                <a href="#personal-details" class="list-group-item highlight selected" role="tab" data-toggle="tab">Personal
                    Details</a>
                <a href="#update-picture" class="list-group-item highlight" role="tab" data-toggle="tab">
                    Update Picture</a>
                <a href="#account-settings" class="list-group-item highlight" role="tab" data-toggle="tab">Account
                    Settings</a>
                {if $canAcceptPendingTags}
                    <a href="#moderation-area" class="list-group-item highlight" role="tab" data-toggle="tab"
                       onclick="changeTypeToPendingTags()">Moderation
                        Area</a>
                {/if}
                {if $canBanUsers}
                    <a href="#administration-area" class="list-group-item highlight" role="tab" data-toggle="tab"
                       onclick="changeTypeToBanUsers()">Administration
                        Area</a>
                {/if}
            </div>
        </div>

        <div class="col-md-9 tab-content">
            <input type="hidden" id="token" name="token" value="{$TOKEN}">

            <!-- Personal Details-->
            <div id="personal-details" class="panel panel-default tab-pane settings-tab active">
                <div class="panel-heading">Personal Details</div>
                <div class="panel-body">
                    <h3>Personal Information</h3>
                    <hr class="divider">
                    <form class="row" method="post"
                          action="../../actions/update_personal_info.php">
                        <input type="hidden" name="token" value="{$TOKEN}">

                        <div class="col-xs-12 col-sm-6 large-bottom-margin">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-user"></span>
                                <input id="name" class="form-control" value="{getUserNameById($USERID)}"
                                       name="name" title="Name" placeholder="John Doe" required/>
                            </div>
                        </div>

                        <div class=" col-xs-12 col-sm-6 large-bottom-margin">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-envelope"></span>
                                <input id="email" type="email" class="form-control"
                                       value="{getUserEmailById($USERID)}" name="email" title="Email"
                                       placeholder="john@doe.com" required/>
                            </div>
                        </div>

                        <div id="details-error-message" class="col-xs-12 col-sm-offset-6 col-sm-6">
                            {foreach $ERROR_MESSAGES['personal-details'] as $error_message}
                                <div class="alert alert-danger" role="alert">
                                    <span class="text-center">{$error_message}</span>
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                </div>
                            {/foreach}
                        </div>

                        <div class="col-xs-12 large-top-bottom-margin">
                            <label for="bio" class="large-text">Describe yourself</label>
                            <div class="form-control" id="bio" name="bio">{getUserBioById($USERID)}</div>
                        </div>

                        <div class="col-xs-12">
                            <input class="btn btn-default form-control" type="submit" value="Update Details"
                                   placeholder="Describe yourself">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Picture -->
            <div id="update-picture" class="panel panel-default tab-pane settings-tab">
                <div class="panel-heading">Update Picture</div>
                <div class="panel-body">
                    <h3>Change profile picture</h3>
                    <hr class="divider">
                    <form action="../../actions/upload_img.php" method="post" enctype="multipart/form-data"
                          class="form-horizontal row text-center">
                        <div class="form-group">
                            <img id="upload" class="img-circle"
                                 src="{$BASE_URL}images/{getUserPhotoById($USERID)}"
                                 style="max-width: 200px; max-height: 200px" alt="Image preview">
                        </div>
                        <div class="form-group">
                            <div id="btn-upload" class="btn btn-default" onclick="uploadImage()">Choose your
                                Image
                            </div>
                            <input type="file" name="fileToUpload" id="fileToUpload" class="form-group"
                                   onchange="previewFile()" style="display: none">
                            <input type="submit" class="btn btn-default" value="Save Image" name="submit">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Settings -->
            <div id="account-settings" class="panel panel-default tab-pane settings-tab">
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

                        <div class="form-group">
                            <div id="password-error-message" class="col-xs-12 col-sm-offset-3 col-sm-5">
                                {foreach $ERROR_MESSAGES['account-settings'] as $error_message}
                                    <div class="alert alert-danger" role="alert">
                                        <span class="text-center">{$error_message}</span>
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close"><span
                                                    aria-hidden="true">&times;</span></button>
                                    </div>
                                {/foreach}
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            {if $canAcceptPendingTags}
                <div id="moderation-area" class="panel panel-default tab-pane settings-tab">
                    <div id="title-moderator" class="panel-heading">Moderation Area</div>
                </div>
            {/if}
            {if $canBanUsers}
                <div id="administration-area" class="panel panel-default tab-pane settings-tab">
                    <div id="title-admin" class="panel-heading">Administration Area</div>

                </div>
            {/if}
        </div>
    </div>
</div>
<script src="{$BASE_URL}lib/trumbowyg/trumbowyg.min.js"></script>
<script src="{$BASE_URL}javascript/fileuploader.js"></script>
<script src="{$BASE_URL}javascript/clickable_div.js"></script>

{include file="common/footer.tpl"}
