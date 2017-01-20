<?php include("header.php");


$id = $_SESSION['id'];

$dessins = [];

/* Recuperation pour chaques dessins où l'utilisateur est destinataire des infos du dessins et du nom / prenom de l'auteur du dessin*/
try {
    // Connect to server and select database.
    $xml_bdd_infos = simplexml_load_file('./config/BDD.xml');
    $dbh = new PDO($xml_bdd_infos->type.':host='.$xml_bdd_infos->url.':'.$xml_bdd_infos->port.';dbname='.$xml_bdd_infos->dbname, $xml_bdd_infos->user, $xml_bdd_infos->password);

    $stmt = $dbh->prepare("SELECT d.*, u.id AS f_id, u.prenom, u.nom ".
        "FROM pictionnary.drawings AS d ".
        "INNER JOIN pictionnary.users AS u ".
        "ON u.id = d.u_id ".
        "WHERE ".$id." = d.u_id_destinataire ;");
    $stmt->execute();
    $dessins = $stmt->fetchAll();


}catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    $dbh = null;
    die();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <link rel="stylesheet" media="screen" href="css/styles.css" >
    <title>Pictionnary - Inscription</title>
</head>
<body>
<div style="margin: 1em;">
    <a href="paint.php"><button type="button" class="btn btn-primary">Dessiner</button>
    </a>
</div>


<div style="margin: 1em;max-width: 900px;" class="panel panel-primary">
    <div class="panel-heading">Vos défis !</div>
    <div class="panel-body">
        <ul>
    <?php
        foreach ($dessins as $dessin){

            if($dessin['reussi']==0){
                echo "<li>";
                echo "<span style='color: #537cff;'>" .$dessin['prenom']." ".$dessin['nom']."</span> vous a envoyé un dessin ! Vous avez déjà fait <span style='color: #537cff;'>".$dessin['nb_tentatives']."</span> tentatives. ";
                echo "<a href='guess.php?ds_id=".$dessin['id']."'>"."<button type=\"button\" class=\"btn btn-primary\">Tenter de deviner</button>"."</a>";
                echo "</li>";
            }
        }
    ?>
        </ul>
</div>
</div>

<div style="margin: 1em;max-width: 900px;" class="panel panel-info">
    <div class="panel-heading">Historique des dessins</div>
    <div class="panel-body">
        <ul>
            <?php
            foreach ($dessins as $dessin){

                if($dessin['reussi']==1){
                    echo "<li>";
                    echo "Vous avez deviné le dessin de ".$dessin['prenom']." ".$dessin['nom']." en ".$dessin['nb_tentatives']." coups";
                    echo "<div>";
                    echo "<img style='width:100px; height:100px' src='".$dessin['picture']."'/>";
                    echo "<p>C'était le mot \"".$dessin['reponse']."\"</p>";
                    echo "</div>";
                    echo "</li>";
                }
            }
            ?>
        </ul>
    </div>
</div>

</body></html>
