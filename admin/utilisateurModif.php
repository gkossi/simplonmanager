<?php
    session_start();

    // L'utilisateur est-il connecté?
    if (!isset($_SESSION['login'])) {
        header("Location:../index.php");
    }

    require_once("../common_ressources/fonctions.php");

    if(isset($_POST['modifier'])) {

        $nom = addslashes($_POST['nom']);
        $prenom = addslashes($_POST['prenoms']);
        $login = addslashes($_POST['login']);
        $requete = "UPDATE utilisateurs 
                    SET nom = '".$nom."', 
                        prenoms = '" .$prenom."', 
                        login = '".$login."', 
                        id_profil = '".$_POST['id_profil']."' 
                    WHERE id ='".$_SESSION['id_utilisateur']."' ";
        
        // Mise à jour du bien dans la base
        $resultat=$mysqli->query($requete);
        header("Location:./gestionUtilisateur.php");
    }
        
    //---requete du menu déroulant
    $requete2 = "SELECT id, libelle FROM profils";
    $resultat2 = $mysqli->query($requete2);
    
    //---requete de la fiche modif
    $requete3 = "SELECT utilisateurs.id, nom, prenoms, login, id_profil, libelle 
                FROM utilisateurs, profils 
                WHERE utilisateurs.id_profil = profils.id
                AND login='".$_GET['login']."' ";

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
							if(isset($_POST['modifier'])){
								if($_SESSION['resultat']>0){
							?>
									<p class = "alert alert-success"><strong>Modification de l'utilisateur effectée avec succès !</strong></p>
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
                                    <label>Nom<font color="red">*</font>: 
                                        <input type="text" name="nom" value="<?php echo $user['nom']; ?>" class="form-control" required>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Prénoms<font color="red">*</font>:
                                        <input type="text" name="prenoms" value="<?php echo $user['prenoms']; ?>" class="form-control" required>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Login<font color="red">*</font> :
                                        <input type="text" class="form-control" name="login"  value="<?php echo $user['login']; ?>" required>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Profil<font color="red">*</font> :
                                        <select name="id_profil" id="id_profil" class="form-control">
                                            <?php while($profils=$resultat2->fetch_array(MYSQLI_ASSOC)) {  ?>
                                                <option <?php if($profils['id']==$user['id_profil'])  echo "selected='selected'"; ?> value="<?php echo $profils['id']; ?>">
                                            <?php echo $profils['libelle']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </label>
                                </div>   
                                <p>
                                    <label>
                                    <input type="submit" name="modifier" value="Soumettre" class="btn btn-success">
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
