<?php session_start();
$title = 'Editer mon profil';
include('include/head.php');

if(!isset($_SESSION['email'])){
	header('location:connexion.php');
	exit;
}

include('include/db.php');

$q = 'SELECT * FROM users WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([$_SESSION['id']]);
$user = $req->fetch();

if(!empty($_POST)){
	extract($_POST);

	$valid = true;

	if(empty($_POST['email']) 
	|| empty($_POST['pseudo'])
	|| empty($_POST['nom'])
	|| empty($_POST['prenom']) 
	|| !isset($_POST['email']) 
	|| !isset($_POST['pseudo']) 
	|| !isset($_POST['nom']) 
	|| !isset($_POST['prenom']) 
	){
		$valid = false;
		$msg = 'Vous devez remplir tous les champs obligatoire.';
		header('location:profil_editer.php?type=danger&message=' . $msg);
		exit;
	}

	if(isset($_POST['email'])){


		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$valid = false;
			$msg = 'email invalide';
			header('location:profil_editer.php?type=danger&message=' . $msg);
			exit;
		}

		// Si email existe déjà en bdd : redirection vers le formulaire
		$q = 'SELECT id FROM users WHERE email = :email ';
		$req = $bdd->prepare($q);
		$req->execute(['email' => $_POST['email']]);
		$results = $req->fetchAll();
		if(!empty($results) && $_POST['email'] !== $_SESSION['email']){
			$valid = false;
			$msg = 'email déjà utilisée';
			header('location:profil_editer.php?type=danger&message=' . $msg);
			exit;
		}

		if($valid){

			$q = 'UPDATE users SET email = ? WHERE id = ?';
			$req = $bdd->prepare($q);
			$req->execute([			
				$_POST['email'],
				$_SESSION['id']
			]);
		}
	}

	if(isset($_POST['pseudo'])){


		// Si pseudo existe déjà en bdd : redirection vers le formulaire
		$q = 'SELECT id FROM users WHERE pseudo = :pseudo ';
		$req = $bdd->prepare($q);
		$req->execute(['pseudo' => $_POST['pseudo']]);
		$results = $req->fetchAll();
		if(!empty($results) && $_POST['pseudo'] !== $user['pseudo']){
			$valid = false;
			$msg = 'pseudo déjà pris.';
			header('location:profil_editer.php?type=danger&message=' . $msg);
			exit;
		}

		if($valid){

			$q = 'UPDATE users SET pseudo = ? WHERE id = ?';
			$req = $bdd->prepare($q);
			$req->execute([			
				$_POST['pseudo'],
				$_SESSION['id']
			]);

		}
	}

	if(isset($_POST['nom'])){


		if(preg_match('/\d/', $_POST['nom'])){
			$valid = false;
			$msg = 'Nom invalide';
			header('location:profil_editer.php?type=danger&message=' . $msg);
			exit;
		}

		if($valid){

			$q = 'UPDATE users SET nom = ? WHERE id = ?';
			$req = $bdd->prepare($q);
			$req->execute([			
				$_POST['nom'],
				$_SESSION['id']
			]);

		}
	}

	if(isset($_POST['prenom'])){


		if(preg_match('/\d/', $_POST['prenom'])){
			$valid = false;
			$msg = 'Prenom invalide';
			header('location:profil_editer.php?type=danger&message=' . $msg);
			exit;
		}

		if($valid){

			$q = 'UPDATE users SET prenom = ? WHERE id = ?';
			$req = $bdd->prepare($q);
			$req->execute([			
				$_POST['prenom'],
				$_SESSION['id']
			]);

		}
	}

	if(isset($_POST['age']) && !empty($_POST['age'])){

		$dt = time();
		$time = date( "Y-m-d H:i:s", $dt );

		if($_POST['age'] > $time){
			$valid = false;
			$msg = 'Date de naissance invalide';
			header('location:profil_editer.php?type=danger&message=' . $msg);
			exit;
		}

		if($valid){

			$_SESSION['age'] = $_POST['age'];

			$q = 'UPDATE users SET age = ? WHERE id = ?';
			$req = $bdd->prepare($q);
			$req->execute([			
				$_POST['age'],
				$_SESSION['id']
			]);

		}
	}

	if ($_POST['newsletter'] == 'on') {
		if($valid){

			$q = 'UPDATE users SET newsletter = ? WHERE id = ?';
			$req = $bdd->prepare($q);
			$req->execute([			
				'true',
				$_SESSION['id']
			]);

		}
	}else{
		if($valid){

			$q = 'UPDATE users SET newsletter = ? WHERE id = ?';
			$req = $bdd->prepare($q);
			$req->execute([			
				'false',
				$_SESSION['id']
			]);

		}
	}


	if($valid){
		$msg = 'Compte modifier avec succès';
		header('location:profil.php?type=success&message=' . $msg);
		exit;
	}
}

if(isset($_SESSION['id'])){
	include('include/log.php');
	writeLog($title);
}

?>
<link rel="stylesheet" type="text/css" href="css/styleforum.css">
    <?php
if (isset($_COOKIE['theme'])) {
    if ($_COOKIE["theme"] == "dark") {
        $background_white = "#454D67";
        $background_marron = "#92A7B0";
        $background_marronClaire = "#3B5D6B";
        $background_Jaune = "#92A7B0";
        $background_PAG = "#92A7B0";
        $background_btn = "#585A56";
        $border_btn = "#585A56";
    } else {
        $background_white = "white";
        $background_marron = "rgba(185, 168, 124)";
        $background_marronClaire = "rgba(185, 168, 124, 0.5)";
        $background_Jaune = "#DCD488";
        $background_btn = "#B9A87C";
        $border_btn = "#B9A87C";
    }
} else {
    $background_white = "white";
    $background_marron = "rgba(185, 168, 124)";
    $background_marronClaire = "rgba(185, 168, 124, 0.5)";
    $background_Jaune = "#DCD488";
    $background_btn = "#B9A87C";
    $border_btn = "#B9A87C";
}
?>
	</head>
	<body style="background-color: <?= $background_white ?>;">
		<?php include 'include/header.php' ?>
		<main>

		<div class="container-fluid" style="background-color: <?= $background_marronClaire ?>;">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-xs-0"></div>
					<div class="col-md-6 col-xs-12">
						<h1>Editer mon profil</h1>
						<?php 

              				include('include/message.php');

              			?>
					<form method="post">
						<div class="mb-3">
							<label class="form-label">Email</label>
							<input class="form-control" type="text" name="email" value="<?php if(isset($user['email'])){ echo htmlspecialchars($user['email']); }else{ echo htmlspecialchars($user['email']); } ?>" placeholder="email">
						</div>
						<div class="mb-3">
							<label class="form-label">Pseudo</label>
							<input class="form-control" type="text" name="pseudo" value="<?php if(isset($user['pseudo'])){ echo htmlspecialchars($user['pseudo']); }else{ echo htmlspecialchars($user['pseudo']); } ?>" placeholder="pseudo">
						</div>
						<div class="mb-3">
							<label class="form-label">Nom</label>
							<input class="form-control" type="text" name="nom" value="<?php if(isset($user['nom'])){ echo htmlspecialchars($user['nom']); }else{ echo htmlspecialchars($user['nom']); } ?>" placeholder="nom">
						</div>
						<div class="mb-3">
							<label class="form-label">Prenom</label>
							<input class="form-control" type="text" name="prenom" value="<?php if(isset($user['prenom'])){ echo htmlspecialchars($user['prenom']); }else{ echo htmlspecialchars($user['prenom']); } ?>" placeholder="prenom">
						</div>
						<div class="mb-3">
							<label class="form-label">Date de naissance</label>
							<?php
							if(!isset($_SESSION['age'])){
								?>
								<input class="form-control" type="date" name="age" value="<?php if(isset($_SESSION['age'])){ echo $_SESSION['age']; }else{ echo htmlspecialchars($_SESSION['age']); } ?>" placeholder="age" max="<?= date('Y-m-d', strtotime('-13 years')) ?>" min="<?= date('Y-m-d', strtotime('-120 years')) ?>">
								<?php
							}else{
								?>
								<div><?= date_format(date_create($_SESSION['age']), 'd/m/Y') ?></div>
								<?php
							}
							?>
						</div>
						<div class="mb-3">
							<?php
									if($user['newsletter'] === 'true'){
									?>
									<div class="form-check form-switch">
  										<input name="newsletter" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
  										<label class="form-check-label" for="flexSwitchCheckChecked">Newsletter</label>
									</div>
									<?php
									}else{
									?>
									<div class="form-check form-switch">
  										<input name="newsletter" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
  										<label class="form-check-label" for="flexSwitchCheckDefault">Newsletter</label>
									</div>
									<?php
									}
									?>
						</div>
						<div class="mb-3">
							<button type="submit" name="modification" class="forum__btn__create" style="background-color: <?= $background_Jaune ?>;">Modifier mon profil</button>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
		
		</main>

		<?php include 'include/footer.php' ?>
	</body>
	<script src="js/bootstrap.min.js"></script>
</html>