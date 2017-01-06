<?php
session_start();
?>
<header>

<?php

if(isset($_SESSION['prenom'])){
    echo "Bonjour ".$_SESSION['prenom']."<br>";
    echo "<a href='logout.php'>Deconnexion</a>";
}
else{
    echo "Bonjour invité";
}

?>
<canvas id="preview" width="0" height="0"></canvas>

</header>