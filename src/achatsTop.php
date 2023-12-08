<?php session_start();

//connexion à la bdd
include('include/db.php');
$q = 'SELECT a.*, u.pseudo, u.image, u.points FROM annonce a
INNER JOIN users u ON a.id_users = u.id
WHERE a.top = 1';
$req = $bdd->prepare($q);
$req->execute();
$top1 = $req->fetch();

$q = 'SELECT a.*, u.pseudo, u.image, u.points FROM annonce a
INNER JOIN users u ON a.id_users = u.id
WHERE a.top = 2';
$req = $bdd->prepare($q);
$req->execute();
$top2 = $req->fetch();

$q = 'SELECT a.*, u.pseudo, u.image, u.points FROM annonce a
INNER JOIN users u ON a.id_users = u.id
WHERE a.top = 3';
$req = $bdd->prepare($q);
$req->execute();
$top3 = $req->fetch();

$title = 'TOP';
include('include/head.php');

if(isset($_SESSION['id'])){
	include('include/log.php');
	writeLog($title);
}
?>
<link rel="stylesheet" type="text/css" href="css/style_achats.css">
<style>
	.list__topic__sujet{
		text-decoration: none;
	}
	.podium-container {
		padding-top: 100px;
		padding-bottom: 50px;
	}

	.podium-first {
		margin-top: -75px !important;
		z-index: 2;
	}

	.podium-second {
		margin-top: 50px !important;
	}

	.podium-third {
		margin-top: 100px !important;
	}

	.podium-medal {
		text-align: center;
		font-size: 2rem;
		width: 80px;
		height: 80px;
		line-height: 80px;
		border-radius: 50%;
		margin: 0 auto 20px auto;
	}

	.podium-gold {
		background-color: #ffd700;
		color: #000000;
		box-shadow: 0 0 20px #ffd700;
	}

	.podium-silver {
		background-color: #c0c0c0;
		color: #000000;
		box-shadow: 0 0 20px #c0c0c0;
	}

	.podium-bronze {
		background-color: #cd7f32;
		color: #000000;
		box-shadow: 0 0 20px #cd7f32;
	}

	.podium-content {
		background-color: #ffffff;
		border-radius: 5px;
		box-shadow: 0 0 20px #cccccc;
		text-align: center;
	}

	.podium-content h2 {
		font-size: 2rem;
		margin-bottom: 10px;
	}

	.podium-content p {
		font-size: 1.2rem;
	}
</style>
</head>
<?php
if(isset($_COOKIE['theme'])){
	if($_COOKIE["theme"] == "dark") {
		$background_white = "#454D67";
		$background_marron = "#92A7B0";
		$background_marronClaire = "#3B5D6B";
		$background_Jaune= "#92A7B0";
		$background_btnJaune= "#92A7B0";
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
<body style="background-color: <?php echo $background_white;?>;">
	<?php include 'include/header.php' ?>
	<main>

		<div class="container-fluid">
			<div class="container">
				<div class="row">
					<div class="col-12 mb-4" style="background-color: <?php echo $background_marronClaire;?>; border-radius: 10px;">
						<h1 class="text-center">
							<i class="bi bi-trophy"></i> Meilleures offres
						</h1>
					</div>
				</div>
				<div class="line mb-4"></div>

				<div class="col-3"></div>
			</div>

		</div>
		<div class="container podium-container">
			<div class="row">
				<?php 
					if($top2){ ?>
						<div class="col-4 podium-second">
							<div class="podium-medal podium-silver">
								<p class="fas fa-medal">2</p>
							</div>
							<a class="list__topic__sujet" href="achats_annonce.php?id=<?= $top2['id'] ?>">
								<div class="podium-content">
									<?php
									$chemin_avatar = null;

									if(isset($top2['image'])){
										$chemin_avatar = 'avatar/' .  $top2['image'];
									}else{
										$chemin_avatar = 'avatar/defaut/icon_profil.svg';
									}


									?>
									<div class="col-12">
										<div>
											<div class="body__link__achat" href="achats_annonce.php?id=<?= $top2['id'] ?>" id="body_annonce" style="margin-bottom: 0;">
												<div class="body__achat">
													<p class="text-center body__montant">
														<?= $top2['reduction'] . ' ' . $top2['type'] ?>
														<br>
														<?= $top2['marque'] ?>
													</p>
													<div class="body__pseudo" style="<?php if($top2['points'] >= 250){ ?>
														color: #DCD488;
														<?php
													}
													?>
													">
													<img src="<?= $chemin_avatar ?>" style="margin-right: 5px;" class="profil__avatar" width="16" height="16">
													<?= $top2['pseudo'] ?>
													</div>
													<div class="body__date">
														<i style="margin-right: 5px;" class="bi bi-calendar"></i><?= date_format(date_create($top2['date_expiration']), 'd/m/Y') ?>
													</div>
													<div class="body__prix text-center">
														<?= $top2['prix'] . ' €' ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>

						</div>
					<?php } else { ?>
						<div class="col-4 podium-second">
							<div class="podium-medal podium-silver">
								<p class="fas fa-medal">2</p>
							</div>
							<a class="list__topic__sujet">
								<div class="podium-content">
									<?php
									$chemin_avatar = 'avatar/defaut/icon_profil.svg';
									?>
									<div class="col-12">
										<div>
											<div class="body__link__achat" id="body_annonce" style="margin-bottom: 0;">
												<div class="body__achat">
													<p class="text-center body__montant">
														0 €
														<br>
														undefined
													</p>
													<div class="body__pseudo">
													<img src="<?= $chemin_avatar ?>" style="margin-right: 5px;" class="profil__avatar" width="16" height="16">
													user
													</div>
													<div class="body__date">
														<i style="margin-right: 5px;" class="bi bi-calendar"></i>01/01/2023
													</div>
													<div class="body__prix text-center">
														0 €
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>

						</div>
				<?php } ?>

				<?php 
					if($top1){ ?>

						<div class="col-4 podium-first">
							<div class="podium-medal podium-gold">
								<p class="fas fa-medal">1</p>
							</div>
							<a class="list__topic__sujet" href="achats_annonce.php?id=<?= $top1['id'] ?>">
								<div class="podium-content">
									<?php
									$chemin_avatar = null;

									if(isset($top1['image'])){
										$chemin_avatar = 'avatar/' .  $top1['image'];
									}else{
										$chemin_avatar = 'avatar/defaut/icon_profil.svg';
									}


									?>
									<div class="col-12">
										<div>
											<div class="body__link__achat" href="achats_annonce.php?id=<?= $top1['id'] ?>" id="body_annonce" style="margin-bottom: 0;">
												<div class="body__achat">
													<p class="text-center body__montant">
														<?= $top1['reduction'] . ' ' . $top1['type'] ?>
														<br>
														<?= $top1['marque'] ?>
													</p>
													<div class="body__pseudo" style="<?php if($top1['points'] >= 250){ ?>
														color: #DCD488;
														<?php
													}
													?>
													">
													<img src="<?= $chemin_avatar ?>" style="margin-right: 5px;" class="profil__avatar" width="16" height="16">
													<?= $top1['pseudo'] ?>
													</div>
													<div class="body__date">
														<i style="margin-right: 5px;" class="bi bi-calendar"></i><?= date_format(date_create($top1['date_expiration']), 'd/m/Y') ?>
													</div>
													<div class="body__prix text-center">
														<?= $top1['prix'] . ' €' ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>

						</div>
					<?php } else { ?>
						<div class="col-4 podium-first">
							<div class="podium-medal podium-gold">
								<p class="fas fa-medal">1</p>
							</div>
							<a class="list__topic__sujet">
								<div class="podium-content">
									<?php
									$chemin_avatar = 'avatar/defaut/icon_profil.svg';
									?>
									<div class="col-12">
										<div>
											<div class="body__link__achat" id="body_annonce" style="margin-bottom: 0;">
												<div class="body__achat">
													<p class="text-center body__montant">
														0 €
														<br>
														undefined
													</p>
													<div class="body__pseudo">
													<img src="<?= $chemin_avatar ?>" style="margin-right: 5px;" class="profil__avatar" width="16" height="16">
													user
													</div>
													<div class="body__date">
														<i style="margin-right: 5px;" class="bi bi-calendar"></i>01/01/2023
													</div>
													<div class="body__prix text-center">
														0 €
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>

						</div>
					<?php } ?>
				<?php 
					if($top3){ ?>
						<div class="col-4 podium-third">
							<div class="podium-medal podium-bronze">
								<p class="fas fa-medal">3</p>
							</div>
							<a class="list__topic__sujet" href="achats_annonce.php?id=<?= $top3['id'] ?>">
								<div class="podium-content">
									<?php
									$chemin_avatar = null;

									if(isset($top3['image'])){
										$chemin_avatar = 'avatar/' .  $top3['image'];
									}else{
										$chemin_avatar = 'avatar/defaut/icon_profil.svg';
									}


									?>
									<div class="col-12">
										<div>
											<div class="body__link__achat" href="achats_annonce.php?id=<?= $top3['id'] ?>" id="body_annonce" style="margin-bottom: 0;">
												<div class="body__achat">
													<p class="text-center body__montant">
														<?= $top3['reduction'] . ' ' . $top3['type'] ?>
														<br>
														<?= $top3['marque'] ?>
													</p>
													<div class="body__pseudo" style="<?php if($top3['points'] >= 250){ ?>
														color: #DCD488;
														<?php
													}
													?>
													">
													<img src="<?= $chemin_avatar ?>" style="margin-right: 5px;" class="profil__avatar" width="16" height="16">
													<?= $top3['pseudo'] ?>
													</div>
													<div class="body__date">
														<i style="margin-right: 5px;" class="bi bi-calendar"></i><?= date_format(date_create($top3['date_expiration']), 'd/m/Y') ?>
													</div>
													<div class="body__prix text-center">
														<?= $top3['prix'] . ' €' ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
					<?php } else { ?>
						<div class="col-4 podium-third">
							<div class="podium-medal podium-bronze">
								<p class="fas fa-medal">3</p>
							</div>
							<a class="list__topic__sujet">
								<div class="podium-content">
									<?php
									$chemin_avatar = 'avatar/defaut/icon_profil.svg';
									?>
									<div class="col-12">
										<div>
											<div class="body__link__achat" id="body_annonce" style="margin-bottom: 0;">
												<div class="body__achat">
													<p class="text-center body__montant">
														0 €
														<br>
														undefined
													</p>
													<div class="body__pseudo">
													<img src="<?= $chemin_avatar ?>" style="margin-right: 5px;" class="profil__avatar" width="16" height="16">
													user
													</div>
													<div class="body__date">
														<i style="margin-right: 5px;" class="bi bi-calendar"></i>01/01/2023
													</div>
													<div class="body__prix text-center">
														0 €
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>

						</div>
				<?php } ?>
			</div>
		</div>
	</main>

<?php include 'include/footer.php' ?>
</body>
<script src="js/bootstrap.min.js"></script>

