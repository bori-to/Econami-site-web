<?php session_start();

if(!isset($_SESSION['email'])){
	header('location:connexion.php');
	exit;
}

//connexion à la bdd
include('include/db.php');
$q = 'SELECT * FROM users WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([$_SESSION['id']]);
$user = $req->fetch();

if(!empty($_POST)){
	extract($_POST);

	if(isset($_POST['mdp'])){
		$valid = true;

		if(empty($_POST['mdp_actuel']) 
		|| empty($_POST['mdp_nv'])
		|| empty($_POST['mdp_conf'])
		|| !isset($_POST['mdp_actuel']) 
		|| !isset($_POST['mdp_nv']) 
		|| !isset($_POST['mdp_conf']) 
		){
			$valid = false;
			$msg = 'Vous devez remplir tous les champs obligatoire.';
			header('location:paramètres.php?type=danger&message=' . $msg);
			exit;
		}

		if(isset($_POST['mdp_actuel'])){

			if($_SESSION['password'] == $_POST['mdp_actuel']){
				$valid = false;
				$msg = 'Vous ne pouvez pas utiliser le même mot de passe.';
				header('location:paramètres.php?type=danger&message=' . $msg);
				exit;
			}

		}

		if(isset($_POST['mdp_nv'])){

			if(strlen($_POST['mdp_nv']) < 6 || strlen($_POST['mdp_nv']) > 12){
				$valid = false;
				$msg = 'Le mot de passe doit faire entre 6 à 12 caractères.';
				header('location:paramètres.php?type=danger&message=' . $msg);
				exit;
			}

			if($_POST['mdp_nv'] == $_POST['mdp_actuel']){
				$valid = false;
				$msg = "L'ancien et le nouveau mot de passe ne peuvent pas être pareille.";
				header('location:paramètres.php?type=danger&message=' . $msg);
				exit;
			}
		}

		if(isset($_POST['mdp_conf'])){

			if($_POST['mdp_conf'] != $_POST['mdp_nv']){
				$valid = false;
				$msg = 'La confirmation mot de passe ne correspond pas.';
				header('location:paramètres.php?type=danger&message=' . $msg);
				exit;
			}

		}


		if($valid){
			$q = 'UPDATE users SET password = ? WHERE id = ?';
			$req = $bdd->prepare($q);
			$req->execute([
				hash('sha512', $_POST['mdp_conf']),			
				$_SESSION['id']
			]);
			$msg = 'Mot de passe modifier avec succès';
			header('location:paramètres.php?type=success&message=' . $msg);
			exit;
		}
	}

	if(isset($_POST['suppr_compte'])){
		$valid = true;

		if(empty($_POST['mdp_suppr']) 
		|| !isset($_POST['mdp_suppr']) 
		){
			$valid = false;
			$msg = 'Vous devez entrer votre mot de passe.';
			header('location:paramètres.php?type=danger&message=' . $msg);
			exit;
		}

		if(isset($_POST['mdp_suppr'])){

			if($_SESSION['password'] != hash('sha512', $_POST['mdp_suppr'])){
				$valid = false;
				$msg = 'Mot de passe incorect.';
				header('location:paramètres.php?type=danger&message=' . $msg);
				exit;
			}

		}


		if($valid){

			$q = 'DELETE FROM commande WHERE id_users = ?';
			$req = $bdd->prepare($q);
			$req->execute([		
				$_SESSION['id']
			]);

			$q = 'DELETE FROM annonce WHERE id_users = ?';
			$req = $bdd->prepare($q);
			$req->execute([		
				$_SESSION['id']
			]);

			$q = 'DELETE FROM topic_commentaire WHERE id_users = ?';
			$req = $bdd->prepare($q);
			$req->execute([		
				$_SESSION['id']
			]);

			$q = 'DELETE FROM topic WHERE id_users = ?';
			$req = $bdd->prepare($q);
			$req->execute([		
				$_SESSION['id']
			]);

			$q = 'DELETE FROM users WHERE id = ?';
			$req = $bdd->prepare($q);
			$req->execute([		
				$_SESSION['id']
			]);

			session_destroy();

			$msg = 'Votre compte à étais supprimer avec succès, à bientôt ...';
			header('location:inscription.php?type=success&message=' . $msg);
			exit;
		}
	}
}

$title = 'Paramètres';
include('include/head.php');

if(isset($_SESSION['id'])){
	include('include/log.php');
	writeLog($title);
}
?>
	<link rel="stylesheet" type="text/css" href="css/styleforum.css">
	<link rel="stylesheet" type="text/css" href="css/style_achats.css">
	</head>
	<?php
		if(isset($_COOKIE['theme'])){
			if($_COOKIE["theme"] == "dark") {
				$background_white = "#454D67";
				$background_marron = "#92A7B0";
				$background_marronClaire = "#3B5D6B";
				$background_Jaune= "#92A7B0";
				$background_PAG= "#92A7B0";
				$background_btn = "#585A56";
				$border_btn = "#585A56";
			} else {
				$background_white = "white";
				$background_marron = "rgba(185, 168, 124)";
				$background_marronClaire = "rgba(185, 168, 124, 0.5)";
				$background_Jaune= "#DCD488";
				$background_btn = "#B9A87C";
				$border_btn = "#B9A87C";
			}
		}else{
			$background_white = "white";
			$background_marron = "rgba(185, 168, 124)";
			$background_marronClaire = "rgba(185, 168, 124, 0.5)";
			$background_Jaune= "#DCD488";
			$background_btn = "#B9A87C";
			$border_btn = "#B9A87C";
		}
	?>
	<body style="background-color: <?= $background_white?>;">
		<?php include 'include/header.php' ?>
		<main>

			<div class="container-fluid" style="background-color: <?= $background_marronClaire?>;">
				<div class="container">
					<div class="row forum__accueil__line">
						<div class="col-md-8 col-xs-12">
							<h1 class="forum__accueil__h1">
								Paramètres de <?= $user['pseudo'] ?>
							</h1>
							<div class="col-md-6 col-xs-12">
							<?php 

              				include('include/message.php');

              				?>
              				</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 col-xs-12">
							<div class="forum__body">
								<h2 style="margin-bottom: 0; padding-bottom: 10px;">Mot de passe</h2>
								<div class="line mb-2"></div>
								<div class="profil__info">
									<form method="post">
										<div class="mb-3">
											<label class="form-label">Mot de passe actuel</label>
											<input class="form-control" type="password" name="mdp_actuel" placeholder="Mot de passe actuel ...">
										</div>
										<div class="mb-3">
											<label class="form-label">Nouveau mot de passe</label>
											<input class="form-control" type="password" name="mdp_nv" placeholder="Nouveau mot de passe ...">
										</div>
										<div class="mb-3">
											<label class="form-label">Confirmation du nouveau mot de passe</label>
											<input class="form-control" type="password" name="mdp_conf" placeholder="Confirmation ...">
										</div>
										<div class="mb-3">
											<button type="submit" name="mdp" class="forum__btn__create" style="background-color: <?= $background_Jaune ?>;">
												<i class="bi bi-key"></i> Modifier mon mot de passe
											</button>
										</div>
									</form>
								</div>	
							</div>

						</div>
						<div class="col-md-6 col-xs-12">
							<div class="forum__body">
								<button type="button" class="forum__btn__create" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background-color: <?= $background_Jaune ?>;">
								  <i class="bi bi-exclamation-circle"></i> Supprimer mon compte
								</button>

								<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								    	<div class="modal-header">
								        	<h1 class="modal-title fs-5" id="exampleModalLabel">Supprimer mon compte</h1>
								        	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								      	</div>
								      	<div class="modal-body">
								      		<p>
										Cher <?= $_SESSION['pseudo'] ?>, <br><br>

										Nous souhaitons vous informer que si vous choisissez de supprimer toutes les traces de votre présence sur notre site, cela sera effectué de manière <b>permanente</b> et <b>irréversible</b>. Cela signifie que <b>toutes les informations, données et activités associées à votre compte seront supprimées et ne pourront plus être récupérées</b>. <br><br>

										Nous comprenons que cette décision peut être importante pour vous, mais nous voulons vous rappeler que la suppression de votre compte peut avoir des conséquences sur votre utilisation future de notre site. Par exemple, <b>si vous souhaitez réactiver votre compte à l'avenir, vous devrez créer un nouveau compte et recommencer à zéro</b>. <br><br>

										Nous vous encourageons à réfléchir soigneusement avant de prendre une décision de ce genre, et à contacter notre équipe de support si vous avez des questions ou des préoccupations. <br><br>

										Merci de votre compréhension. <br><br>

										Cordialement, <br>
										Econami
									</p>
								      		<form method="post">
								      			<label class="form-label">Mot de passe</label>
								      			<input class="form-control" type="password" name="mdp_suppr" placeholder="Mot de passe ...">
								      	</div>
								      	<div class="modal-footer">
								      		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
								      		<button type="submit" name="suppr_compte" class="btn btn-danger">
								      			<i class="bi bi-exclamation-circle"></i> Supprimer mon compte
								      		</button>
								      	</div>
								      		</form>
								    </div>
								  </div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

		</main>

		<?php include 'include/footer.php' ?>
	</body>
	<script src="js/bootstrap.min.js"></script>
</html>