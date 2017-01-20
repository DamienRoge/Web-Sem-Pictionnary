<?php
session_start();
session_destroy();
header("Location: login.php");
?>

Vous êtes maintenant déconnecté

<a style='display:block' href='login.php'>Se connecter</a>
