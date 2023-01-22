<?php
session_start();

    ////----Déconnexion
    if (isset($_GET['logout'])) {
        //session_destroy();
        unset($_SESSION['login']);
    }

//-----Vérification login
if (!isset($_SESSION['login'])) {
    header("Location:index.php");
}
require_once("../common_ressources/fonctions.php");


//---Requete de liste
$users = afficher_utilisateurs($mysqli);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Simplon Manager</title>
        <link rel="stylesheet" type="text/css" href="../assets/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../assets/bootstrap/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
        <!--link rel="stylesheet" type="text/css" href="../assets/css/styleAdmin.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/styleParticipants.css"-->
        <script type="text/javascript" src="../assets/js/jquery-1.10.2.js" ></script>
        <script type="text/javascript" src="../assets/bootstrap/js/bootstrap.js" ></script>
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
                        <li><a class="navbar-brand" href="../accueil.php">Accueil</a></li>
                        <?php
                            $profil = verification_profil($mysqli, $_SESSION['login']);
                            if ($profil['libelle'] == "admin") {
                                ?>
                                <li><a class="navbar-brand" href="./gestionUtilisateur.php">Gestion des utilisateurs</a></li>
                                <li><a class="navbar-brand" href="./participantGestion.php">Gestion des participants</a></li>
                        <?php } ?> 
                        <li><a class="navbar-brand" href="../participantListeRecherche.php">Liste des participants</a></li>
                        <li><a class="navbar-brand" href="./reinitialiserMotdepasse.php">Changer mon mot de passe</a></li>
                        <li><a class="navbar-brand" href="../accueil.php?logout=ok">Déconnexion</a></li>
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
                    <div>
                        <h1>Gesion des utilisateurs</h1>
                        <hr/>
                        <a href="UtilisateurAjout.php" class="btn btn-success"> Ajouter un utilisateur</a>
                        <br/><br/>
                        <table width="600" border="1" cellspacing="0" cellpadding="5" class="table table-bordered">
                            <tr>
                                <td>Nom</td>
                                <td>Prenom</td>
                                <td>Login</td>
                                <td>Profil</td>
                                <td>Opération sur l'utilisateur</td>
                            </tr>
                            <?php foreach ($users as $user) {
                                ?>
                                <tr>
                                    <td><?php echo $user['nom']; ?></td>
                                    <td><?php echo $user['prenoms']; ?></td>
                                    <td><?php echo $user['login']; ?></td>
                                    <td><?php echo $user['libelle']; ?></td>
                                    <td>
                                        <a href="utilisateurModif.php?login=<?php echo $user['login']; ?>">Modifier</a> |
                                        <a href="reinitialiserLogin.php?login=<?php echo $user['login']; ?>">Reinitialiser</a> |
                                        <a href="activerCompte.php?login=<?php echo $user['login']; ?>">Activer</a> |
                                        <a href="desactiverCompte.php?login=<?php echo $user['login']; ?>">Désactiver</a> |
                                        <a href="supprimerCompte.php?login=<?php echo $user['login']; ?>">Supprimer</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
			</div>
        </div>
    </body>
</html>
