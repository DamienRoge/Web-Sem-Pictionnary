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
    <title>Pictionnary - Inscription</title>
</head>
<body>

<header style="margin: 1em; height: 80px">

    <?php

    if(isset($_SESSION['prenom'])){
        echo "<div class='header_user_infos' >";
        echo "Bonjour ".$_SESSION['prenom']."<br>";

        echo "<img id='profilepic' src='".$_SESSION['profilepic']."' ></img>";
        echo "</div>";

        echo "<div class='header_deco' >";
        echo "<a  style='margin-top : 50px' href='logout.php'>Deconnexion</a>";
        echo "</div>";
    }
    else{
        echo "<div class='header_user_infos' >";
        echo "Bonjour invité<br>";
        echo "<img style='width :50px;height:50px' id='profilepic' src='css/images/invite.png' >";

        echo "</div>";

        echo "<div class='header_deco' >";
        echo "<a style='display:block' href='login.php'>Se connecter</a>";
        echo "</div>";

    }

    ?>

</header>
<hr>