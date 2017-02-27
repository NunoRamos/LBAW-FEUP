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

<nav class="navbar navbar-default" role="navigation">
    <div class="wrapper">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../index.php">Reply Planet</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                {if $smarty.server.SCRIPT_NAME !== "/pages/search_results.php"}
                    <li>
                        <form class="navbar-form" action="search_results.php">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control full-width" placeholder="Search"/>
                                <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i
                                    class="glyphicon glyphicon-search"></i></button>
                    </span>
                            </div>
                        </form>
                    </li>
                {/if}
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    {$logged_in=true}
                    {if $logged_in}
                        <div class="dropdown">
                            <img class="pull-right dropdown-toggle img-circle navbar-btn sign-in-btn-style"
                                 data-toggle="dropdown" src="../img/user-default.png" width="10%" alt="User Image">
                            <ul class="dropdown-menu menu-spot">
                                <li><span>Signed in as</span></li>
                                <li><span><strong>Nuno Ramos</strong></span></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Profile</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Settings</a></li>
                                <li><a href="#">Sign Out</a></li>
                            </ul>
                        </div>
                    {else}
                        <button type="button" class="btn btn-default navbar-btn" data-toggle="modal"
                                data-target="#sign-in-modal">Sign In
                        </button>
                    {/if}
                </li>
            </ul>
        </div>
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
                        <button type="submit" class="btn btn-primary col-xs-12">Sign In</button>
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
                        <button type="submit" class="btn btn-primary col-xs-12">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">