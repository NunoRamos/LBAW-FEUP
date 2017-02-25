<?php
/* Smarty version 3.1.30, created on 2017-02-20 18:29:13
  from "/home/nuno/Documents/GitHub/LBAW-FEUP/src/templates/header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58ab2769c3cbe0_06341993',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6aaacbf78347203e9f04a860a1dbb7abb97af35c' => 
    array (
      0 => '/home/nuno/Documents/GitHub/LBAW-FEUP/src/templates/header.tpl',
      1 => 1487611735,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58ab2769c3cbe0_06341993 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/custom.min.css">
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
            <a class="navbar-brand" href="index.php">Reply Planet</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                <li><a>Categories</a></li>
                <li>
                    <form class="navbar-form">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search"/>
                            <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i
                                    class="glyphicon glyphicon-search"></i></button>
                    </span>
                        </div>
                    </form>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <button type="button" class="btn btn-default navbar-btn" data-toggle="modal"
                            data-target="#sign-in-modal">Sign In
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>


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

<div class="wrapper"><?php }
}
