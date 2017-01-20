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

$email=stripslashes($_POST['email']);
$password=stripslashes($_POST['password']);
$nom=stripslashes($_POST['nom']);
$prenom=stripslashes($_POST['prenom']);
$tel=stripslashes($_POST['tel']);
$website=stripslashes($_POST['website']);
$sexe='';
if (array_key_exists('sexe',$_POST)) {
    $sexe=stripslashes($_POST['sexe']);
}
$birthdate=stripslashes($_POST['birthdate']);
$ville=stripslashes($_POST['ville']);
$taille=stripslashes($_POST['taille']);
$couleur=stripslashes($_POST['couleur']);
$couleur = ltrim($couleur, '#'); //seulement 6 chars acceptés dans la bdd..
$profilepic=stripslashes($_POST['profilepic']);


try {
    // Connect to server and select database.
    $xml_bdd_infos = simplexml_load_file('./config/BDD.xml');
    $dbh = new PDO($xml_bdd_infos->type.':host='.$xml_bdd_infos->url.':'.$xml_bdd_infos->port.';dbname='.$xml_bdd_infos->dbname, $xml_bdd_infos->user, $xml_bdd_infos->password);

    // Vérifier si un utilisateur avec cette adresse email existe dans la table.
    // En SQL: sélectionner tous les tuples de la table USERS tels que l'email est égal à $email.
    $sql = $dbh->query("SELECT * FROM USERS WHERE email=\"".$email."\"");
    if ($sql->rowCount()>=1) {
        // rediriger l'utilisateur ici, avec tous les paramètres du formulaire plus le message d'erreur
        // utiliser à bon escient la méthode htmlspecialchars http://www.php.net/manual/fr/function.htmlspecialchars.php
        //
        //          // et/ou la méthode urlencode http://php.net/manual/fr/function.urlencode.php
        $temp = urlencode("Cette adresse e-mail est déjà utilisée");

        foreach ($_POST as $key => $value){
            $temp = $temp."&".$key."=".$value;
        }

        header("Location: inscription.php?erreur=".$temp);

    }
    else {
        // Tenter d'inscrire l'utilisateur dans la base
        $sql = $dbh->prepare("INSERT INTO users (email, password, nom, prenom, tel, website, sexe, birthdate, ville, taille, couleur, profilepic) "
            . "VALUES (:email, :password, :nom, :prenom, :tel, :website, :sexe, :birthdate, :ville, :taille, :couleur, :profilepic)");
        $sql->bindValue(":email", $email, PDO::PARAM_STR);
        $sql->bindValue(":password", md5($password), PDO::PARAM_STR);
        $sql->bindValue(":nom", $nom, PDO::PARAM_STR);
        $sql->bindValue(":prenom", $prenom, PDO::PARAM_STR);
        $sql->bindValue(":tel", $tel, PDO::PARAM_STR);
        $sql->bindValue(":website", $website, PDO::PARAM_STR);
        $sql->bindValue(":sexe", $sexe, PDO::PARAM_STR);
        $sql->bindValue(":birthdate", $birthdate, PDO::PARAM_STR);
        $sql->bindValue(":ville", $ville, PDO::PARAM_STR);
        $sql->bindValue(":taille", $taille, PDO::PARAM_STR);
        $sql->bindValue(":couleur", $couleur, PDO::PARAM_STR);
        $sql->bindValue(":profilepic", $profilepic, PDO::PARAM_LOB);



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

            // ici démarrer une session
            session_start();

            // ensuite on requête à nouveau la base pour l'utilisateur qui vient d'être inscrit, et
            $sql = $dbh->query("SELECT * FROM USERS u WHERE u.email='".$email."'");
            if ($sql->rowCount()<1) {
                header("Location: main.php?erreur=".urlencode("un problème est survenu"));
            }
            else {
                // on récupère la ligne qui nous intéresse avec $sql->fetch(),
                // et on enregistre les données dans la session avec $_SESSION["..."]=...
                // on récupère la ligne qui nous intéresse avec $sql->fetch(),
                // et on enregistre les données dans la session avec $_SESSION["..."]=...
                $result = $sql->fetch(PDO::FETCH_ASSOC);



            }

            // ici,  rediriger vers la page login.php, on ne peut pas loger l'utilisateur tout de suite car nous ne connaissons pas son id
            header("Location: login.php");

        }
        $dbh = null;
    }
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    $dbh = null;
    die();
}
?>