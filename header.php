
<header>
<?php
session_start();

if(isset($_SESSION['prenom'])){
    print_r($_SESSION);
    echo "Bonjour ".$_SESSION['prenom']."<br>";
    echo "Bonjour ".$_SESSION['prenom']."<br>";
    echo "<a href='logout.php'>Deconnexion</a>";
}
else{
    echo "Bonjour invité";
}

?>
<canvas id="preview" width="0" height="0"></canvas>

</header>