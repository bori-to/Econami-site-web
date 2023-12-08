<?php session_start();

include('include/db.php');

$title = 'Achats';
include('include/head.php');

if(isset($_SESSION['id'])){
	include('include/log.php');
	writeLog($title);
}
?>
	<link rel="stylesheet" type="text/css" href="css/style_achats.css">
	<link rel="stylesheet" type="text/css" href="css/pagination.css">
	<link rel="stylesheet" type="text/css" href="css/styleforum.css">
	<script type="text/javascript">
		

		document.addEventListener('DOMContentLoaded', function() {
			const menuToggle = document.querySelector('#menu-toggle');
			menuToggle.addEventListener('click', function(e) {
				e.preventDefault();
				const wrapper = document.querySelector('#wrapper');
				wrapper.classList.toggle('toggled');
			});
		});

		document.addEventListener('DOMContentLoaded', function() {
			const menu = document.querySelector('#menu-toggle');
			menu.addEventListener('click', function(e) {
				e.preventDefault();
				const wrap = document.querySelector('#sidebar-wrapper');
				wrap.classList.toggle('filter__visible');
			});
		});

		document.addEventListener('DOMContentLoaded', function() {
			const mToggle = document.querySelector('#menu-toggle');
			mToggle.addEventListener('click', function(e) {
				e.preventDefault();
				const annonce = document.querySelector('#annonce');
				const annonceFiltre = document.querySelector('#annonce__filtre');
				const bodyAnnonce = document.querySelector('#body_annonce');
				annonce.classList.toggle('col-md-9');
				annonce.classList.toggle('col-md-12');
				annonceFiltre.classList.toggle('col-md-3');

				for (let i = 0; i<annonceFiltre.length; i++){
					const an = annonceFiltre[i];
					an.classList.toggle('col-md-3');
					an.classList.toggle('col-md-4');
				}
			});
		});

		function changeFilter(){
			document.getElementById("sidebar-wrapper").style.display='none';
		}
	</script>
	<script src="js/filtreAchats.js"></script>
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
								<i class="bi bi-bag"></i> Achats
							</h1>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 col-xs-12" id="annonce__filtre">
							<div id="wrapper">

								<div id="page-content-wrapper">	
									<a href="#menu-toggle" class="burger__filter" id="menu-toggle">
										<i class="bi bi-filter-left"></i>
									</a>
								</div>
								<div id="sidebar-wrapper" style="background-color: <?php echo $background_marronClaire;?>;">
									<div class="body__filter">
										<div class="row">
											<div class="col-12 mb-1">
												Marques :
											</div>
											<div class="col-12 mb-3">
          										<input id="marque" type="text" class="form-control" placeholder="Search..." aria-label="Search">
        									</div>
        									<div class="col-12 mb-3" style="border-bottom: 1px solid rgba(0, 0, 0, .5);"></div>
        									<div class="col-12 mb-1">
												Prix :
											</div>
        									<div class="col-12">
        										<div class="input-group mb-3">
        											<span class="input-group-text">Min</span>
        											<input id="prixmin" type="number" class="form-control text-center" aria-label="Amount (to the nearest dollar)">
        											<span class="input-group-text">€</span>
        										</div>
        									</div>
        									<div class="col-12">
        										<div class="input-group mb-3">
        											<span class="input-group-text">Max</span>
        											<input id="prixmax" type="number" class="form-control text-center" aria-label="Amount (to the nearest dollar)">
        											<span class="input-group-text">€</span>
        										</div>
        									</div>
        									<div class="col-12 mb-3" style="border-bottom: 1px solid rgba(0, 0, 0, .5);"></div>
        									<div class="col-12 mb-1">
												Types :
											</div>
											<div class="col-12 mb-3">
											<select class="form-control" id="type" >
  												<option value="">Sélectionnez un type</option>
  													<option value="€">€</option>
  													<option value="%">%</option>
											</select>
											</div>
											<div class="col-12 mb-3" style="border-bottom: 1px solid rgba(0, 0, 0, .5);"></div>
											<div class="col-12 mb-1">
												Date d'expiration supérieur à :
											</div>
											<div class="col-12 mb-3">
          										<input class="form-control" type="date" id="date-expiration" placeholder="Date d'expiration">
        									</div>
        									<div class="col-12 mb-3" style="border-bottom: 1px solid rgba(0, 0, 0, .5);"></div>
        									<div class="col-12 text-center">
        										<button id="btn-filtrer" class="btn_filtre" style="background-color: <?php echo $background_Jaune;?>;">
        											Filtrer
        										</button>
        									</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-9 col-xs-12" id="annonce">
							<div class="row">
								<div class="col-12 text-end mb-5">
									<button class="croissant__btn" id="btn-trier" 
									<?php
									if(isset($_COOKIE['theme'])){
										if($_COOKIE["theme"] == "dark") {
											?>
											style="background-color: <?php echo $background_btnJaune;?>;"
											<?php
										}
									}
									?>
									>Prix croissant</button>
								</div>
								<div id="annonces" class="annonce_body">
									<?php include('api/filtre-achats.php'); ?>
								</div>
								<?php

								if($_SESSION['cont'] >= 24) {
								?>
									<div class="col-12 text-center" style="margin-bottom: 25px;">
										<button id="btn-pagination" class="achats__btn__pagination" style="background-color: <?= $background_Jaune ?>;">Voir plus de d'annonce</button>
									</div>
								<?php
								}
								?>
						</div>
					</div>
				</div>
			</div>
		
		</main>

		<?php include 'include/footer.php' ?>
	</body>
	<script src="js/bootstrap.min.js"></script>
</html>

