<?php
/**
 * Created by PhpStorm.
 * User: Damien
 * Date: 28/11/2016
 * Time: 19:58
 */
// récupérer les éléments du formulaire
// et se protéger contre l'injection MySQL (plus de détails ici: http://us.php.net/mysql_real_escape_string)
session_start();

foreach($_POST as $item){
    if($item=="") $item = null;
}

$drawingCommands = $_POST['drawingCommands'];
$picture = $_POST['picture'];
$u_id = $_SESSION['id'];
$u_id_destinataire = $_POST['destinataire'];
$reponse = $_POST['reponse'];

/* AJOUT DU DESSIN DANS LA BDD
    avec le nom du destinataire et la reponse */


try {
    // Connect to server and select database.
    $xml_bdd_infos = simplexml_load_file('./config/BDD.xml');
    $dbh = new PDO($xml_bdd_infos->type.':host='.$xml_bdd_infos->url.':'.$xml_bdd_infos->port.';dbname='.$xml_bdd_infos->dbname, $xml_bdd_infos->user, $xml_bdd_infos->password);

    $sql = $dbh->prepare("INSERT INTO drawings (u_id, picture, drawingcommands, u_id_destinataire, reponse, nb_tentatives, reussi,date) "
        . "VALUES (:u_id, :picture, :drawingcommands, :u_id_destinataire, :reponse, 0,0, now())");
    $sql->bindValue(":u_id", $u_id, PDO::PARAM_INT);
    $sql->bindValue(":picture", $picture, PDO::PARAM_LOB);
    $sql->bindValue(":drawingcommands", $drawingCommands, PDO::PARAM_STR);
    $sql->bindValue(":u_id_destinataire", $u_id_destinataire, PDO::PARAM_INT);
    $sql->bindValue(":reponse", $reponse, PDO::PARAM_STR);


    //


    // on tente d'exécuter la requête SQL, si la méthode renvoie faux alors une erreur a été rencontrée.
    if (!$sql->execute()) {
        echo "PDO::errorInfo():<br/>";
        $err = $sql->errorInfo();
        print_r($err);
    } else {
        header("Location: main.php");
    }
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    $dbh = null;
    die();
}


?>