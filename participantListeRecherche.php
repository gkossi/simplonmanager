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

    require_once("common_ressources/fonctions.php");

    $pays = recuperer_pays($mysqli);

    if (isset($_GET['bouton_recherche'])) {
        $participants = rechercherParticipant($mysqli);
?>
        <script>alert($participants)</script>
<?php
    } else {
        $participants = recuperer_participants($mysqli);
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Simplon Manager</title>
        <link rel="stylesheet" type="text/css" href="./assets/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="./assets/bootstrap/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="./assets/css/dashboard.css">
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
                    <h1><strong>Liste des participants</strong></h1>
                    <hr>
                    <form id="formsearch" name="form" method="get" action="#">
                        <label> <input type="submit" name="bouton_recherche" value="Rechercher" class="btn btn-success"></label>
                        <label>Nom<font color="red">*</font> :<input type="text" name="nom" class="form-control" required></label>
                        <label>Prénom(s)<font color="red">*</font>:<input type="text" name="prenom" class="form-control"></label>

                        <label>Pays<font color="red">*</font> :
                            <select name="pays">
                                <?php
                                foreach ($pays as $paysInd) {
                                    ?>
                                    <option><?php echo $paysInd['libelle']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </label>

                        <label>Téléphone :<input type="text" name="telephone" class="form-control"></label>                                                
                    </form>

                    <!--a href="" class="btn btn-warning">Imprimer la liste</a-->                   

                    <hr>
                    <table width="" border="1" cellspacing="0" cellpadding="5" class="table table-bordered table-striped">
                        <tr>
                            <td>N°</td>
							<td>Nom</td>
                            <td>Prénoms</td>
                            <td>Téléphone</td>
                            <td>E-mail</td>
                            <td>Pays</td><td>Date Ajout</td>
                            <td>Date Modification</td>
                            <td>Signature</td>
                        </tr>
                        <?php
                            $nb=0;
                            foreach ($participants as $p) {
                                ?>
                                <tr>
                                    <td><?php echo ++$nb; ?> </td>
                                    <td><?php echo $p['nom'] ?></td>
                                    <td><?php echo $p['prenoms'] ?></td>
                                    <td>
                                        <?php
                                        $indicatif = recuperer_indicatif_pays_from_id($mysqli, $p['id_pays']);
                                        if ($indicatif != "") {
                                            echo $indicatif;
                                            echo "&nbsp;";
                                            echo $p['telephone'];
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $p['email'] ?></td>
                                    <td><?php echo recuperer_libelle_pays_from_id($mysqli, $p['id_pays']) ?></td>
                                    <td><?php echo $p['date_creation'] ?></td>
                                    <td><?php echo $p['date_modification'] ?></td>
                                    <td></td>
                                </tr>
                        <?php } ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>

        <!--?php include("footer.php"); ?-->
    </body>
</html>
