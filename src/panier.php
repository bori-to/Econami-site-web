<?php session_start();

if(!isset($_SESSION['email'])){
	header('location:forum.php');
	exit;
}

//connexion à la bdd
include('include/db.php');
$q = 'SELECT * FROM users WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([$_SESSION['id']]);
$results = $req->fetch();
$panier = '';
if (isset($_COOKIE['panier']) && $_COOKIE['panier'] == 'a:0:{}') {

	$panier = unserialize($_COOKIE['panier']);
	
	$duree = 7 * 24 * 60 * 60;
	setcookie('panier', serialize($panier), (time() - $duree));
	unset($panier);
}


$title = 'Panier';
include('include/head.php');

if(isset($_SESSION['id'])){
	include('include/log.php');
	writeLog($title);
}
?>
	<link rel="stylesheet" type="text/css" href="css/style_achats.css">
	<link rel="stylesheet" type="text/css" href="css/styleforum.css">
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

			<div class="container-fluid"style="background-color: <?= $background_marronClaire?>;">
				<div class="container">
					<div class="row">
						<div class="col-md-9 col-xs-12">
							<div class="forum__body">
								<h2 class="forum__h1">Votre panier</h2>
								<div class="row">
									<div class="col-4"></div>
									<div class="col-4 text-center mt-4">
										<?php

										$prix = 0;
										
										if (isset($_COOKIE['panier'])) {
										    $panier = unserialize($_COOKIE['panier']);
										}
										if (isset($_COOKIE['panier']) && !empty($_COOKIE['panier'])) {
											$nb_pan = 0;	
											foreach($panier as $contenue){
												$prix = $prix + $contenue['prix'];
												$nb_pan = $nb_pan + 1;
												?>
												<a class="body__link__achat" href="achats_annonce.php?id=<?= $contenue['id'] ?>" id="body_annonce">
													<div class="body__achat">
														<p class="text-center body__montant">
															<?= $contenue['reduction'] . ' ' . $contenue['type'] ?>
															<br>
															<?= $contenue['marque'] ?>
														</p>
														<div class="body__pseudo">
															<i class="bi bi-person-fill"></i><?= $contenue['pseudo'] ?>
														</div>
														<div class="body__date">
															<i class="bi bi-calendar"></i><?= date_format(date_create($contenue['date_expiration']), 'd/m/Y') ?>
														</div>
														<div class="body__prix text-center">
															<?= $contenue['prix'] . ' €' ?>
														</div>
													</div>
												</a>

												<form method="post" action="panier_sppr.php" class="mb-4">
												    <?php if($nb_pan > 1){
												    	?>
												    <input type="hidden" name="panier" value="<?= htmlspecialchars(serialize($panier)) ?>">
												    <?php
												    }
												    ?>
												    <input type="hidden" name="id" value="<?= $contenue['id'] ?>">
												    <button type="submit" name="supprimer_annonce_<?= $contenue['id'] ?>" class="btn__suppr">Supprimer</button>
												</form>
												<?php
											}
										}



										?>
									</div>
									<div class="col-12">
										<div class="forum__accueil__line"></div>
										<?php
										if (isset($_COOKIE['panier'])) {
											$nb_articles = count($panier);
										}else{
											$nb_articles = 0;
										}

										?>
										<div>
											<h5 class="text-end">Sous-total (<?php echo $nb_articles;?>  <?php if($nb_articles > 1){echo 'articles';}else{echo 'article';}?>) : <?= $prix ?> €</h5>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-xs-12">
							<div class="forum__body">
								<h5>Sous-total (<?php echo $nb_articles;?>  <?php if($nb_articles > 1){echo 'articles';}else{echo 'article';}?>) : <br> <?= $prix ?> €</h5>
								<div class="forum__body__btn text-center">
									<a href="paiement.php" class="forum__btn__create" style="background-color: <?= $background_Jaune?>;">
										Passer la commande
									</a>
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