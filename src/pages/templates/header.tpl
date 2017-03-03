<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reply Planet</title>
    <link rel="stylesheet" href="../../stylesheets/bootstrap.min.css">
    <link rel="stylesheet" href="../../stylesheets/custom.min.css">
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="wrapper">
        <ul class="nav navbar-nav full-width">
            <li>
                <a class="navbar-brand" href="../index.php">Reply Planet</a>
            </li>
            {if $smarty.server.SCRIPT_NAME !== "/pages/search_results.php"}
                <li>
                    <form class="navbar-form navbar-collapse collapse" action="search_results.php">
                        <div class="input-group">
                            <input type="text" name="search"
                                   class="form-control full-width"
                                   placeholder="Search"/>
                            <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i
                                    class="glyphicon glyphicon-search"></i></button>
                    </span>
                        </div>
                    </form>
                </li>
            {/if}
            {$logged_in=true}
            {if $logged_in}
                <li class="pull-right dropdown">
                    <img id="sign-in-image" class="dropdown-toggle img-circle navbar-btn align-right image-padding"
                         data-toggle="dropdown" src="../img/user-default.png" alt="User Image">
                    <ul class="dropdown-menu dropdown-responsive">

                        <li class="hidden-xs"><span>Signed in as</span></li>
                        <li class="hidden-xs"><span><strong>Nuno Ramos</strong></span></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="profile_page.php">Profile</a></li>
                        <li><a href="admin_page.php">Admin Page</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="settings_page.php">Settings</a></li>
                        <li><a href="#">Sign Out</a></li>
                    </ul>
                </li>
                <li class="pull-right dropdown">
                    <a id="dLabel" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-bell"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-responsive notification-dropdown">
                        <li class="dropdown-header">Notifications</li>
                        <li role="separator" class="divider"></li>
                        <li><a href="notifications_page.php"><span>Dave Lister commented on DWARF-13 - Maintenance</span></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="notifications_page.php"><span>Nuno Ramos liked your comment on DWARF-13 - Maintenance</span></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="notifications_page.php"><span>Dave Lister liked DWARF-13 - Maintenance</span></a></li>
                    </ul>
                </li>
                <li class="pull-right">
                    <a role="button" href="create_question.php">
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
                    <li role="presentation"><a href="#sign-up" data-toggle="tab">Sign Up</a></li>
                </ul>
            </div>
            <div class="modal-body">
                <div class="tab-content row">
                    <form id="sign-in" class="modal-form tab-pane fade in active col-xs-12">
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-user"></div>
                            <input type="text" class="form-control" placeholder="Username">
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-lock"></div>
                            <input type="password" class="form-control" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-default col-xs-12">Sign In</button>
                    </form>
                    <form id="sign-up" class="modal-form tab-pane fade col-xs-12">
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-user"></div>
                            <input type="text" class="form-control" placeholder="Username">
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-envelope"></div>
                            <input type="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-lock"></div>
                            <input type="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-lock"></div>
                            <input type="password" class="form-control" placeholder="Repeat your password">
                        </div>
                        <button type="submit" class="btn btn-default col-xs-12">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper container-fluid">