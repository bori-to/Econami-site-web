<?php session_start(); 
if(!isset($_SESSION['email']) || $_SESSION['type'] === '0'){
	header('location:index.php');
	exit;
}

include('include/db.php');
$ParPage = 6;
$TotalesReq = $bdd->query('SELECT id FROM commande');
$Totale = $TotalesReq->rowCount();
$pagesTotales = ceil($Totale/$ParPage);

if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0){
	$_GET['page'] = intval($_GET['page']);
	$pageCourante = $_GET['page'];
}else{
	$pageCourante = 1;
}

if(isset($_GET['page']) AND $_GET['page'] <= 0){
	$pageCourante = 1;
}

$depart = ($pageCourante-1)*$ParPage;
//connexion à la bdd

$q = 'SELECT * FROM users';
$req = $bdd->prepare($q);
$reponse = $bdd->query($q);

$q = 'SELECT a.prix, c.paiement_monnaie, a.marque, u.pseudo, c.id, c.date_creation, c.id_annonce
FROM commande c
INNER JOIN annonce a ON c.id_annonce = a.id
INNER JOIN users u ON a.id_users = u.id
ORDER BY c.date_creation DESC LIMIT '.$depart.','.$ParPage.'
';

$req = $bdd->prepare($q);
$req->execute();
$commandes = $req->fetchAll();

$q = 'SELECT a.prix, c.paiement_monnaie, a.marque, u.pseudo, c.id, c.date_creation, c.id_annonce
FROM commande c
INNER JOIN annonce a ON c.id_annonce = a.id
INNER JOIN users u ON c.id_users = u.id
ORDER BY c.date_creation DESC LIMIT '.$depart.','.$ParPage.'
';

$req = $bdd->prepare($q);
$req->execute();
$ventes = $req->fetchAll();

$title = 'Administrateur - Commandes';
include('include/head.php');
?>
<link rel="stylesheet" type="text/css" href="css/styleforum.css">
<link rel="stylesheet" type="text/css" href="css/pagination.css">
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
					<li class="breadcrumb-item active" aria-current="page">Commandes</li>
					<li style="margin-left: 200px;">
						<?php 

						include('include/message.php');

						?>
					</li>
				</ol>
			</nav>
			<div class="row">
				<div class="col-6">
					<h1>Commandes</h1>
				</div>
				<div class="line"></div>
				<br>
				
				<div class="container-fluid" style="background-color: rgba(237, 234, 234, 0.5); border-radius: 10px;">
					<div class="container">

						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="forum__body">
									<h2 class="forum__h1">Achats</h2>

									<?php

								foreach($ventes as $vente){
								?>
									<a class="list__topic__link" href="back_achats_info.php?id=<?= $vente['id'] ?>">
										<div class="list__topic__sujet" style="background-color: <?= $background_marronClaire?>;">
											<div><?= $vente['prix'] .' '. $vente['paiement_monnaie'] ?> - <?= $vente['marque'] ?> - <?= $vente['pseudo'] ?></div>
											<div class="list__topic__footer">
												<div>
													Commande n°<?= $vente['id'] ?> - Le <?= date_format(date_create($vente['date_creation']), 'd/m/Y à H:i') ?>

												</div>
											</div>
										</div>
									</a>
								<?php
								}

								?>
								</div>
							</div>

							<div class="col-md-6 col-xs-12">
								<div class="forum__body">
									<h2 class="forum__h1">Ventes</h2>

								<?php

								foreach($commandes as $commande){
								?>
									<a class="list__topic__link" href="achats_annonce.php?id=<?= $commande['id_annonce'] ?>">
										<div class="list__topic__sujet" style="background-color: <?= $background_marronClaire?>;">
											<div><?= $commande['prix'] .' '. $commande['paiement_monnaie'] ?> - <?= $commande['marque'] ?> - <?= $commande['pseudo'] ?></div>
											<div class="list__topic__footer">
												<div>
													Commande n°<?= $commande['id'] ?> - Le <?= date_format(date_create($commande['date_creation']), 'd/m/Y à H:i') ?>

												</div>
											</div>
										</div>
									</a>
								<?php
								}

								?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br>
		<?php 
		include('include/pagination.php');
		?>
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

