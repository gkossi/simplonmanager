<?php
    session_start();

	// L'utilisateur est-il connecté?
    if (!isset($_SESSION['login'])) {
        header("Location:../index.php");
    }

    require_once("../common_ressources/fonctions.php");    

	if(isset($_POST['ajouter'])) {
		$nom = $mysqli->real_escape_string($_POST['nom']);
		$prenoms = $mysqli->real_escape_string($_POST['prenoms']);
		$login = $mysqli->real_escape_string($_POST['login']);
		$mot_de_passe = $mysqli->real_escape_string($_POST['mot_de_passe']);
		$mot_de_passe_repeter = $mysqli->real_escape_string($_POST['repeter_mot_de_passe']);
		if($mot_de_passe==$mot_de_passe_repeter){
			$mot_de_passe = md5($mot_de_passe);
			$requete = "insert into utilisateurs(nom,prenoms,login,mot_de_passe,id_profil) values('".$nom."', '".$prenoms."', '".$login."','".$mot_de_passe."','".$_POST['id_profil']."')";
			$insertion = $mysqli->query($requete);
			header("Location:./gestionUtilisateur.php");
		}else{
			echo "Les deux mots de passe doivent être identiques";
		}
	}

	$requete2 = "SELECT id, libelle FROM profils";
	$resultat2 = $mysqli->query($requete2);
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
                        <h3 class="text-center"><strong>Création d'un nouveau utilisateur</strong></h3>
                        <div class="bgContent"> 

							<form enctype="multipart/form-data" method="POST" action="">
								<div class="form-group">
									<label>Nom<font color="red">*</font> : 
										<input type="text" class="form-control" name="nom" placeholder="Nom de l'utilisateur" required>
									</label>
								</div>

								<div class="form-group">
									<label>Prénoms<font color="red">*</font> : 
										<input type="text" class="form-control" name="prenoms" placeholder="Prénom de l'utilisateur" required>
									</label>
								</div>
								<div class="form-group">
									<label>Login<font color="red">*</font> : 
										<input type="text" class="form-control" name="login" placeholder="Login de l'utilisateur" required>
									</label>
								</div>
								<div class="form-group">
									<label>Mot de passe<font color="red">*</font> : 
										<input type="password" class="form-control" name="mot_de_passe" placeholder="Mot de passe" required>
									</label>
								</div>
								<div class="form-group">
									<label>Repéter le mot de passe<font color="red">*</font> :
										<input type="password" class="form-control" name="repeter_mot_de_passe" placeholder="Repéter le mot de passe" required>
									</label>
								</div>
								<div class="form-group">
									<label>Profil<font color="red">*</font> : 
									<select name="id_profil" id="id_profil" class="form-control">
									<?php while($profils=$resultat2->fetch_array(MYSQLI_ASSOC)) {  ?>
										<option value="<?php echo $profils['id']; ?>">
											<?php echo $profils['libelle']; ?>
										</option>
									<?php } ?>
									</select>
									</label>
								</div>   
								<p>
									<label>
									<input type="submit" name="ajouter" value="Soumettre" class="btn btn-success">
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
