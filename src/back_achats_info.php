<?php session_start(); 
if(!isset($_SESSION['email']) || $_SESSION['type'] === '0'){
	header('location:index.php');
	exit;
}
//connexion à la bdd
include('include/db.php');

$q = 'SELECT c.*, u.prenom, u.nom, u.email, a.marque, a.prix, a.type 
FROM commande c 
INNER JOIN annonce a ON c.id_annonce = a.id
INNER JOIN users u ON c.id_users = u.id
WHERE c.id = ?';

$req = $bdd->prepare($q);
$req->execute([
	$_GET['id']
]);
$infos = $req->fetch();

$title = 'Administrateur - Commandes - infos';
include('include/head.php');
?>
<link rel="stylesheet" type="text/css" href="css/styleforum.css">
<link rel="stylesheet" type="text/css" href="css/paiement.css">
<link rel="stylesheet" type="text/css" href="css/style_achats.css">
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
					<li class="breadcrumb-item"><a href="back_commande.php">Commandes</a></li>
					<li class="breadcrumb-item active" aria-current="page">Infos</li>
				</ol>
			</nav>
			<div class="row">
				<div class="col-6">
					<h1>Infos</h1>
				</div>
				<div class="line"></div>
				<br>
				
				<div class="container-fluid pt-4 pb-3" style="background-color: rgba(237, 234, 234, 0.5); border-radius: 10px;">
					<div class="container">

						<div class="row">
							<div class="col-12">
								<div class="container-fluid">
									<div class="container container_paiement" style="background-color: <?= $background_marronClaire?>;">
										<div class="row forum__accueil__line">
											<div class="col-md-8 col-xs-12">
												<p><b>Coupon :</b> retrouvez vos coupons envoyer par mail ou dans votre profil !!</p>
											</div>
										</div>
										<h4>Informations de paiement</h4>
										<p><b>ID de transaction :</b> <?= $infos['txn_id'] ?></p>
										<p><b>Montant payé :</b> <?= $infos['paiement_montant'].' '.$infos['paiement_monnaie'] ?></p>
										<p><b>Payment Status:</b> <?= $infos['paiement_statue'] ?></p>

										<h4>Informations client</h4>
										<p><b>Nom :</b> <?= $infos['nom'].' '.$infos['prenom'] ?></p>
										<p><b>Email :</b> <?= $infos['email'] ?></p>

										<h4>Information produit</h4>
										<p><b>Marque :</b> <?= $infos['marque'] ?></p>
										<p><b>Réduction :</b> <?= $infos['prix'].' '.$infos['type'] ?></p>                        
									</div>
								</div>
							</div>


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

