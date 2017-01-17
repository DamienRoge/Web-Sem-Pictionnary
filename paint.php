<?php
// on démarre la session, si l'utilisateur n'est pas connecté alors on redirige vers la page main.php.
session_start();
if(!isset($_SESSION['prenom'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>Pictionnary</title>
    <link rel="stylesheet" media="screen" href="css/styles.css" >
    <script>

        // les quatre tailles de pinceau possible.
        var sizes=[8,20,44,90];
        // la taille et la couleur du pinceau
        var size, color;
        // la dernière position du stylo
        var x0, y0;
        // le tableau de commandes de dessin à envoyer au serveur lors de la validation du dessin
        var drawingCommands = [];
        //DATA URI du dessin une fois fini

        var setColor = function() {
            // on récupère la valeur du champs couleur
            color = document.getElementById('color').value;
            console.log("color:" + color);
        }

        var setSize = function() {
            // ici, récupèrez la taille dans le tableau de tailles, en fonction de la valeur choisie dans le champs taille.
            //TODO
            size = sizes[parseInt(document.getElementById('size').value)];
            console.log("la size est:" + size);
        }

        window.onload = function() {
            var canvas = document.getElementById('myCanvas');
            canvas.width = 400;
            canvas.height= 400;
            var context = canvas.getContext('2d');

            setSize();
            setColor();
            document.getElementById('size').onchange = setSize;
            document.getElementById('color').onchange = setColor;

            var isDrawing = false;

            var startDrawing = function(e) {
                console.log("start");
                // créer un nouvel objet qui représente une commande de type "start", avec la position, la couleur
                var command = {};
                command.command="start";
                command.x=e.x;
                command.y=e.y;
                command.color=e.color;

                //...
                //c'est équivalent à:
                //command = {"command":"start", "x": e.x, ...};

                // Ce genre d'objet Javascript simple est nommé JSON. Pour apprendre ce qu'est le JSON, c.f. http://blog.xebia.fr/2008/05/29/introduction-a-json/

                // on l'ajoute à la liste des commandes
                drawingCommands.push(command);

                // ici, dessinez un cercle de la bonne couleur, de la bonne taille, et au bon endroit.
                //TODO
                isDrawing = true;
            }

            var stopDrawing = function(e) {
                console.log("stop");
                isDrawing = false;
            }

            var draw = function(e) {

                if(isDrawing) {
                    console.log("x: "+e.x);
                    console.log("y: "+e.y);
                    console.log("coucou");
                    //TODO
                    // ici, créer un nouvel objet qui représente une commande de type "draw", avec la position, et l'ajouter à la liste des commandes.
                    // ici, dessinez un cercle de la bonne couleur, de la bonne taille, et au bon endroit.
                    var command = {};
                    command.command="draw";
                    command.x=e.x;
                    command.y=e.y;
                    drawingCommands.push(command);


                    var c = document.getElementById( "myCanvas" );
                    var ctx = c.getContext("2d");

                    ctx.beginPath();
                    ctx.arc(e.x,e.y,size,0,Math.PI*2,true);
                    ctx.strokeStyle = color;
                    ctx.fillStyle = color;
                    ctx.fill();
                    ctx.stroke();
                }
            }

            canvas.onmousedown = startDrawing;
            canvas.onmouseout = stopDrawing;
            canvas.onmouseup = stopDrawing;
            canvas.onmousemove = draw;

            document.getElementById('restart').onclick = function() {
                console.log("clear");
                //TODO
                // ici ajouter à la liste des commandes une nouvelle commande de type "clear"
                var command = {};
                command.command="clear";
                drawingCommands.push(command);

                // ici, effacer le context, grace à la méthode clearRect.
                var c=document.getElementById("myCanvas");
                var ctx=c.getContext("2d");
                ctx.clearRect(0,0,document.getElementById('myCanvas').width,document.getElementById('myCanvas').height);

            };

            document.getElementById('validate').onclick = function() {
                // la prochaine ligne transforme la liste de commandes en une chaîne de caractères, et l'ajoute en valeur au champs "drawingCommands" pour l'envoyer au serveur.
                document.getElementById('drawingCommands').value = JSON.stringify(drawingCommands);

                //TODO
                // ici, exportez le contenu du canvas dans un data url, et ajoutez le en valeur au champs "picture" pour l'envoyer au serveur.
                document.getElementById('picture').value = canvas.toDataURL();

            };
        };
    </script>
</head>
<body>

<canvas style=" border:1px solid #428bca;" id="myCanvas"></canvas>

<form name="tools" action="req_paint.php" method="post">
    <!--TODO-->
    <!-- ici, insérez un champs de type range avec id="size", pour choisir un entier entre 0 et 4) -->
    <div style="display:block">
        Taille du pinceau :
        <input  name="d" id="size" value="1" type="range" min="0" max="3" step="1" oninput="
        result4.value=sizes[parseInt(d.value)];
        setSize();"/>
    <!-- ici, insérez un champs de type color avec id="color", et comme valeur l'attribut  de session couleur (à l'aide d'une commande php echo).) -->
        <output name="result4">20</output>px
    </div>
    <div style="display:block">
        Couleur de la peinture :
        <input type="color" value="#555555" name="couleur" id="color" />
    </div>
    <input id="restart" type="button" value="Recommencer"/>
    <input type="hidden" id="drawingCommands" name="drawingCommands"/>
    <!-- à quoi servent ces champs hidden ?
        Ces champs servent à envoyer les commandes et le dessin dans la requête post-->
    <input type="hidden" id="picture" name="picture"/>
    <input id="validate" type="submit" value="Valider"/>
</form>

</body>
</html>



<!--
TODO : curseur dans le canvas


-->