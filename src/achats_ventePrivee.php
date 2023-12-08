<?php session_start();

//connexion à la bdd
include('include/db.php');
$q = 'SELECT a.*, u.pseudo, u.image, u.points FROM annonce a
INNER JOIN users u ON a.id_users = u.id
WHERE a.valide = 3
ORDER BY date_creation ASC';
$req = $bdd->prepare($q);
$req->execute();
$ventes = $req->fetchAll();

$title = 'Ventes Privées';
include('include/head.php');

if(isset($_SESSION['id'])){
	include('include/log.php');
	writeLog($title);
}
?>
	<link rel="stylesheet" type="text/css" href="css/style_achats.css">
	<link rel="stylesheet" type="text/css" href="css/pagination.css">
	<link rel="stylesheet" type="text/css" href="css/styleindex.css">
	<link rel="stylesheet" type="text/css" href="css/styleforum.css">
	<link rel="stylesheet" type="text/css" href="css/paiement.css">
	<style type="text/css">
		.list__topic__sujet:hover{
			box-shadow: none;
			transition: all .5s ease;
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
								<i class="bi bi-shop-window"></i> Ventes Privées
							</h1>
						</div>
					</div>
					<div class="line mb-4"></div>
					<div class="row">
						<div class="col-3"></div>
						<div class="col-6" style="font-size: 1.2rem;">
							Bienvenues dans nos <b>Ventes Privées</b>, Seul les VIP peuvent y avoir droit.
							Les règles sont : <br>
							<i class="bi bi-arrow-right"></i> Premiers arrivés premiers servis <br>
							<i class="bi bi-arrow-right"></i> Coupon de réduction de qualité supérieure <br>
							<i class="bi bi-arrow-right"></i> Prix Réduit
						</div>
						<div class="col-3"></div>
					</div>
					<div class="row">
						<div class="col-12 mb-4">
							<?php

								foreach($ventes as $vente){
									$chemin_avatar = null;

									if(isset($vente['image'])){
										$chemin_avatar = 'avatar/' .  $vente['image'];
									}else{
										$chemin_avatar = 'avatar/defaut/icon_profil.svg';
									}

									if (date("Y-m-d H:i:s", time()) > $vente['date_creation']) { 
									?>
									<a class="list__topic__link" href="achats_annonce.php?id=<?= $vente['id'] ?>">
										<div class="list__topic__sujet" style="background-color: <?= $background_marronClaire?>;">
											<div class="row">
												<div class="col-8">
													<div>Date de mise en vente : <?= date_format(date_create($vente['date_creation']), 'd/m/Y à H:i') ?> 
													<br>Coupon : <?= $vente['marque'] ?> de <?= $vente['reduction'] . ' ' . $vente['type'] ?> 
													<br>Prix : <?= $vente['prix'] ?> €</div>
													<div class="list__topic__footer" style="font-size: 1rem;">
														<div>
															Admin : <?= $vente['pseudo'] ?>
															<img src="<?= $chemin_avatar ?>" class="profil__avatar" width="32" height="32">
														</div>
														<br>
													</div>
													<div class="text-center">
														<b>Disponible.</b>
													</div>
												</div>
												<div class="col-4">
													<div>
													  <div class="body__link__achat" href="achats_annonce.php?id=<?= $vente['id'] ?>" id="body_annonce" style="margin-bottom: 0;">
													    <div class="body__achat">
													      <p class="text-center body__montant">
													        <?= $vente['reduction'] . ' ' . $vente['type'] ?>
													        <br>
													        <?= $vente['marque'] ?>
													      </p>
													     <div class="body__pseudo" style="<?php if($vente['points'] >= 250){ ?>
						                                    color: #DCD488;
						                                    <?php
						                                    }
						                                    ?>
						                                    ">
						                                <img src="<?= $chemin_avatar ?>" style="margin-right: 5px;" class="profil__avatar" width="16" height="16">
						                                <?= $vente['pseudo'] ?>
						                                </div>
													      <div class="body__date">
													        <i style="margin-right: 5px;" class="bi bi-calendar"></i><?= date_format(date_create($vente['date_expiration']), 'd/m/Y') ?>
													      </div>
													      <div class="body__prix text-center">
													        <?= $vente['prix'] . ' €' ?>
													      </div>
													    </div>
													  </div>
													</div>
												</div>
											</div>
										</div>
									</a>
								<?php
									}else{
								?>
									<div class="list__topic__link">
										<div class="list__topic__sujet" style="background-color: #EDEAEA;">
											<div class="row">
												<div class="col-8">
													<div>Date de mise en vente : <?= date_format(date_create($vente['date_creation']), 'd/m/Y à H:i') ?> 
													<br>Coupon : <?= $vente['marque'] ?> de <?= $vente['reduction'] . ' ' . $vente['type'] ?> 
													<br>Prix : <?= $vente['prix'] ?> €</div>
													<div class="list__topic__footer" style="font-size: 1rem;">
														<div>
															Admin : <?= $vente['pseudo'] ?>
															<img src="<?= $chemin_avatar ?>" class="profil__avatar" width="32" height="32">
														</div>
													</div>
													<div class="text-center">
														<b>Pas encore disponible.</b>
													</div>
												</div>
												<div class="col-4">
													<div>
													  <div class="body__link__achat" href="achats_annonce.php?id=<?= $vente['id'] ?>" id="body_annonce" style="margin-bottom: 0;">
													    <div class="body__achat">
													      <p class="text-center body__montant">
													        <?= $vente['reduction'] . ' ' . $vente['type'] ?>
													        <br>
													        <?= $vente['marque'] ?>
													      </p>
													      <div class="body__pseudo" style="<?php if($vente['points'] >= 250){ ?>
						                                    color: #DCD488;
						                                    <?php
						                                    }
						                                    ?>
						                                    ">
						                                <img src="<?= $chemin_avatar ?>" style="margin-right: 5px;" class="profil__avatar" width="16" height="16">
						                                <?= $vente['pseudo'] ?>
						                                </div>
													      <div class="body__date">
													        <i class="bi bi-calendar"></i><?= date_format(date_create($vente['date_expiration']), 'd/m/Y') ?>
													      </div>
													      <div class="body__prix text-center">
													        <?= $vente['prix'] . ' €' ?>
													      </div>
													    </div>
													  </div>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php
									}
								}

								?>
						</div>
						<div class="col-12 mb-4">
							<button class="btn__link">
			                    <a href="point.php">VIP</a>
			                </button>
						</div>
					</div>
				</div>
			</div>
		
		</main>

		<?php include 'include/footer.php' ?>
	</body>
	<script src="js/bootstrap.min.js"></script>
</html>

