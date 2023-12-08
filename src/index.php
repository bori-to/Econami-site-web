<?php
$title = 'Accueil';
include('include/head.php');

if(isset($_SESSION['id'])){
	include('include/log.php');
	writeLog($title);
}
?>
		
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
		<div class="container-fluid tr" style="background-color: <?php echo $background_marronClaire;?>;">
			<div class="container reg largeurbloc flexbox" style="background-color: <?php echo $background_Jaune;?>;">
				<div class="row">
					<div class="col-8">
						<p class="slogan text-center">
						Ventes - Achats <br>Coupon de Réduction<br>
						<a href="index.php">
							<img src="images/econami2.png" alt="Logo econami" height="60px" class="sizeEconami">
						</a>
						</p>
					</div>
					<div class="col-4 text-center mt-4">
						<img class="img-fluid sizePiggy" src="images/piggy.svg" alt="Logo piggy" height="200px" width="230px" style="transform: rotate(2deg);">
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<p class="coupage text-center">
							<button type="button" class="btn btn-dark coupageB" style="background-color: <?= $background_btn ?>; border-color: <?= $border_btn ?>;"><a href="inscription.php" class="dropdown dropdown-item">Je m’inscris gratuitement</a></button>
						</p>
					</div>
				</div>
				<div class="row col-12">
					<div class="text-center">
						<p class="en1">
							<img src="images/pass.png" alt="pass" height="25px">
							Sans engagement
							<img src="images/pass.png" alt="pass" height="25px">
							Données sécurisées
							<img src="images/pass.png" alt="pass" height="25px">
							Gratuit
						</p>
					</div>
				</div>
			</div> 
		</div>
		<br>
		<br>
		<br>
		<div class="container-fluid trSizeOffre" style="background-color: <?php echo $background_marronClaire;?>;">
			<div class="container">
				<div class="row mb-4">
					<div class="col-12 text-center">
						<h2 class="mb-0">Nos Offres</h2>
						<div class="line"></div>
						<br>
						<h2 class="mb-0 mil">Des milliers d’offres de marchands particulier avec des réductions</h2>
					</div>
				</div>

				<?php include 'include/carousel.php' ?>
				
			</div>
		</div>

		<div class="container">
			<div class="row mb-2">
				<div class="col-12 text-center">
					<h2 class="mb-0">Vendre</h2>
					<div class="line"></div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row mb-4">
				<div class="col-lg-6 text-center"><img src="images/vendre4.png" class="img-fluid" style="border-radius: 20px; max-width: 75%;"></div>
				<div class="col-lg-6"><p class="sizeT">
					Comment faire pour vendre son coupon de réduction ? <br><br>
					Vous déposez une annonce pour vendre votre coupon. <br><br>Après la vente, vous récupérez <br>l'argent sur votre compte. <br><br>C’est aussi simple que ça :)
				</p>
				<br>
				<button type="button" class="btn btn-dark coupageB2" style="background-color: <?= $background_btn ?>; border-color: <?= $border_btn ?>;">
					<?php
					if(isset($_SESSION['email'])){
						?>
						<a href="vente.php" class="dropdown dropdown-item" style="font-size: 20px;font-weight: bold;">
						Je dépose mon annonce
						</a>
						<?php
					}else{
					?>
					<a href="connexion.php" class="dropdown dropdown-item" style="font-size: 20px;font-weight: bold;">
						Je dépose mon annonce
					</a>
					<?php
					}
					?>
				</button></div>
			</div>
		</div>
	</div>

		<div class="container-fluid trVip" style="background-color: <?php echo $background_marronClaire;?>;">
			<div class="container">
				<div class="row pb-4">
					<div class="col-12 text-center">
						<h2 class="mb-0">VIP</h2>
						<div class="line"></div>
						<br>
						<h2 class="mb-0 mil">Obtenez le VIP gratuitement au bout de 250 points sur votre compte !!</h2>
					</div>


					<div class="row py-5 row-cols-1 row-cols-lg-3">
						<div class="feature col">
							<div class="feature-icon d-inline-flex align-items-center justify-content-center bg-gradient fs-2 mb-3">
								<img class="bi" src="images/1.svg">
							</div>
							<h4>Chat général exclusif au vip</h4>
						</div>
						<div class="feature col">
							<div class="feature-icon d-inline-flex align-items-center justify-content-center bg-gradient fs-2 mb-3">
								<img class="bi" src="images/2.svg">
							</div>
							<h4>Ventes Privé organisé</h4>
						</div>
						<div class="feature col">
							<div class="feature-icon d-inline-flex align-items-center justify-content-center bg-gradient fs-2 mb-3">
								<img class="bi" src="images/3.svg">
							</div>
							<h4>Mettre en avant leurs annonces</h4>
						</div>
					</div>

					<div class="col-12 text-center">
						<h2 class="mb-0">1€ = 1pt</h2>
						<br>
						<button type="button" class="btn btn-dark coupageB3" style="background-color: <?= $background_btn ?>; border-color: <?= $border_btn ?>;">
							<?php
							if(isset($_SESSION['email'])){
								?>
								<a href="point.php" class="dropdown dropdown-item" style="font-size: 20px;font-weight: bold;">
									Accéder au VIP
								</a>
								<?php
							}else{
							?>
							<a href="connexion.php" class="dropdown dropdown-item" style="font-size: 20px;font-weight: bold;">
								Accéder au VIP
							</a>
							<?php
							}
							?>
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

