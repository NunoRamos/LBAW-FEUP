<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reply Planet</title>
    <link rel="stylesheet" href="{$BASE_URL}css/bootstrap.min.css">
    <link rel="stylesheet" href="{$BASE_URL}css/custom.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="{$BASE_URL}javascript/header.js"></script>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="wrapper">
        <ul class="nav navbar-nav full-width">
            <li>
                <a class="navbar-brand" href="{$BASE_URL}index.php">Reply Planet</a>
            </li>
            {if $smarty.server.SCRIPT_NAME !== "/pages/content/search_results.php"}
                <li>
                    <form class="navbar-form navbar-collapse collapse"
                          method="get" action="{$BASE_URL}pages/content/search_results.php">
                        <div class="input-group">
                            <input id="header-search-bar" type="text" name="inputString"
                                   class="form-control full-width"
                                   placeholder="Search"/>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </li>
            {/if}
            {if $USERID}
                <li class="pull-right dropdown">
                    <img id="sign-in-image" class="dropdown-toggle img-circle navbar-btn align-right image-padding"
                         data-toggle="dropdown" src="{$BASE_URL}images/{getUserPhotoById($USERID)}" alt="User Image">
                    <ul class="dropdown-menu dropdown-responsive">

                        <li class="hidden-xs"><span>Signed in as</span></li>
                        <li class="hidden-xs"><span><strong>{$NAME}</strong></span></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="../users/profile_page.php">Profile</a></li>
                        {if $PRIVILEGELEVELID == 3}
                            <li><a href="../users/admin_page.php">Admin Page</a></li>
                        {/if}
                        {if $PRIVILEGELEVELID == 2}
                            <li><a href="../users/moderator_page.php">Moderator Page</a></li>
                        {/if}
                        <li role="separator" class="divider"></li>
                        <li><a href="../users/settings_page.php">Settings</a></li>
                        <li><a href="{$BASE_URL}actions/logout.php">Sign Out</a></li>
                    </ul>
                </li>
                <li id="notification-dropdown" class="pull-right dropdown">
                    <a id="notification-button" role="button" class="dropdown-toggle small-padding-xs"
                       data-toggle="dropdown">
                        <i class="glyphicon glyphicon-bell"></i>
                    </a>
                    <ul id="notification-menu" class="dropdown-menu dropdown-responsive notification-dropdown">
                        <li id="notification-header" class="dropdown-header">Notifications</li>
                        <li role="separator" class="divider"></li>
                    </ul>
                </li>
                <li class="pull-right">
                    <a role="button" class="small-padding-xs" href="../content/create_question.php">
                        <i class="glyphicon glyphicon-plus"></i>
                    </a>
                </li>
            {else}
                <li class="pull-right">
                    <button type="button" class="btn btn-default navbar-btn" data-toggle="modal"
                            data-target="#sign-in-modal">Sign In
                    </button>
                </li>
            {/if}
            <li class="pull-right visible-xs">
                <a role="button" class="small-padding-xs" href="../content/search_results.php">
                    <i class="glyphicon glyphicon-search"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Sign in/up modal -->
<div class="modal fade" id="sign-in-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bottom-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <ul class="nav nav-tabs nav-justified">
                    <li role="presentation" class="active"><a href="#sign-in" data-toggle="tab">Sign In</a></li>
                    <li role="presentation"><a id="sign-up-tab" href="#sign-up" data-toggle="tab">Sign Up</a></li>
                </ul>
            </div>
            <div class="modal-body">
                <div class="tab-content row">
                    <form id="sign-in" class="modal-form tab-pane fade in active col-xs-12"
                          method="post" action="{$BASE_URL}actions/sign_in.php">
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-user"></div>
                            <input type="text" class="form-control" name="email" placeholder="Email" required
                                   value="{$FORM_VALUES['sign-in']['email']}">
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-lock"></div>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        {foreach $ERROR_MESSAGES['sign-in'] as $error_message}
                            <div class="alert alert-danger" role="alert">
                                <span class="text-center">{$error_message}</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                            </div>
                        {/foreach}
                        <button type="submit" class="btn btn-default col-xs-12">Sign In</button>
                    </form>
                    <form id="sign-up" class="modal-form tab-pane fade col-xs-12"
                          method="post" action="{$BASE_URL}actions/sign_up.php" onsubmit="return validateSignUp()">
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-user"></div>
                            <input type="text" class="form-control" name="name" placeholder="Real Name" required
                                   value="{$FORM_VALUES['sign-up']['name']}">
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-envelope"></div>
                            <input type="email" class="form-control" name="email" placeholder="Email" required
                                   value="{$FORM_VALUES['sign-up']['email']}">
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-lock"></div>
                            <input id="password" type="password" class="form-control" name="password"
                                   placeholder="Password" required>
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-lock"></div>
                            <input id="repeat-password" type="password" class="form-control" name="repeat-password"
                                   placeholder="Repeat your password" required>
                        </div>
                        <div id="sign-up-errors">
                            {foreach $ERROR_MESSAGES['sign-up'] as $error_message}
                                <div class="alert alert-danger" role="alert">
                                    <span class="text-center">{$error_message}</span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                </div>
                            {/foreach}
                        </div>
                        <button type="submit" class="btn btn-default col-xs-12">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper container-fluid">
