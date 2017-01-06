<?php
include("header.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <link rel="stylesheet" media="screen" href="css/styles.css" >
    <title>Pictionnary - Inscription</title>
</head>
<body>
<?php
    if (isset($_GET['error'])){
        echo "<div><span style='font-size:large;color:#ff3e2b'>".$_GET["error"]."</span></div>";
    }
    else
        echo "Veuillez entrer vos identifiants";

?>
<form name="login" action="req_login.php" method="post" accept-charset="utf-8">
    <ul>
        <li><label for="username">Email</label>
            <input type="email" name="email" placeholder="yourname@email.com" value="
                <?php
                    if (isset($_GET["email"])) {
                        echo $_GET["email"];
                    }
                ?>
            " required></li>
        <li><label for="password">Password</label>
            <input type="password" name="password" placeholder="password" required></li>
        <li>
            <input type="submit" value="Login"></li>
    </ul>
</form>


</body>
</html>

