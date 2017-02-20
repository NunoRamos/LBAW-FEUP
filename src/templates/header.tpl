<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$page_title}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/custom.min.css">
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
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
                <button type="button" class="btn btn-default navbar-btn">Register</button>
            </li>
        </ul>
    </div>
</nav>


<div class="modal fade" id="sign-in-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Sign In</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="col-xs-6">
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-user"></div>
                            <input type="text" class="form-control" placeholder="Username">
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-addon glyphicon glyphicon-lock"></div>
                            <input type="password" class="form-control" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-primary">Sign In</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
