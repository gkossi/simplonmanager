<?php
    session_start();

    // L'utilisateur est-il connecté?
    if (!isset($_SESSION['login'])) {
        header("Location:index.php");
    }

    require_once("../common_ressources/fonctions.php");

    $pays = recuperer_pays($mysqli);
    $participant = recuperer_participant_par_id($mysqli, $_GET['id']);

    // Suppression du participant dans la base de données
    if (isset($_POST['supprimer'])) {
        $suppression = supprimer_participant2($mysqli, $_GET, $_SESSION['login']);
                        
        if($suppression){
?>
            <script>alert('suppression du Participant effectuée avec succès !!!');</script>
            <?php header("Location:../participantListe.php");?>
<?php
        }
        else{
?>
            <script>alert('Echec lors de la suppression du participant !!!');</script>
<?php
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Manager Simplon</title>
        <link rel="stylesheet" type="text/css" href="../assets/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../assets/bootstrap/css/font-awesome.min.css">
        
        <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/stylesucces.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/styleSuppression.css">
        <!--link rel="stylesheet" type="text/css" href="../assets/css/styleParticipants.css"-->
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
                        <h3><strong>Suppression d'un participant</strong></h3>
                        <div class="bgContent">                          

                            <table width="600" border="1" cellspacing="0" cellpadding="5" class="table table-bordered">
                                <tr>
                                    <td class="entete">Nom</td>
                                    <td><?php echo $participant['nom'] ?></td>
                                </tr>
                                <tr>
                                    <td class="entete">Prénom(s)</td>
                                    <td><?php echo $participant['prenoms'] ?></td>
                                </tr>
                                <tr>
                                    <td class="entete">Telephone</td>
                                    <td><?php echo $participant['telephone'] ?></td>
                                </tr>
                                <tr>
                                    <td class="entete">Email</td>
                                    <td><?php echo $participant['email'] ?></td>
                                </tr>
                                <tr>
                                    <td class="entete">Pays</td>
                                    <td><?php echo recuperer_libelle_pays_from_id($mysqli, $participant['id_pays']) ?></td>
                                </tr>
                            </table>
                            <font color="red"><h4>Voulez-vous vraiment supprimer ce participant?</h4></font>
                            <form method="POST" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>
                                        <input type="submit" name="supprimer" value="Supprimer" class="btn btn-danger">
                                    </label>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
