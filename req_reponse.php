<?php
/**
 * Created by PhpStorm.
 * User: Damien
 * Date: 28/11/2016
 * Time: 19:58
 */
// récupérer les éléments du formulaire
// et se protéger contre l'injection MySQL (plus de détails ici: http://us.php.net/mysql_real_escape_string)

foreach($_POST as $item){
    if($item=="") $item = null;
}

$id_dessin =stripslashes($_POST['id_dessin']);
$proposition =stripslashes($_POST['proposition']);

try {
    // Connect to server and select database.
    $xml_bdd_infos = simplexml_load_file('./config/BDD.xml');
    $dbh = new PDO($xml_bdd_infos->type.':host='.$xml_bdd_infos->url.':'.$xml_bdd_infos->port.';dbname='.$xml_bdd_infos->dbname, $xml_bdd_infos->user, $xml_bdd_infos->password);



        $stmt = $dbh->prepare("SELECT reponse FROM DRAWINGS WHERE id=\"".$id_dessin."\"");
        $stmt->execute();
        $row = $stmt->fetch();

        $stmt2 = $dbh->prepare("UPDATE DRAWINGS SET nb_tentatives = nb_tentatives+1 WHERE id=\"".$id_dessin."\" ");
        $stmt2->execute();


    if($row['reponse']==$proposition){//SI BONNE REPONSE
        $stmt3 = $dbh->prepare("UPDATE DRAWINGS SET reussi=1 WHERE id=\"".$id_dessin."\" ");
        $stmt3->execute();
        header("Location: main.php");
    }
    else{    //SI MAUVAISE REPONSE
        header("Location: guess.php?ds_id=".$id_dessin);
    }

}catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    $dbh = null;
    die();
}

?>
