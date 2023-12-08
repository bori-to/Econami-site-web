<?php 
$title = 'Vente';
include('include/head.php');

?>
		<link rel="stylesheet" type="text/css" href="css/style_mise_en_vente.css">
		<link rel="stylesheet" type="text/css" href="css/styleforum.css">
		<link rel="stylesheet" type="text/css" href="css/paiement.css">
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
				<div class="row">
					<div class="col-2"></div>
					<div class="col-8 mb-4" style="background-color: <?php echo $background_marronClaire;?>; border-radius: 10px;">
						<h1 class="text-center">
							<i class="bi bi-info-circle"></i> Comment faire pour vendre son coupon de réduction ?
						</h1>
					</div>
				</div>
			</div>
        <div class="container fond2 mb-4" style="background-color: <?php echo $background_marronClaire;?>;">
			<div class="row pt-5 pb-4">
				<div class="col-1"></div>
				<div class="col-2 text-center">
					<i class="bi bi-1-square" style="font-size: 50px;"></i>
				</div>
				<div class="col-9">
					<h4>
						Vous déposez une annonce pour vendre votre coupon <br>(suivre les différentes étapes).
					</h4>
				</div>
				<div class="col-12 text-center pt-4">
					<img src="images/vendre4.png" style="border-radius: 20px; height: auto; max-width: 75%;">
				</div>
				<div class="col-1"></div>
				<div class="col-10 pt-4 pb-4">
					<div class="line_jaune" style="border-color: <?php echo $background_Jaune;?>;"></div>
				</div>
				<div class="col-1"></div>
			</div>

			<div class="row">
				<div class="col-1"></div>
				<div class="col-2 text-center">
					<i class="bi bi-2-square" style="font-size: 50px;"></i>
				</div>
				<div class="col-9">
					<h4>
						Attendez la validation de votre coupon par un administrateur.<br> Le coupon apparaît dans la catégorie Annonces en ligne de votre profil.
					</h4>
				</div>
				<div class="col-1"></div>
				<div class="col-10 pt-4 pb-4">
					<div class="line_jaune" style="border-color: <?php echo $background_Jaune;?>;"></div>
				</div>
				<div class="col-1"></div>
			</div>

			<div class="row">
				<div class="col-1"></div>
				<div class="col-2 text-center">
					<i class="bi bi-3-square" style="font-size: 50px;"></i>
				</div>
				<div class="col-9">
					<h4>
						Une fois en ligne, un utilisateur peut acheter votre coupon, <br>suite à cet achat, vous récupérez votre argent dans votre solde de votre compte.
					</h4>
				</div>
				<div class="col-1"></div>
				<div class="col-10 pt-4 pb-4">
					<div class="line_jaune" style="border-color: <?php echo $background_Jaune;?>;"></div>
				</div>
				<div class="col-1"></div>
			</div>

			<div class="row">
				<div class="col-1"></div>
				<div class="col-2 text-center">
					<i class="bi bi-4-square" style="font-size: 50px;"></i>
				</div>
				<div class="col-9">
					<h4>
						Au bout de 25 € sur votre compte, vous pouvez retirer votre argent <br>(Econami fera un virement bancaire vers votre compte).
					</h4>
				</div>
				<div class="col-1"></div>
				<div class="col-10 pt-4 pb-4">
					<div class="line_jaune" style="border-color: <?php echo $background_Jaune;?>;"></div>
				</div>
				<div class="col-1"></div>
			</div>

			<div class="row">
				<div class="col-12 text-center pb-4">
					<?php
					if(isset($_SESSION['id'])){
					?>
					<button type="submit" class="btn__link" style="font-weight: 500;">
						<a href="vente.php">Je dépose mon annonce</a>
					</button>
					<?php
					}else{?>
					<button type="submit" class="btn__link" style="font-weight: 500;">
						<a href="connexion.php">Je dépose mon annonce</a>
					</button>	
					<?php
					}
					?>
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