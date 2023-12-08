<?php session_start();

$title = 'Avantage';
include('include/head.php');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!-- <link rel="stylesheet" type="text/css" href="css/styleforum.css">
--></head>
<style> 
	body { overflow-x: hidden; }
</style>
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
		<div class="row">
			<div class="col-2"></div>
			<div class="col-8 mb-4" style="background-color: <?= $background_marronClaire?>; border-radius: 10px;">
				<h1 class="text-center">Quels sont les avantages du VIP ?</h1>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-md-4">
				<div class="card mb-4" style="border-radius: 20px; background-color: <?= $background_marronClaire?>;">
					<div class="card-body">
						<h2 class="card-title text-center"><i class="fas fa-shopping-bag"></i> Vente privée</h2>
						<p class="card-text text-center">Vous pouvez créer et participer à des ventes privées. Les règles sont simples : les premiers arrivés seront les premiers servis. Vous bénéficierez également de coupons de réduction de qualité supérieure et de prix réduits pour ces ventes privées. Profitez-en !</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card mb-4" style="border-radius: 20px; background-color: <?= $background_marronClaire?>;">
					<div class="card-body">
						<h2 class="card-title text-center"><i class="fas fa-certificate"></i> Distinction</h2>
						<p class="card-text text-center">Vous aurez accès à des skins exclusifs pour votre avatar, ainsi qu'une coloration unique pour votre <span style="background: white; color:<?=$background_Jaune?>;">@pseudo</span> ce qui vous permettra de vous démarquer des autres utilisateurs. N'hésitez pas à afficher votre soutien et à faire savoir à tout le monde que vous êtes un VIP !</p>
					</div>
				</div>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-md-4">
				<div class="card mb-4" style="border-radius: 20px; background-color: <?= $background_marronClaire?>;">
					<div class="card-body">
						<h2 class="card-title text-center"><i class="fas fa-bullhorn"></i> Mise en avant</h2>
						<p class="card-text text-center">Vos annonces seront affichées en premier sur la page d'accueil, ce qui vous donnera plus de visibilité et augmentera vos chances de vendre rapidement vos objets. Vous avez ainsi l'avantage d'être au-dessus de la concurrence !</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card mb-4" style="border-radius: 20px; background-color: <?= $background_marronClaire?>;">
					<div class="card-body">
						<h2 class="card-title text-center"><i class="fas fa-comments"></i> Chat exclusif</h2>
						<p class="card-text text-center">Vous aurez accès à un chat réservé sur le forum. C'est un lieu exclusif où vous pourrez discuter avec d'autres membres VIP, partager des astuces, poser des questions, etc. Ne manquez pas cette opportunité de rejoindre une communauté VIP privilégiée !</p>
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

