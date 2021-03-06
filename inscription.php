<?php
/**
 * Created by PhpStorm.
 * User: Damien
 * Date: 28/11/2016
 * Time: 13:34
 */
session_start();
if(isset($_SESSION['prenom'])) {
    header("Location: main.php");
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

<h2>Inscrivez-vous</h2>

<?php
if (isset($_GET["erreur"])) {
    echo "<div><span style='font-size:large;color:#ff3e2b'>".$_GET["erreur"]."</span></div>";
}
?>

<form class="inscription" action="req_inscription.php" method="post" name="inscription">
    <!-- c'est quoi les attributs action et method ?
    Rep : action spécifie le fichier php à executer après le clic sur submit
          L'attribut methode spéécifie le type de requête http d'envoi du formulaire-->
    <!-- qu'y a-t-il d'autre comme possiblité que post pour l'attribut method ?
        Rep : l'autre méthode est get-->
    <span class="required_notification">Les champs obligatoires sont indiqués par *</span>
    <ul>
        <li>
            <label for="email">E-mail :</label>
            <input type="email" name="email" id="email" autofocus required  value="<?php
            if (isset($_GET["email"])) {
                echo $_GET["email"];
            }
            ?>"/>
            <!-- ajouter à input l'attribut qui lui donne le focus automatiquement -->
            <!-- ajouter à input l'attribut qui dit que c'est un champs obligatoire -->
            <!-- quelle est la différence entre les attributs name et id ?
                id : identifiant pour le css
                name : nom dans $POST[] en PHP -->
            <!-- c'est lequel qui doit être égal à l'attribut for du label ?
                Rep: id-->
            <span class="form_hint">Format attendu "name@something.com"</span>
        </li>
        <li>
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" placeholder="Damien"  value="<?php
            if (isset($_GET["prenom"])) {
                echo $_GET["prenom"];
            }
            ?>" required/>
        <!-- ajouter à input l'attribut qui dit que c'est un champs obligatoire -->
        <!-- ajouter à input l'attribut qui donne une indication grisée (placeholder) -->
        </li>
        <li>
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" placeholder="Rogé"  value="<?php
            if (isset($_GET["nom"])) {
                echo $_GET["nom"];
            }
            ?>"/>
            <!-- ajouter à input l'attribut qui dit que c'est un champs obligatoire -->
            <!-- ajouter à input l'attribut qui donne une indication grisée (placeholder) -->
        </li>
        <li>
            <label for="tel">Téléphone :</label>
            <input type="tel" name="tel" id="tel"  value="<?php
            if (isset($_GET["tel"])) {
                echo $_GET["tel"];
            }
            ?>"/>

        </li>
        <li>
            <label for="website">Site Web :</label>
            <input type="url" name="website" id="website"  value="<?php
            if (isset($_GET["website"])) {
                echo $_GET["website"];
            }
            ?>"/>

        </li>

        <li>
            <label for="sexe">Sexe :</label>
            <label style="all:initial">Homme</label>
            <input style="width: 20px;" type="radio" name="sexe" id="sexe" value="h"/>
            <label style="all:initial;width: 5px;">Femme</label>
            <input style="width: 20px;" type="radio" name="sexe" id="sexe" value="f"/>


        </li>

        <li>
            <label for="mdp1">Mot de passe :</label>
            <input type="password" name="password" id="mdp1" required placeholder="azerty" pattern="^([a-zA-Z0-9]{6,8})$" onkeyup="validateMdp2()" title = "Le mot de passe doit contenir de 6 à 8 caractères alphanumériques.">
            <!-- ajouter à input l'attribut qui dit que c'est un champs obligatoire -->
            <!-- ajouter à input l'attribut qui donne une indication grisée (placeholder) -->
            <!-- spécifiez l'expression régulière: le mot de passe doit être composé de 6 à 8 caractères alphanumériques -->
            <!-- quels sont les deux scénarios où l'attribut title sera affiché ?
                Rep : 1. Si le pattern n'est pas respecté
                      2. ??? -->
            <!-- encore une fois, quelle est la différence entre name et id pour un input ?
                id : identifiant en html
                name : identifiant après envoi de la requête -->
            <span class="form_hint">De 6 à 8 caractères alphanumériques.</span>
        </li>
        <li>
            <label for="mdp2">Confirmez mot de passe :</label>
            <input type="password" id="mdp2" required placeholder="azerty" onkeyup="validateMdp2()">
            <!-- ajouter à input l'attribut qui dit que c'est un champs obligatoire -->
            <!-- ajouter à input l'attribut qui donne une indication grisée (placeholder) -->
            <!-- pourquoi est-ce qu'on a pas mis un attribut name ici ? -->
            <!-- quel scénario justifie qu'on ait ajouté l'écouteur validateMdp2() à l'évènement onkeyup de l'input mdp1 ?
                Rep : l'utilisateur rentre mdp1 puis mp2 puis modifie mdp1-->
            <span class="form_hint">Les mots de passes doivent être égaux.</span>
            <script>
                validateMdp2 = function(e) {
                    var mdp1 = document.getElementById('mdp1');
                    var mdp2 = document.getElementById('mdp2');

                    if (/^([a-zA-Z0-9]+)$/.test(mdp1.value)/* est-ce que mdp1 est valide ? */ && mdp1.value == mdp2.value/* est-ce que mdp1 et mdp2 ont la même valeur ? */) {
                        // ici on supprime le message d'erreur personnalisé, et du coup mdp2 devient valide.
                        document.getElementById('mdp2').setCustomValidity('');
                    } else {
                        // ici on ajoute un message d'erreur personnalisé, et du coup mdp2 devient invalide.
                        document.getElementById('mdp2').setCustomValidity('Les mots de passes doivent être égaux.');
                    }
                }
            </script>
        </li>
        <li>
            <label for="birthdate">Date de naissance:</label>
            <input type="date" name="birthdate" id="birthdate" placeholder="JJ/MM/AAAA" required onchange="computeAge()"  value="<?php
            if (isset($_GET["birthdate"])) {
                echo $_GET["birthdate"];
            }
            ?>"/>
            <script>
                computeAge = function(e) {
                    try{
                        // j'affiche dans la console quelques objets javascript, ce qui devrait vous aider.

                        console.log(Date.now());
                        console.log(document.getElementById("birthdate"));
                        console.log(document.getElementById("birthdate").valueAsDate);
                        console.log(Date.parse(document.getElementById("birthdate").valueAsDate));
                        console.log(new Date(0).getYear());
                        console.log(new Date(65572346585).getYear());

                        console.log(Date.parse(new Date()) - Date.parse(document.getElementById("birthdate").valueAsDate));
                        console.log(new Date());

                        var Diffmilli = Date.parse(new Date()) - Date.parse(document.getElementById("birthdate").valueAsDate);
                        var DiffDate = new Date(Diffmilli);

                        // modifier ici la valeur de l'élément age
                        document.getElementById("age").value = Math.abs(DiffDate.getUTCFullYear() - 1970);
                    } catch(e) {
                        // supprimez ici la valeur de l'élément age
                       document.getElementById("age").value = "";

                    }
                }
            </script>
            <span class="form_hint">Format attendu "JJ/MM/AAAA"</span>
        </li>
        <li>
            <label for="age">Age:</label>
            <input type="number" name="age" id="age" disabled/>
            <!-- à quoi sert l'attribut disabled ?
                Rep : l'utilisateur ne peut pas modifier la valeur-->
        </li>

        <li>
            <label for="ville">Ville :</label>
            <input type="text" name="ville" id="ville"  value="<?php
            if (isset($_GET["ville"])) {
                echo $_GET["ville"];
            }
            ?>"/>

        </li>

        <li>
            <label for="taille">Taille :</label>
            <input type="range" value="1.70" max="2.30" min="1" step="0.01" name="taille" id="taille" oninput="result4.value=parseFloat(taille.value)"  value="<?php
            if (isset($_GET["taille"])) {
                echo $_GET["taille"];
            }
            ?>"/>
            <output name="result4">1.70</output>m

        </li>

        <li>
            <label for="couleur">Couleur préféré :</label>
            <input type="color" value="#555555" name="couleur" id="couleur"  value="<?php
            if (isset($_GET["couleur"])) {
                echo "#"._GET["couleur"];
            }
            ?>"/>

        </li>

        <li>
            <label for="profilepicfile">Photo de profil:</label>
            <input type="file" id="profilepicfile" onchange="loadProfilePic(this)"/>
            <!-- l'input profilepic va contenir le chemin vers l'image sur l'ordinateur du client -->
            <!-- on ne veut pas envoyer cette info avec le formulaire, donc il n'y a pas d'attribut name -->
            <span class="form_hint">Choisissez une image.</span>
            <input type="hidden" id="profilepic" name="profilepic"  value="coucou"/>
            <input type="hidden" id="maphoto" name="maphoto" value="coucou"/>

            <!-- l'input profilepic va contenir l'image redimensionnée sous forme d'une data url -->
            <!-- c'est cet input qui sera envoyé avec le formulaire, sous le nom profilepic -->
            <canvas id="preview" width="0" height="0"></canvas>
            <!-- le canvas (nouveauté html5), c'est ici qu'on affichera une visualisation de l'image. -->
            <!-- on pourrait afficher l'image dans un élément img, mais le canvas va nous permettre également
            de la redimensionner, et de l'enregistrer sous forme d'une data url-->
            <script>
                loadProfilePic = function (e) {
                    // on récupère le canvas où on affichera l'image
                    var canvas = document.getElementById("preview");
                    var ctx = canvas.getContext("2d");
                    // on réinitialise le canvas: on l'efface, et déclare sa largeur et hauteur à 0
                    //ctx.setFillColor("white");
                    ctx.fillRect(0,0,canvas.width,canvas.height);
                    canvas.width=0;
                    canvas.height=0;
                    // on récupérer le fichier: le premier (et seul dans ce cas là) de la liste
                    var file = document.getElementById("profilepicfile").files[0];
                    // l'élément img va servir à stocker l'image temporairement
                    var img = document.createElement("img");
                    // l'objet de type FileReader nous permet de lire les données du fichier.
                    var reader = new FileReader();
                    // on prépare la fonction callback qui sera appelée lorsque l'image sera chargée
                    reader.onload = function(e) {
                        //on vérifie qu'on a bien téléchargé une image, grâce au mime type
                        if (!file.type.match(/image.*/)) {
                            // le fichier choisi n'est pas une image: le champs profilepicfile est invalide, et on supprime sa valeur
                            document.getElementById("profilepicfile").setCustomValidity("Il faut télécharger une image.");
                            document.getElementById("profilepicfile").value = "";
                        }
                        else {
                            // le callback sera appelé par la méthode getAsDataURL, donc le paramètre de callback e est une url qui contient
                            // les données de l'image. On modifie donc la source de l'image pour qu'elle soit égale à cette url
                            // on aurait fait différemment si on appelait une autre méthode que getAsDataURL.
                            img.src = e.target.result;
                            // le champs profilepicfile est valide
                            document.getElementById("profilepicfile").setCustomValidity("");
                            var MAX_WIDTH = 96;
                            var MAX_HEIGHT = 96;
                            var width = img.width;
                            var height = img.height;

                            // A FAIRE: si on garde les deux lignes suivantes, on rétrécit l'image mais elle sera déformée
                            // Vous devez supprimer ces lignes, et modifier width et height pour:
                            //    - garder les proportions,
                            //    - et que le maximum de width et height soit égal à 96
                            var ratio = width<height;
                            if(width<height){
                                width = 96*width/height;
                                height = 96;
                            }else {
                                height = 96*height/width;
                                width = 96;
                            }


                            canvas.width = width;
                            canvas.height = height;
                            // on dessine l'image dans le canvas à la position 0,0 (en haut à gauche)
                            // et avec une largeur de width et une hauteur de height
                            ctx.drawImage(img, 0, 0, width, height);
                            // on exporte le contenu du canvas (l'image redimensionnée) sous la forme d'une data url
                            var dataurl = canvas.toDataURL("image/png");
                            // on donne finalement cette dataurl comme valeur au champs profilepic
                            console.log("profilepic URI : " + dataurl);
                            document.getElementById("maphoto").value = dataurl;
                            document.getElementById("profilepic").value = dataurl;

                        };
                    }
                    // on charge l'image pour de vrai, lorsque ce sera terminé le callback loadProfilePic sera appelé.
                    reader.readAsDataURL(file);
                }
            </script>
        </li>
        <li>
            <input type="submit" value="Soumettre Formulaire">
            <a href="login.php"> <input type="button" value="Annuler"></a>

        </li>
    </ul>

</form>
</body>
</html>

