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

$points_restant = 250 - ($results['points']);


$title = 'VIP';
include('include/head.php');
?>
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
	<style> 
		body { overflow-x: hidden; }

		.arrow-icon {
			font-size: 100px;
			margin-top: 10px; 
		}


		.regi{
			transform: rotate(-2deg);
			border-radius: 20px;
			margin-top: 0px;
			margin-bottom: -60px;
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		.bg-primary {
			background-color: #dcd488 !important;
		}

/*.bg-secondary {
    background-color: rgba(185, 168, 124, 0.5) !important;
}*/


@media screen and (max-width: 991px) {
	.trVip{
		height: 675px;
		line-height: 30px;
	}


	.row {
		width: 100%;
	}


}

@media screen and (max-width: 800px) {

	.slogan {
		font-size: 35px;
	}
}

@media screen and (max-width: 600px) {
	.slogan {
		font-size: 25px;
	}
	.arrow-icon {
		font-size: 70px;
	}
	.message {
		font-size: 1em;
	}
} 

</style>

<main>
	<div class="container-fluid d-flex align-items-center justify-content-center" style="background-color: <?= $background_marronClaire?>;">
		<div class="container">
			<div class="row">
				<div class="row text-center p-3 bg-white" style="border-radius:20px; margin-top: 20px; margin-left: 1.2px;"> 
					<div class="col-4 d-flex align-items-center justify-content-center">
						Votre nombre de points 
						<span class="badge bg-primary rounded-pill"> <?= $results['points'] ?>
						</span>
					</div>
					<div class="col-4 d-flex align-items-center justify-content-center">
						<div class="row">
							<div class="col-12">
								<?php if($results['points'] < 250){
									echo '<h5 class="mb-0 message">POINTS RESTANTS POUR PASSER VIP : '.$points_restant.'</h5>';
								} else {
									echo '<h5 class="mb-0 message">Bravo Vous êtes VIP !</h5>';
								}
								?>
							</div>
							<div class="col-12">
								<i class="bi bi-arrow-right arrow-icon"></i>
							</div>
						</div>
					</div>
					<div class="col-4 d-flex align-items-center justify-content-center">
						Points nécessaires pour passer VIP 
						<span class="badge bg-secondary rounded-pill"> 250
						</span>
					</div>
					<div class="progress" style="padding: 0;">
						<div class="progress-bar bg-primary" role="progressbar" style="width: <?= $results['points']/2.5 ?>%" aria-valuenow="<?= $results['points'] ?>" aria-valuemin="0" aria-valuemax="250"></div>
					</div>

				</div>
			</div>
			<p class="slogan text-center" style="transform: rotate(0deg);">Comment obtenir des points ?</p>
			<div class="col-12 d-flex justify-content-center">
				<i class="bi bi-arrow-down-circle-fill arrow-icon"></i>
			</div>

		</div>
	</div>
</div>

<div class="container regi" style="background-color: <?= $background_Jaune?>;">
	<div class="row d-incline-flex">
		<div style="transform:rotate(2deg)">
			<h4 class="text-center fw-bold"></br>Ils existent 2 façons d'obtenir des points :</h4>
			<div class="row justify-content-center">
				<div class="col-12 col-md-6 col-lg-4 mb-3">
					<div class="card border-0 shadow">
						<a href="vente.php" style="text-decoration: none; color: black;">
							<div class="card-body">
								<h5 class="card-title fw-bold"><i class="bi bi-bag-check me-2"></i>Vendre des coupons</h5>
								<p class="card-text">À chaque vente, vous obtiendrez des points à hauteur de 1€ = 1 point. Plus vous vendez, plus vous gagnez de points !</p>
							</div>
							<div class="card-footer bg-white border-0 text-end">
								<small class="text-muted">Cliquez pour commencer à vendre</small>
							</div>
						</a>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-4 mb-3">
					<div class="card border-0 shadow">
						<a href="achats.php" style="text-decoration: none; color: black;">
							<div class="card-body">
								<h5 class="card-title fw-bold"><i class="bi bi-credit-card-2-front me-2"></i>Acheter des coupons</h5>
								<p class="card-text">À chaque achat, vous obtiendrez des points à hauteur de 1€ = 1 point. Cela signifie que plus vous achetez, plus vous gagnez de points !</p>
							</div>
							<div class="card-footer bg-white border-0 text-end">
								<small class="text-muted">Cliquez pour commencer à acheter</small>
							</div>
						</a>
					</div>
				</div>
			</div>
			<p class="text-center lh-lg mt-4">
				N'oubliez pas que les points que vous gagnez peuvent être utilisés pour bénéficier d'<a href="AvantageVip.php" style="text-decoration: none; color: black;"><strong>avantages exclusifs</strong></a> sur notre site !
			</p>
			<p class="text-center lh-lg mt-4">
				Alors n'attendez plus pour vendre et acheter des coupons et cumuler des points pour profiter au maximum de notre site !</br></br>
			</p>
		</div>
	</div>
</div>



		<br>
		<br>
		<br>

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

