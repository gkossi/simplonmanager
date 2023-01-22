<?php
    session_start();

    require_once("../common_ressources/fonctions.php");
    $pays = recuperer_pays($mysqli);

    // L'utilisateur est-il connecté?
    if (!isset($_SESSION['login'])) {
        header("Location:../index.php");
    }


    // Sauvegarde du bien dans la base de données
    if (isset($_POST['ajout_participant'])) {
        $insertion = ajouter_participant($mysqli, $_POST, $_SESSION['login']);
        //var_dump($insertion);                           
        if($insertion){
?>
            <script>alert('Participant ajouté avec succès !!!');</script>
<?php
            header("Location:./participantGestion.php");
        }
        else{
?>
            <script>alert('Echec lors de l\'ajout !!!');</script>
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
        <!--link rel="stylesheet" type="text/css" href="../assets/css/styleAdmin.css"-->
        <link rel="stylesheet" type="text/css" href="../assets/css/stylesucces.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/styleAjout.css">
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
                        <h3 class="text-center"><strong>Création d'un nouveau participant</strong></h3>
                        <div class="bgContent"> 

                            <form method="POST" action="./participantAjout.php" enctype="multipart/form-data">
                                <p>
                                    <label>Nom<font color="red">*</font> :
                                        <input type="text" name="nom" class="form-control" required>
                                    </label>
                                </p>
                                <p>
                                    <label>Prénom(s)<font color="red">*</font>:
                                        <input type="text" name="prenom" class="form-control" required>
                                    </label>
                                </p>
                                <p>
                                    <label>Email<font color="red">*</font>:
                                        <input type="text" name="email" class="form-control" required>
                                    </label>
                                </p>

                                <p>
                                    <label>Pays<font color="red">*</font> :
                                        <select name="pays" required>
                                            <?php
                                            foreach ($pays as $paysInd) {
                                                ?>
                                                <option><?php echo $paysInd['libelle']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </p>
                                <p>
                                    <label>Téléphone :
                                        <input type="text" name="telephone" class="form-control">
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input type="submit" name="ajout_participant" value="Soumettre" class="btn btn-success">
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
