<?php
    session_start();

    // L'utilisateur est-il connecté?
    if (!isset($_SESSION['login'])) {
        header("Location:../index.php");
    }

    require_once("../common_ressources/fonctions.php");

	if(isset($_POST['reinitialiser'])){
		$_SESSION['resultat']=0;
		$mot_de_passe_actuel_saisi = $mysqli->real_escape_string($_POST['mot_de_passe_actuel']);
		$mot_de_passe = $mysqli->real_escape_string($_POST['mot_de_passe']);
		$mot_de_passe_repeter = $mysqli->real_escape_string($_POST['repeter_mot_de_passe']);
		$mot_de_passe_actuel_saisi = md5($mot_de_passe_actuel_saisi);
		$mot_de_passe_actuel=recuperer_mot_de_passe($mysqli, $_SESSION['login']);
		if($mot_de_passe_actuel_saisi==$mot_de_passe_actuel){
			if($mot_de_passe==$mot_de_passe_repeter){
				$mot_de_passe = md5($mot_de_passe);
				$requete = "UPDATE utilisateurs SET mot_de_passe = '".$mot_de_passe."' WHERE login ='".$_SESSION['login']."' ";
				$resultat=$mysqli->query($requete);
				$_SESSION['resultat']=1;
			}
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
                        <h3><strong>Réinitialisation de mot de passe</strong></h3>
                        <div class="bgContent">  

							<?php 
							if(isset($_POST['reinitialiser'])){
								if($_SESSION['resultat']>0){
							?>
									<p class = "alert alert-success"><strong>Votre mot de passe a bien été enregistré!</strong></p>
							<?php 
								}
								else {
							?>
									<p class = "alert alert-danger"><strong>Désolé!Votre enregistrement a échoué. Veuillez réessayer!</strong></p>
							<?php 
								} 
							}
							?>
							<form enctype="multipart/form-data" method="POST" action="">
								<div class="form-group">
									<label>Votre mot de passe actuel <font color="red">*</font> :
										<input type="password" class="form-control" name="mot_de_passe_actuel" placeholder="Mot de passe actuel" required>
									</label>
								</div>
								<div class="form-group">
									<label>Nouveau mot de passe <font color="red">*</font> :
										<input type="password" class="form-control" name="mot_de_passe" placeholder="Mot de passe" required>
									</label>
								</div>
								<div class="form-group">
									<label>Repéter le mot de passe <font color="red">*</font>:
										<input type="password" class="form-control" name="repeter_mot_de_passe" placeholder="Repéter le mot de passe" required>
									</label>
								</div>
								<div class="form-group">
									<label>
									<input type="submit" name="reinitialiser" value="Soumettre" class="btn btn-success">
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
