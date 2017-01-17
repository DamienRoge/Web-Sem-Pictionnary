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




try {
    // Connect to server and select database.
    $dbh = new PDO('mysql:host=localhost:3306;dbname=pictionnary', 'test', 'test');

    // Tenter d'inscrire l'utilisateur dans la base
    $sql = $dbh->prepare("INSERT INTO drawings (u_id, picture, drawingcommands) "
        . "VALUES (:u_id, :picture, :drawingcommands)");
    $sql->bindValue(":u_id", $u_id, PDO::PARAM_INT);
    $sql->bindValue(":picture", $picture, PDO::PARAM_LOB);
    $sql->bindValue(":drawingcommands", $drawingCommands, PDO::PARAM_STR);

    print_r($sql);

    // de même, lier la valeur pour le mot de passe
    // lier la valeur pour le nom, attention le nom peut être nul, il faut alors lier avec NULL, ou DEFAULT
    // idem pour le prenom, tel, website, birthdate, ville, taille, profilepic
    // n.b., notez: birthdate est au bon format ici, ce serait pas le cas pour un SGBD Oracle par exemple
    // idem pour la couleur, attention au format ici (7 caractères, 6 caractères attendus seulement)
    // idem pour le prenom, tel, website
    // idem pour le sexe, attention il faut être sûr que c'est bien 'H', 'F', ou ''

    // on tente d'exécuter la requête SQL, si la méthode renvoie faux alors une erreur a été rencontrée.
    if (!$sql->execute()) {
        echo "PDO::errorInfo():<br/>";
        $err = $sql->errorInfo();
        print_r($err);
    } else {

    }
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    $dbh = null;
    die();
}
        // Tenter d'inscrire l'utilisateur dans la base

?>