<?php
include "header.php";

    // ici, récupérer la liste des commandes dans la table DRAWINGS avec l'identifiant $_GET['id']
    // l'enregistrer dans la variable $commands
    //todo

    $commands ="[]";
    try {
        // Connect to server and select database.
        $xml_bdd_infos = simplexml_load_file('./config/BDD.xml');
        $dbh = new PDO($xml_bdd_infos->type.':host='.$xml_bdd_infos->url.':'.$xml_bdd_infos->port.';dbname='.$xml_bdd_infos->dbname, $xml_bdd_infos->user, $xml_bdd_infos->password);

        $stmt = $dbh->prepare("SELECT drawingcommands FROM drawings WHERE id=\"".$_GET['ds_id']."\"");
        $stmt->execute();
        $commands = $stmt->fetchColumn();


    }catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        $dbh = null;
        die();
    }



?>

    <script>
        // la taille et la couleur du pinceau
        var size, color;
        // la dernière position du stylo
        var x0, y0;
        // le tableau de commandes de dessin à envoyer au serveur lors de la validation du dessin
        var drawingCommands = <?php echo $commands;?>

        window.onload = function() {
            var canvas = document.getElementById('myCanvas');
            canvas.width = 400;
            canvas.height= 400;
            var context = canvas.getContext('2d');

            var start = function(c) {
                console.log(c.size);
                console.log(c.color);


                // complétez todo
                size = c.size;
                color = c.color;

            }

            var draw = function(c) {
                console.log(c.command);
                // complétez todo
                context.beginPath();
                context.arc(c.x+emplacement_canvas.left,c.y-emplacement_canvas.top-10,size,0,Math.PI*2,true);
                context.strokeStyle = color;
                context.fillStyle = color;
                context.fill();
                context.stroke();
            }

            var clear = function() {

                // complétez todo
                context.clearRect(0,0,document.getElementById('myCanvas').width,document.getElementById('myCanvas').height);
            }

            // étudiez ce bout de code todo
            var i = 0;
            var iterate = function() {
                if(i>=drawingCommands.length)
                    return;
                var c = drawingCommands[i];
                switch(c.command) {
                    case "start":
                        start(c);
                        break;
                    case "draw":
                        draw(c);
                        break;
                    case "clear":
                        clear();
                        break;
                    default:
                        console.error("cette commande n'existe pas "+ c.command);
                }
                i++;
                setTimeout(iterate,1);
            };

            iterate();

        };

        /* PARTIE SAISIE DE LA REPONSE */

        var reponses =[];


    </script>
</head>
<body>
<canvas style=" border:1px solid #428bca;" id="myCanvas"></canvas>
<script>
    //Emplacement du canvas , permet de compenser la taille du header au moment de tracer le cercle
    var emplacement_canvas = document.getElementById("myCanvas").getBoundingClientRect();
    console.log(emplacement_canvas.left);
    console.log(emplacement_canvas.top);

</script>


<div style="margin: 1em;max-width: 500px;" class="panel panel-default">
    <div class="panel-heading">Vos réponses</div>
    <div class="panel-body">
        <form name="login" action="req_reponse.php" method="post" accept-charset="utf-8">
            <input type="hidden" name="id_dessin" value="<?php echo $_GET['ds_id'] ?>">
            <input type="text" name="proposition" class="form-control" id="inputReponse" placeholder="Votre réponse" required>
            <button type="submit" class="btn btn-primary">J'ai trouvé ?</button>
        </form>
        <ul id="reponse_container">

        </ul>
    </div>
</div>




<a href="main.php">Abandonner</a>
</body>
</html>