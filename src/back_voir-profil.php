<?php session_start(); 
if(!isset($_SESSION['email']) || $_SESSION['type'] === '0'){
	header('location:index.php');
	exit;
}

//connexion à la bdd
include('include/db.php');
$q = 'SELECT * FROM users WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([$_POST['id']]);
$user_info = $req->fetch();

$chemin_avatar = null;

if(isset($user_info['image'])){
	$chemin_avatar = 'avatar/' .  $user_info['image'];
}else{
	$chemin_avatar = 'avatar/defaut/icon_profil.svg';
}
$avat = $chemin_avatar;
$title = 'Administrateur - Modifier utilisateur';
include('include/head.php');
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
				$background_btn = "#585A56";
				$border_btn = "#585A56";
			} else {
				$background_white = "white";
				$background_marron = "rgb(185, 168, 124)";
				$background_marronClaire = "rgba(185, 168, 124, 0.5)";
				$background_Jaune= "#DCD488";
				$background_btn = "#B9A87C";
				$border_btn = "#B9A87C";
			}
		}else{
			$background_white = "white";
			$background_marron = "rgb(185, 168, 124)";
			$background_marronClaire = "rgba(185, 168, 124, 0.5)";
			$background_Jaune= "#DCD488";
			$background_btn = "#B9A87C";
			$border_btn = "#B9A87C";
		}
	?>
	<body style="background-color: <?= $background_white?>;">
		<?php include 'include/header.php' ?>
		<main>

			<div class="container">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="back_admin.php">Accueil administrateur</a></li>
						<li class="breadcrumb-item"><a href="back_end.php">Utilisateurs</a></li>
						<li class="breadcrumb-item active" aria-current="page">Modifier</li>
					</ol>
				</nav>
				<div class="row">
					<div class="col-12">
						<h1>Profil de <?= $user_info['pseudo'] ?></h1>
					</div>
					<br>
					<h4>Informations :</h4>
					<p>
						Email : <b><?php echo $user_info['email'] ?></b> <br>
						Pseudo : <b><?php echo $user_info['pseudo'] ?></b> <br>
						Nom : <b><?php echo $user_info['nom'] ?></b> <br>
						Prenom : <b><?php echo $user_info['prenom'] ?></b> <br>
						Date de naissance : <b><?= date_format(date_create($user_info['age']), 'd/m/Y') ?></b> <br>
						Points : <b><?php echo $user_info['points'] ?></b> <br>
						Solde : <b><?php echo $user_info['solde'] ?> €</b> <br>
						Newsletter : <b><?php echo $user_info['newsletter'] ?></b> <br>
						Avatar : <b><?php echo $user_info['image'] ?></b> 
					</p>
					<div class="line"></div>
					<div class="row">
						<form method="post" action="back_verification_users.php" enctype="multipart/form-data">
							<div class="row">
							<div class="col-md-3 col-xs-12">
								Email :
								<input class="form-control" type="email" name="email" placeholder="email" value="<?php echo $user_info['email'] ?>">
							</div>
							<div class="col-md-3 col-xs-12">
								Pseudo :
								<input class="form-control" type="text" name="pseudo" placeholder="pseudo" value="<?php echo $user_info['pseudo'] ?>">
							</div>
							<div class="col-md-3 col-xs-12">
								Nom :
								<input class="form-control" type="text" name="nom" placeholder="nom" value="<?php echo $user_info['nom'] ?>">
							</div>
							<div class="col-md-3 col-xs-12">
								Prenom :
								<input class="form-control" type="text" name="prenom" placeholder="prenom" value="<?php echo $user_info['prenom'] ?>">
							</div>
							<div class="col-md-3 col-xs-12">
								Date de naissance :
								<input class="form-control" type="date" name="age" placeholder="age" value="<?= $user_info['age'] ?>" min="<?= date('Y-m-d', strtotime('-120 years')) ?>" max="<?= date('Y-m-d', strtotime('-13 years')) ?>" required>
							</div>
							<div class="col-md-3 col-xs-12">
								Points : €
								<input class="form-control" type="text" name="points" placeholder="points" value="<?php echo $user_info['points'] ?>">
							</div>
							<div class="col-md-3 col-xs-12">
								Solde : €
								<input class="form-control" type="text" name="solde" placeholder="solde" value="<?php echo $user_info['solde'] ?>">
							</div>
							<div class="col-md-3 col-xs-12">
								<?php
									if($user_info['newsletter'] === 'true'){
									?>
									<div class="form-check form-switch mt-4">
  										<input name="newsletter" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
  										<label class="form-check-label" for="flexSwitchCheckChecked">Newsletter</label>
									</div>
									<?php
									}else{
									?>
									<div class="form-check form-switch mt-4">
  										<input name="newsletter" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
  										<label class="form-check-label" for="flexSwitchCheckDefault">Newsletter</label>
									</div>
									<?php
									}
									?>
							</div>
							</form>
							<div class="col-6">
								Avatar :
								<div class="mb-2 mt-2">
									<img src="<?= $avat ?>" class="profil__avatar" width="150" height="150">
								</div>
							</div>
							<div class="col-12 mt-3">
								<button class="btn btn-primary" type="submit" id="button" name="id" value="<?php echo $user_info['id'] ?>">Modifier information</button>
							</div>
							</div>

						
						<div class="col-12 text-end mt-3">
							<form method="post" action="back_admin_verif.php" enctype="multipart/form-data">
							<?php
							if($user_info['type'] === '0' || $user_info['type'] === '2'){
								?>
								<button class="btn btn-primary" type="submit" id="button" name="id" value="<?php echo $user_info['id'] ?>">Devenir admin</button>
								<?php
							}else{
								?>
								<button class="btn btn-danger" type="submit" id="button" name="id" value="<?php echo $user_info['id'] ?>">Ne plus être admin</button>
								<?php
							}
							?>
							</form>
						</div>
					</div>
					<div><br><br></div>
				</div>
			</div>

		</main>

		<?php include 'include/footer.php' ?>
	</body>
	<script src="js/bootstrap.min.js"></script>
</html>

