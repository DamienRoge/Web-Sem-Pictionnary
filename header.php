<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <link rel="stylesheet" media="screen" href="css/styles.css" >

    <link rel="stylesheet" media="screen" href="css/bootstrap.css" >
    <link rel="stylesheet" media="screen" href="css/bootstrap.css.map" >

    <link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAARGFwAP///wCEweMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADMiIzAAAAAAMiIiMAAAADMyAgIzMAAAEwAgIAMQAAAwAAIAADAAABAAAAAAEAAAAzMTEzMAAAADMAAAAwAAAAMAAAAzAAAAAwAAAAMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD//wAA//8AAPgPAADwBwAA4AMAAMABAADAAQAAwAEAAMABAADgAwAA4AMAAOHDAADj4wAA9/cAAP//AAD//wAA" rel="icon" type="image/x-icon" />
    <title>Pictionnary</title>
</head>
<body>

    <nav  style="margin:0px" class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="main.php">Pictionnary by Damien R.</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <?php if(isset($_SESSION['prenom'])){ ?>
                        <li><a href="logout.php">Deconnexion</a></li>
                    <?php } else {?>
                        <li><a href="login.php">Connexion</a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </nav>

<div style="margin-top: 0px;background-color: rgba(250,250,250,0.93)" class="page-header">
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li>
                <?php
                if(isset($_SESSION['prenom'])){
                    echo "<img id='profilepic' src='".$_SESSION['profilepic']."' ></img>";
                    echo "Bonjour ".$_SESSION['prenom']." ".$_SESSION['nom'];
                } else {
                    echo "<img style='width :50px;height:50px; margin-right: 1em;' id='profilepic' src='css/images/invite.png' >";
                    echo "Bonjour Invité";
                }
                ?>

            </li>
        </ul>

    </div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->

