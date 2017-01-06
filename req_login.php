<?php
/**
 * Created by PhpStorm.
 * User: damy
 * Date: 05/01/2017
 * Time: 12:37
 */

foreach ($_POST as $item){
    if($item == "") $item=null;
}

$email=stripslashes($_POST['email']);
$password=stripslashes($_POST['password']);

try {
    // Connect to server and select database.
    $dbh = new PDO('mysql:host=localhost:3306;dbname=pictionnary', 'test', 'test');

    // Vérifier si un utilisateur avec cette adresse email existe dans la table.
    // En SQL: sélectionner tous les tuples de la table USERS tels que l'email est égal à $email.
    $sql = $dbh->query("SELECT * FROM USERS WHERE email=\"".$email."\" AND password = \"".$password."\"");
    if ($sql->rowCount()>=1/*est-ce que le nombre de réponses est supérieur ou égal à 1 ?*/) {
        // Utilisateur dans la BDD -> redirect main.php
        // rediriger l'utilisateur ici, avec tous les paramètres du formulaire plus le message d'erreur
        // utiliser à bon escient la méthode htmlspecialchars http://www.php.net/manual/fr/function.htmlspecialchars.php          // et/ou la méthode urlencode http://php.net/manual/fr/function.urlencode.php
    /*
        session_start();
        $_SESSION['email']= $email;
        $_SESSION['prenom']= $;

        header("Location: main.php");
*/
        $stmt = $dbh->prepare("SELECT * FROM USERS WHERE email=\"".$email."\" AND password = \"".$password."\"");
        $stmt->execute();
        $row = $stmt->fetch();
        var_dump($row);

    }
    else{
        //Utilisateur pas dans la BDD

        $temp = urlencode("Incorrect email / password");

        $temp = $temp."&email=".$email;
        header("Location: login.php?error=".$temp);


    }
}catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    $dbh = null;
    die();
}




?>