<?php
    session_start();

    // L'utilisateur est-il connecté?
    if (!isset($_SESSION['login'])) {
        header("Location:../index.php");
    }

    require_once("../common_ressources/fonctions.php");

    $pays = recuperer_pays($mysqli);
    $participant = recuperer_participant_par_id($mysqli, $_GET['id']);

    // Sauvegarde du bien dans la base de données
    if (isset($_POST['maj_participant'])) {
        $maj = maj_participant($mysqli, $_POST, $_SESSION['login']);                    
        if($maj){
?>
            <script>alert('Modification du Participant effectuée avec succès !!!');</script>
<?php
            header("Location:./participantGestion.php");
        }
        else{
?>
            <script>alert('Echec lors de la modification du participant !!!');</script>
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
        <link rel="stylesheet" type="text/css" href="../assets/css/styleModification.css">
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
                        <h3><strong>Modification d'un participant</strong></h3>
                        <div class="bgContent">  

                            <form method="POST" action="#" enctype="multipart/form-data">
                                <p>
                                    <label>Nom :
                                        <input type="text" name="nom" value="<?php echo $participant['nom']; ?>" class="form-control">
                                        <input type="hidden" name="id" value="<?php echo $participant['id']; ?>" class="form-control">
                                    </label>
                                </p>
                                <p>
                                    <label>Prénom(s) :
                                        <input type="text" name="prenom" value="<?php echo $participant['prenoms']; ?>" class="form-control">
                                    </label>
                                </p>
                                <p>
                                    <label>Téléphone :
                                        <input type="text" name="telephone" value="<?php echo $participant['telephone']; ?>" class="form-control">
                                    </label>
                                </p>
                                <p>
                                    <label>Email :
                                        <input type="text" name="email" value="<?php echo $participant['email']; ?>" class="form-control">
                                    </label>
                                </p>
                                <p>
                                    <label>Pays :
                                        <select name="pays">
                                            <?php
                                            foreach ($pays as $paysInd) {
                                            ?>
                                            <option 
                                                <?php
                                                    $libPaysParticipant = recuperer_libelle_pays_from_id($mysqli, $participant['id_pays']);
                                                    if($paysInd['libelle'] == $libPaysParticipant) {echo 'selected';} 
                                                ?> 
                                            >
                                            <?php 
                                                echo $paysInd['libelle']; 
                                            ?>
                                            </option>
                                        <?php
                                            }
                                        ?>
                                        </select>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input type="submit" name="maj_participant" value="Soumettre" class="btn btn-success">
                                    </label>
                                </p>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
