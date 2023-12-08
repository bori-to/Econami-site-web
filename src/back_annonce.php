<?php session_start(); 
if(!isset($_SESSION['email']) || $_SESSION['type'] === '0'){
	header('location:index.php');
	exit;
}
//connexion à la bdd
include('include/db.php');
$q = 'SELECT a.*, u.pseudo 
FROM annonce a
INNER JOIN users u on u.id = a.id_users
ORDER BY a.date_creation DESC;
';
$req = $bdd->prepare($q);
$req->execute();

$req_annonce = $req->fetchAll();

$title = 'Administrateur - Annonces';
include('include/head.php');
?>
<link rel="stylesheet" type="text/css" href="css/style_achats.css">
<link rel="stylesheet" type="text/css" href="css/styleforum.css">
<script src="js/back_fitre_annonce.js"></script>
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
					<li class="breadcrumb-item active" aria-current="page">Annonces</li>
					<li style="margin-left: 200px;">
						<?php 

						include('include/message.php');

						?>
					</li>
				</ol>
			</nav>
			<div class="row">
				<div class="col-3">
					<h1>Annonces</h1>
				</div>
				<div class="col-md-9 col-12 btn__back__non-valide" id="annonce">
					<div class="row">
						<div class="col-6 col-md-3 mb-2">
							<button class="me-5" id="btn-trier-offValide">Annonces non-valide</button>
						</div>
						<div class="col-6 col-md-3 mb-2">
							<button class="me-5" id="btn-trier-valide">Annonces valide</button>
						</div>
						<div class="col-6 col-md-3 mb-2">
							<button class="me-5" id="btn-trier-vendus">Annonces vendus</button>
						</div>
						<div class="col-6 col-md-3 mb-2">
							<button class="me-5" id="btn-trier-rien"><i class="bi bi-x" style="font-size: 20px;"></i></button>
						</div>
					</div>
				</div>

				<div class="line"></div>
				<br>
				
				<div class="container-fluid">
					<div class="container">

						<div class="row">
							<div id="annonces" class="annonce_body">
								<?php include('api/filtre-annonce.php'); ?>
							</div>
							<?php

								if($_SESSION['back_cont'] >= 24) {
								?>
									<div class="col-12 text-center" style="margin-bottom: 25px;">
										<button id="btn-pagination" class="achats__btn__pagination" style="background-color: <?= $background_Jaune ?>;">Voir plus d'annonces</button>
									</div>
								<?php
								}
								?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<br>
		<div class="container">
			<div class="row mb-4">

			</div>
		</div>
		<div><br><br></div>
	</main>

	<?php include 'include/footer.php' ?>
</body>
<script src="js/bootstrap.min.js"></script>
</html>

