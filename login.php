<?php
session_start();
if(isset($_SESSION['prenom'])) {
    header("Location: main.php");
}
// on démarre la session, si l'utilisateur est connecté alors on redirige vers la page main.php.
include("header.php");

?>



<?php
    if (isset($_GET['error'])){
        echo "<div><span style='font-size:large;color:#ff3e2b'>".$_GET["error"]."</span></div>";
    }

?>

<div style="margin:1em;max-width: 500px" class="panel panel-default">
    <div class="panel-heading">Identifiez-vous</div>
    <div class="panel-body">
<form name="login" action="req_login.php" method="post" accept-charset="utf-8" class="form-horizontal">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" name="email" id="inputEmail3" placeholder="Email" value="
                <?php
            if (isset($_GET["email"])) {
                echo $_GET["email"];
            }
            ?>
            " required>
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
        <div class="col-sm-10">
            <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">Se connecter</button>
            <a href="inscription.php">
                <button type="button" class="btn btn-link">S'inscrire</button>
            <a href="inscription.php">

        </div>
    </div>
</form>
    </div>
</div>



</body>
</html>

