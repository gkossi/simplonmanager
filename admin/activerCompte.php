<?php
    session_start();

	// L'utilisateur est-il connecté?
    if (!isset($_SESSION['login'])) {
        header("Location:../index.php");
    }

    require_once("../common_ressources/fonctions.php");    

	if(isset($_POST['activer'])) {

		$requete = "UPDATE utilisateurs SET compte_actif = '".true."' WHERE id ='".$_SESSION['id_utilisateur']."' ";
		
		// Mise à jour du bien dans la base
		$resultat=$mysqli->query($requete);
		header("Location:./gestionUtilisateur.php");
		}
		
		//---requete du menu déroulant
		$requete2 = "SELECT id, libelle FROM profils";
		$resultat2 = $mysqli->query($requete2);
		
		//---requete de la fiche modif
		$requete3 = "SELECT utilisateurs.id, nom, prenoms, login, id_profil, compte_actif, libelle FROM utilisateurs, profils WHERE utilisateurs.id_profil = profils.id AND login='".$_GET['login']."' ";
		$resultat3 = $mysqli->query($requete3);
		$user=$resultat3->fetch_array(MYSQLI_ASSOC);

		$_SESSION['id_utilisateur'] = $user['id'];
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
                        <h3 class="text-center"><strong>Activation de compte</strong></h3>
                        <div class="bgContent"> 

						<?php if ($user['compte_actif']) { ?>
                        <div class="form-group">
                            <label>Nom :
                                <input type="hidden" name="nom" value="<?php echo $user['nom']; ?>" class="form-control">
                                <?php echo $user['nom']; ?>
                            </label>
                        </div>

                        <div class="form-group">
                            <label>Prénoms :
                                <input type="hidden" name="prenoms" value="<?php echo $user['prenoms']; ?>" class="form-control">
                                <?php echo $user['prenoms']; ?>
                            </label>
                        </div>
                        </p>
                        <div class="form-group">
                            <label>Login :
                                <input type="hidden" name="login"  value="<?php echo $user['login']; ?>" class="form-control">
                                <?php echo $user['login']; ?>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Profil :
                                <input type="hidden" name="login"  value="<?php echo $user['login']; ?>" class="form-control">
                                <?php echo $user['libelle']; ?>
                            </label>
                        </div>
                        <?php echo "<font color=\"red\"><h3>Ce compte est déja activé</h3></font>";
                    } else {?>
                    <form enctype="multipart/form-data" method="POST" action="">
                        <div class="form-group">
                            <label>Nom :
                                <input type="hidden" name="nom" value="<?php echo $user['nom']; ?>" class="form-control">
                                <?php echo $user['nom']; ?>
                            </label>
                        </div>

                        <div class="form-group">
                            <label>Prénoms :
                                <input type="hidden" name="prenoms" value="<?php echo $user['prenoms']; ?>" class="form-control">
                                <?php echo $user['prenoms']; ?>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Login :
                                <input type="hidden" name="login"  value="<?php echo $user['login']; ?>" class="form-control">
                                <?php echo $user['login']; ?>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Profil :
                                <input type="hidden" name="login"  value="<?php echo $user['login']; ?>" class="form-control">
                                <?php echo $user['libelle']; ?>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                            <input type="submit" name="activer" value="Activer" class="btn btn-success">
                            </label>
                        </div>
                    </div>
                    </div>
                </div>
            </form>
                    <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
</html>
