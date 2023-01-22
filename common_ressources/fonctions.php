<?php

function connexion($serveur, $login, $pwd, $bd, $charset) {
    $mysqli = new mysqli($serveur, $login, $pwd, $bd);
    $mysqli->set_charset($charset);
    if ($mysqli->connect_errno) {
        echo "Echec lors de la connexion à MySQL : " . $mysqli->connect_error;
    }
    return $mysqli;
}

$mysqli = connexion("localhost", "gkossi", "toor142536", "simplonmanager_db", "utf8");


/* ---------- FONCTIONS POUR GESTION DEs COMPTES UTILISATEURS ---------- */
function connexion_administration($connexion, $login, $mot_de_passe) {
    $sql = 'SELECT count(*) AS nb_users FROM utilisateurs WHERE login="' . $login . '" AND mot_de_passe="' . $mot_de_passe . '"';
    $resultat = $connexion->query($sql);
    while ($row = $resultat->fetch_array(MYSQLI_ASSOC)) {
        $message = $row;
    }
    return $message;
}

function verification_profil($connexion, $login) {
    $sql = 'SELECT libelle FROM profils WHERE id = (SELECT id_profil FROM utilisateurs WHERE login = "' . $login . '")';
    $resultat = $connexion->query($sql);

    while ($row = $resultat->fetch_array(MYSQLI_ASSOC)) {
        $message = $row;
    }
    return $message;
}

function afficher_utilisateurs($connexion) {
    $sql = "SELECT nom, prenoms, login, libelle FROM utilisateurs, profils WHERE utilisateurs.id_profil = profils.id";
    $resultat = $connexion->query($sql);
    $messages = array();
    while ($row = $resultat->fetch_array(MYSQLI_ASSOC)) {
        $messages[] = $row;
    }
    return $messages;
}

function recuperer_utilisateur($connexion, $login) {
    $requete = "SELECT nom, prenoms, compte_actif, utilisateurs.id FROM utilisateurs, profils WHERE utilisateurs.id_profil=profils.id AND login='" . $login . "' ";
    $resultat = $connexion->query($requete);
    $utilisateur = $resultat->fetch_array(MYSQLI_ASSOC);
    return $utilisateur;
}

function recuperer_utilisateur_modifier($connexion, $login) {
    $sql = "SELECT utilisateurs.id, nom, prenoms, login, id_profil, libelle FROM utilisateurs, profils WHERE utilisateurs.id_profil = profils.id AND login='" . $login . "' ";
    $resultat = $connexion->query($sql);
    $messages = array();
    while ($row = $resultat->fetch_array(MYSQLI_ASSOC)) {
        $messages[] = $row;
    }
    return $messages;
}

function recuperer_mot_de_passe($connexion, $login){
	$requete = "SELECT mot_de_passe FROM utilisateurs WHERE login ='".$login."' ";
	$resultat = $connexion->query($requete);
    $utilisateur = $resultat->fetch_array(MYSQLI_ASSOC);
    return $utilisateur['mot_de_passe'];
}

function supprimer_utilisateur($connexion, $id_utilisateur) {
    $requete = "DELETE FROM utilisateurs WHERE id='" . $id_utilisateur . "' ";
    $connexion->query($requete);
}
/* ---------- FIN FONCTIONS POUR GESTION DEs COMPTES UTILISATEURS ---------- */


/* ---------- DEBUT FONCTIONS DE GESTION DES PARTICIPANTS ---------- */
function ajouter_participant($connexion, $donnees_participant, $login) {

    $nom = addslashes($donnees_participant['nom']);
    $prenom = addslashes($donnees_participant['prenom']);
    $requete = "INSERT INTO participants " . "SET "
            . "nom='" . $nom . "', "
			. "prenoms='" . $prenom . "', "
			. "email='" . $donnees_participant['email'] . "', "
			. "telephone='" . $donnees_participant['telephone'] . "', "
            . "date_creation=NOW(), "
            . "id_pays=" . recuperer_id_pays_from_libelle($connexion, $donnees_participant['pays']) . "";
    $insertion = $connexion->query($requete);
    return $insertion;
}

function recuperer_participants($connexion) {
    $sql = "SELECT * FROM participants ORDER BY nom";
    $resultat = $connexion->query($sql);
    $participants = array();
    while ($row = $resultat->fetch_array(MYSQLI_ASSOC)) {
        $participants[] = $row;
    }
    return $participants;
}

function recuperer_participant_par_id($connexion, $id) {
    $requete = "SELECT * FROM participants WHERE id = $id";
    $resultat = $connexion->query($requete);
    $participant = $resultat->fetch_array(MYSQLI_ASSOC);
    return $participant;
}

function maj_participant($connexion, $donnees_participant, $login) {
    $utilisateur = recuperer_utilisateur($connexion, $login);
    $requete = "UPDATE participants " . "SET "
            . "nom='" . $donnees_participant['nom'] . "', "
            . "prenoms='" . $donnees_participant['prenom'] . "', "
            . "email='" . $donnees_participant['email'] . "', "
            . "telephone='" . $donnees_participant['telephone'] . "', "
            . "date_modification=NOW(), "
            . "id_pays=" . recuperer_id_pays_from_libelle($connexion, $donnees_participant['pays']) . " "
            . "WHERE id = " . $donnees_participant['id'] . "";
    $maj = $connexion->query($requete);

    return $maj;
}

function supprimer_participant($connexion, $id) {
    $requete = "DELETE FROM participants WHERE id=" . $id . " ";
    $connexion->query($requete);
}

function supprimer_participant2($connexion, $donnees_participant, $login) {
    $utilisateur = recuperer_utilisateur($connexion, $login);
    $requete = "DELETE FROM participants WHERE id = " . $donnees_participant['id'] . "";
    $suppr = $connexion->query($requete);
    return $suppr;
}

function rechercherParticipant($connexion) {
    $nom = $_GET['nom'];
    $requete = "SELECT * FROM participants where nom ='$nom' ";
    $libPays=$_GET['pays'];
    
    if(!empty($libPays)){
        $idPays =recuperer_id_pays_from_libelle($connexion, $libPays);
        $requete .= "AND id_pays = $idPays ";
    }

    // éventuelle restriction de la recherche selon le prenom du participant
    if (!empty($_GET['prenom'])) {
    $prenom= $_GET['prenom'];
        $requete .= "AND prenoms ='$prenom' ";
    }
    
    // éventuelle restriction de la recherche selon le numéro de téléphone du participant
    if (!empty($_GET['telephone'])) {
        $telephone = $_GET['telephone'];
        $requete .= "AND telephone ='$telephone' ";
    }

    $resultat = $connexion->query($requete);
    $rech = array();
    while ($row = $resultat->fetch_array(MYSQLI_ASSOC)) {
        $rech[] = $row;
    }
    return $rech;
}
/* ---------- FIN FONCTIONS DE GESTION DES PARTICIPANTS ---------- */


/* ---------- FONCTIONS DE GESTION DES PAYS ---------- */
function recuperer_pays($connexion) {
    $sql = "SELECT * FROM pays";
    $resultat = $connexion->query($sql);
    $pays = array();
    while ($row = $resultat->fetch_array(MYSQLI_ASSOC)) {
        $pays[] = $row;
    }
    return $pays;
}

function recuperer_libelle_pays_from_id($connexion, $id) {
    $sql = "SELECT libelle from pays WHERE id = '$id'";
    $resultat = $connexion->query($sql);
    $libelle = $resultat->fetch_array(MYSQLI_ASSOC);
    return $libelle['libelle'];
}

function recuperer_id_pays_from_libelle($connexion, $libelle_pays) {
    $lib = addslashes($libelle_pays);
    $sql = "SELECT id from pays WHERE libelle = '$lib'";
    $resultat = $connexion->query($sql);
    $id = $resultat->fetch_array(MYSQLI_ASSOC);
    return $id['id'];
}

function recuperer_indicatif_pays_from_id($connexion, $id) {
    $sql = "SELECT indicatif from pays WHERE id = '$id'";
    $resultat = $connexion->query($sql);
    // var_dump($resultat);
    $indicatif = $resultat->fetch_array(MYSQLI_ASSOC);
    return $indicatif['indicatif'];
}
/* ---------- FIN FONCTIONS DE GESTION DES PAYS ---------- */

function rendre_propre($tableau) {
    $tableau_propre = array();
    foreach ($tableau as $key => $value) {
        if (!is_array($tableau[$key])) {
            $tableau_propre[$key] = htmlspecialchars($tableau[$key]);
        } else {
            $tableau_propre[$key] = $tableau[$key];
        }
    }
    return $tableau_propre;
}


?>
