<?php session_start(); 
$title = 'Vente';
include('include/head.php');

if(!isset($_SESSION['email'])){
	header('location:connexion.php');
    exit;
}

if(isset($_SESSION['id'])){
	include('include/log.php');
	writeLog($title);
}
?>
		<link rel="stylesheet" type="text/css" href="css/style_mise_en_vente.css">
		<link rel="stylesheet" type="text/css" href="css/styleforum.css">
		<link rel="stylesheet" type="text/css" href="css/paiement.css">
		<script src="js/vente.js"></script>
		<style type="text/css">
			.hidden{
				display: none;
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
<body style="background-color: <?php echo $background_white;?>;">
		<?php include 'include/header.php' ?>
	<main>
        
		<div class="container-fluid fond"> 
			<div class="container">
			<?php 

			include('include/message.php');

			?>	
			
				<div class="row">
					<div class="col-2"></div>
					<div class="col-8 mb-4" style="background-color: <?php echo $background_marronClaire;?>; border-radius: 10px;">
						<h1 class="text-center">
							<i class="bi bi-clipboard2-plus"></i> Vends ton coupon
						</h1>
					</div>
				</div>
			</div>
        <div class="container fond2 mb-4" style="background-color: <?php echo $background_marronClaire;?>;">
			<div class="row">
				<div class="col-6 text-center numpour">
						<button id="num"type="button" class="btn btn-secondary" onclick="numérique()">
							<p>Numérique</p>
							<i height="500px" class="bi bi-currency-euro text-center"></i>
						</button>
				</div>
				<div class="col-6 text-center numpour1">
						<button id="per"type="button" class="btn btn-secondary" onclick="pourcent()">
							<p>Pourcentage</p>
							<i class="bi bi-percent"></i>
						</button>
						<form action="vente_verif.php" method="POST">
						<input id="form"type="hidden" name="type" value="">
				</div>
			</div>
			<div class="row">
			<div class="col-1"></div>
				<div class="col-10 pt-5 pb-4 text-center">
					<div class="line_jaune" style="border-color: <?php echo $background_Jaune;?>;"></div>
				</div>
			</div>
			<div class="row">
				<div class="col-1"></div>
				<div class="col-md-2 col-5">
					<p>Montant de la réduction</p>
				</div>
				<div class="col-md-1 col-2">
					
					<input id="montant" type="number" class="form-control" name="reduction" min="0"required autofocus disabled>
					
				</div>
				<div class="col-md-8 col-4"></div>
			<div class="col-1"></div>
				<div class="col-10 pt-4 pb-4">
					<div class="line_jaune" style="border-color: <?php echo $background_Jaune;?>;"></div>
				</div>
			</div>
			<div class="row">
			<div class="col-1"></div>
				<div class="col-6">
					<h3>Prix du coupon</h3>
			</div>
			<div class="row">
			<div class="col-1"></div>
				<div class="col-md-2 col-5 pb-1">
					<p>L'Acheteur paiera</p>
				</div>
				<div class="col-md-1 col-2">
					<input id="prix_coupon_a" type="number" class="form-control" name="prix" min="0"required autofocus disabled oninput="showNumber()">
				</div>
				<div class="col-4 col-md-1"></div>
				<div class="col-1 col-md-1"></div>
				<div class="col-md-4 col-10 ml-1">
					<p id="explication" style="display:none;">Votre coupon possède une réduction numérique, vous ne pouvez donc pas dépasser le prix du coupon</p>
				</div>
			</div>
			<div class="row">
			<div class="col-1"></div>
				<div class="col-md-4 col-10">
					<p>Vous receverez: <span id="displayNumber"></span>(Taxes inclues)</p>
				</div>
			</div>
			<div class="row">
				<div class="col-1"></div>
				<div class="col-10 pt-4 pb-4">
					<div class="line_jaune" style="border-color: <?php echo $background_Jaune;?>;"></div>
				</div>
			</div>
			<div class="row">
			<div class="col-1"></div>
				<div class="col-md-2 col-5">
					<p>Magasin</p>
				</div>
				<div class="col-md-2 col-5">
					
					<input id="magasin" type="text" class="form-control" name="marque" required autofocus>
					
				</div>
			</div>
			<div class="row">
			<div class="col-1"></div>
				<div class="col-10 pt-4 pb-4">
				
					<div class="line_jaune" style="border-color: <?php echo $background_Jaune;?>;"></div>
				</div>
			</div>
			<div class="row">
			<div class="col-1"></div>
				<div class="col-md-2 col-5">
				<p>ID du coupon</p>
				</div>
				<div class="col-md-3 col-5">
					
					<input id="ID_coupon" type="text" class="form-control" name="coupon" required autofocus>
					
				</div>
			</div>
			<div class="row">
			<div class="col-1"></div>
				<div class="col-10 pt-4 pb-4">
					<div class="line_jaune" style="border-color: <?php echo $background_Jaune;?>;"></div>
				</div>
			</div>
			<div class="row">
			<div class="col-1"></div>
			<div class="col-md-2 col-5">
				<p>Date d'expiration</p>
			</div>
			<div class="col-md-3 col-5">
				<label class="form-label">Date d'expiration *</label>
				<input id="date_exp" type="date" class="form-control" name="date_expiration" required autofocus>
			</div>
			</div>
			<div class="row">
			<div class="col-1"></div>
				<div class="col-10 pt-4 pb-4">
					<div class="line_jaune" style="border-color: <?php echo $background_Jaune;?>;"></div>
				</div>
			</div>
			<?php 
			if($_SESSION['type'] == 1){
			?>
				<div class="row">
				<div class="col-1"></div>
					<div class="col-md-2 col-5">
						<p>Catégories</p>
					</div>
					<div class="col-md-3 col-5">				
						<select id="cat" name="categorie" class="form-select" onchange="toggleDateApp()">		
							<option hidden>Choississez votre catégorie</option>							
							<option value="0">Normal</option>
							<option value="3">Vente Privée</option>	
						</select>
						<div id="dateApp" style="display: none;">
							<label class="form-label">Date d'apparition *Si vente privée</label>
							<input id="date_app" type="date" class="form-control" name="date_apparition" value="<?= date('Y-m-d') ?>" required autofocus>
						</div>
					</div>
				</div>
				<div class="row">
				<div class="col-1"></div>
					<div class="col-10 pt-4 pb-4">
						<div class="line_jaune" style="border-color: <?php echo $background_Jaune;?>;"></div>
					</div>
				</div>
			<?php
			}
			?>
			<div class="row">
			<div class="col-1"></div>
				<div class="col-2">
					<button type="submit" class="btn__link">Envoyer</button>
				</div>
			</div>
			</form>
			</div>
		</div>
		</div>
		</div>
	</main>
		<?php include 'include/footer.php' ?>
	</body>
	<script>
		const dateAppInput = document.getElementById('date_app');
		const dateExpInput = document.getElementById('date_exp');
		const today = new Date().toISOString().split('T')[0];
		dateExpInput.setAttribute('min', today);
		dateAppInput.setAttribute('min', today);
		function toggleDateApp() {
			const select = document.getElementById('cat');
			const dateAppDiv = document.getElementById('dateApp');
			if (select.value === '3') {
				dateAppDiv.style.display = 'block';
			} else {
				dateAppDiv.style.display = 'none';
			}
		}
	</script>
	<script src="js/bootstrap.min.js"></script>
</html>