<?php session_start(); 
if(!isset($_SESSION['email']) || $_SESSION['type'] === '0'){
	header('location:index.php');
	exit;
}
//connexion à la bdd
include('include/db.php');
$q = 'SELECT * FROM users';
$req = $bdd->prepare($q);
$reponse = $bdd->query($q);

$title = 'Administrateur';
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
						<li class="breadcrumb-item active" aria-current="page">Accueil administrateur</li>
					</ol>
				</nav>
				<h1 class="col-12">Accueil administrateur</h1>
				<div class="row">
					<ul class="list-group list-group-flush">
						<li class="list-group-item" style="background-color: <?= $background_white?>;">
							<nav class="navbar bg-body-tertiary" style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_Jaune ?> !important;
													<?php
													}
													?> 
													">
								<div class="container-fluid">
									<a class="navbar-brand" href="back_end.php">Gérer les utilisateurs</a>
								</div>
							</nav>
						</li>
						<li class="list-group-item" style="background-color: <?= $background_white?>;">
							<nav class="navbar bg-body-tertiary" style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_Jaune ?> !important;
													<?php
													}
													?> 
													">
								<div class="container-fluid">
									<a class="navbar-brand" href="back_forum.php">Gérer le Forum</a>
								</div>
							</nav>
						</li>
						<li class="list-group-item" style="background-color: <?= $background_white?>;">
							<nav class="navbar bg-body-tertiary" style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_Jaune ?> !important;
													<?php
													}
													?> 
													">
								<div class="container-fluid">
									<a class="navbar-brand" href="back_annonce.php">Gérer les Annonces</a>
								</div>
							</nav>
						</li>
						<li class="list-group-item" style="background-color: <?= $background_white?>;">
							<nav class="navbar bg-body-tertiary" style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_Jaune ?> !important;
													<?php
													}
													?> 
													">
								<div class="container-fluid">
									<a class="navbar-brand" href="back_commande.php">Voire les Commandes</a>
								</div>
							</nav>
						</li>
						<li class="list-group-item" style="background-color: <?= $background_white?>;">
							<nav class="navbar bg-body-tertiary" style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_Jaune ?> !important;
													<?php
													}
													?> 
													">
								<div class="container-fluid">
									<a class="navbar-brand" href="back_captcha.php">Modifier le captcha</a>
								</div>
							</nav>
						</li>
						<li class="list-group-item" style="background-color: <?= $background_white?>;">
							<nav class="navbar bg-body-tertiary" style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_Jaune ?> !important;
													<?php
													}
													?> 
													">
								<div class="container-fluid">
									<a class="navbar-brand" href="back_newsletter.php">Newsletter, Email</a>
								</div>
							</nav>
						</li>
						
					</ul>
				</div>
			</div>

		</main>

		<?php include 'include/footer.php' ?>
	</body>
	<script src="js/bootstrap.min.js"></script>
</html>

