<?php
    session_start();

    ////----Déconnexion
    if (isset($_GET['logout'])) {
        //session_destroy();
        unset($_SESSION['login']);
    }

    //-----Vérification login
    if (!isset($_SESSION['login'])) {
        header("Location:./index.php");
    }

    require_once("./common_ressources/fonctions.php");

    //---Requete de liste
    $participants = recuperer_participants($mysqli);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Simplon Manager</title>
        <link rel="stylesheet" type="text/css" href="./assets/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="./assets/bootstrap/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="./assets/css/dashboard.css">
        <link rel="stylesheet" type="text/css" href="./assets/css/styleAdmin.css">
        <link rel="stylesheet" type="text/css" href="./assets/css/styleAccueil.css">
        <script type="text/javascript" src="./assets/js/jquery-1.10.2.js" ></script>
        <script type="text/javascript" src="./assets/bootstrap/js/bootstrap.js" ></script>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li><a class="navbar-brand" href="accueil.php">Accueil</a></li>
                        <?php
                            $profil = verification_profil($mysqli, $_SESSION['login']);
                            if ($profil['libelle'] == "admin") {
                                ?>
                                <li><a class="navbar-brand" href="./admin/gestionUtilisateur.php">Gestion des utilisateurs</a></li>
                                <li><a class="navbar-brand" href="./admin/participantGestion.php">Gestion des participants</a></li>
                        <?php } ?> 
                        <li><a class="navbar-brand" href="./participantListeRecherche.php">Liste des participants</a></li>
                        <li><a class="navbar-brand" href="./admin/reinitialiserMotdepasse.php">Changer mon mot de passe</a></li>
                        <li><a class="navbar-brand" href="./accueil.php?logout=ok">Déconnexion</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="">
                                <?php
                                $utilisateur = recuperer_utilisateur($mysqli, $_SESSION['login']);
                                echo "Utilisateur connecté : ";
                                echo $utilisateur['prenoms'];
                                echo " ";
                                echo $utilisateur['nom'];
                                ?>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="centrerListe">               
                    <div class="col-lg-12 col-md-12 col-sm-12 main">
                        <img src="./assets/img/fond/softBG2-01.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>

        <!--?php include("footer.php"); ?-->
    </body>
</html>
