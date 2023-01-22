<?php
	require_once("./common_ressources/fonctions.php");
	session_start();

	if (isset($_POST['connexion'])) {
		$login = htmlentities(trim($_POST['login']));
		$password = htmlentities(trim($_POST['pass']));

		if ($login && $password){
			$password = md5($password);
			$data = connexion_administration($mysqli, $login, $password);

			// si on obtient une réponse, alors l'utilisateur est un membre
			if ($data['nb_users']=="1") {
				$user_etat = recuperer_utilisateur($mysqli, $_POST['login']);
				if($user_etat['compte_actif']){
					$_SESSION['login'] = $_POST['login'];
					header("Location:./accueil.php");
				} else {
					$erreur = 'Compte desactivé. Contactez l\'administrateur !';
				}
			}

			// si on ne trouve aucune réponse, l'utilisateur s'est trompé soit dans son login, soit dans son mot de passe
			elseif ($data['nb_users'] == "0") {
				$erreur = 'Mot de passe incorrect !';
			}

			// sinon, alors la, il y a un problème
			else {
				$erreur = 'Problème dans la base de données : plusieurs membres ont les mêmes identifiants de connexion.';
			}
		}
	} 
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Simplon Manager</title>
		<link rel="stylesheet" type="text/css" href="./assets/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="./assets/bootstrap/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="./assets/css/styleConnexion.css">
		<script type="text/javascript" src="./assets/js/jquery-1.10.2.js" ></script>
		<script type="text/javascript" src="./assets/bootstrap/js/bootstrap.js" ></script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="centrerFormulaire">
					<div>
						<h1 class="text-center">SIMPLON MANAGER</h1>
						<div class="login-panel text-center">
							<h3>Espace de connexion</h3>
							<?php if (isset($erreur)) echo "<div class='alert alert-danger'>".$erreur."</div>"; ?>

							<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
								<div class="form-group">
									<label>Login<font color="red">*</font> : </label>
									<input type="text" name="login" class="form-control" placeholder="Votre login" required>
								</div>
								<div class="form-group">
									<label>Mot de pass<font color="red">*</font> : </label>
									<input type="password" name="pass" class="form-control" placeholder="Votre mot de passe" required>
								</div>
								<div class="form-group">
									<input type="submit" name="connexion" value="connexion" class="btn btn-success">
								</div>
							</form>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
