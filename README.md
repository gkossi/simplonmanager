# simplonmanager

SIMPLON MANAGER est une application permettant de gérer les participants à un évènement donné.


# VOICI LES INSTRUCTIONS A SUIVRE POUR UTILISER L'APPLICATION

----------------------------------------------------------------------------------------------------------------------
DEPLOIEMENT
-----------
1. Base de données :
-Installer et configurer WampServer ou Xampp
-Accéder PHPMyAdmin et créer une données nommée : simplonmanager_db
-Créer un utilisateur (username : root, mot de passe : toor) et lui donner les droits nécessaires sur la base de données
créée.
-Importer la base de données associées au projet dont le script se trouve dans le dossier database

2. Fichiers
-Aller dans le dossier www (pour WampServer) et htdocs (pour Xampp)
-Copier et coller le répertoire contenant le projet Simplon Manager


----------------------------------------------------------------------------------------------------------------------
UTILISATION
-----------

# Comptes Utilisateurs :
- Compte Administrateur : Login : gkossi / Mot de passe : 1234 (Actif)
- Compte Utilisateur simple : Login : vivien / Mot de passe : 1234 (Actif)


# A/- GESTION DES UTILISATEURS
- Se connecter avec un compte administrateur et accéder à l'accueil
- Cliquer sur l'onglet "Gestion des utilisateur" pour accéder à l'espace d'administration des utilisateurs
- Opérations possible : Créer, modifier, réinitialiser, activer, désactiver et supprimer un compte utilisateur

# B/- GESTION DES PARTICIPANT
- Se connecter avec un compte administrateur et accéder à l'accueil
- Cliquer sur l'onglet "Gestion des participants" pour accéder à l'espace d'administration des participants
- Opérations possible : Créer, Rechercher, modifier et supprimer un participant

# C/- LISTES
- La liste des utilisateurs est accessible à partir de l'onglet "Gestion des utilisateur"
- La liste des participants est accessible à partir de l'onglet "Liste des participants"

# AUTRES
- Un utilisateur peut également changer son mot de passe à partir de l'onglet "Changer mon mot de passe"