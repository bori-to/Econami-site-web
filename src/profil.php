<?php session_start();

if (!isset($_SESSION['email'])) {
	header('location:forum.php');
	exit;
}

//connexion à la bdd
include('include/db.php');
$q = 'SELECT * FROM users WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([$_SESSION['id']]);
$results = $req->fetch();

$chemin_avatar = null;

if (isset($results['image'])) {
	$chemin_avatar = 'avatar/' .  $results['image'];
} else {
	$chemin_avatar = 'avatar/defaut/icon_profil.svg';
}

$q = 'SELECT a.prix, c.paiement_monnaie, a.marque, u.pseudo, c.id, c.date_creation, c.id_annonce
FROM commande c
INNER JOIN annonce a ON c.id_annonce = a.id
INNER JOIN users u ON a.id_users = u.id
WHERE c.id_users = ?
ORDER BY c.date_creation DESC
LIMIT 2;
';

$req = $bdd->prepare($q);
$req->execute([$_SESSION['id']]);
$commandes = $req->fetchAll();


$q = 'SELECT a.prix, c.paiement_monnaie, a.marque, u.pseudo, c.id, c.date_creation, c.id_annonce
FROM commande c
INNER JOIN annonce a ON c.id_annonce = a.id
INNER JOIN users u ON c.id_users = u.id
WHERE a.id_users = ?
ORDER BY c.date_creation DESC
LIMIT 2;
';

$req = $bdd->prepare($q);
$req->execute([$_SESSION['id']]);
$ventes = $req->fetchAll();

$q = 'SELECT * FROM annonce
WHERE id_users = ? AND valide = true;';
$req = $bdd->prepare($q);
$req->execute([$_SESSION['id']]);
$ann_online = $req->fetchAll();

$q = 'SELECT * FROM annonce
WHERE id_users = ? AND valide = false;';
$req = $bdd->prepare($q);
$req->execute([$_SESSION['id']]);
$ann_offline = $req->fetchAll();

$title = 'Profil';
include('include/head.php');

if (isset($_SESSION['id'])) {
	include('include/log.php');
	writeLog($title);
}
?>
<link rel="stylesheet" type="text/css" href="css/styleforum.css">
<link rel="stylesheet" type="text/css" href="css/style_achats.css">
</head>
<?php
if (isset($_COOKIE['theme'])) {
	if ($_COOKIE["theme"] == "dark") {
		$background_white = "#454D67";
		$background_marron = "#92A7B0";
		$background_marronClaire = "#3B5D6B";
		$background_Jaune = "#92A7B0";
		$background_PAG = "#92A7B0";
		$background_btn = "#585A56";
		$border_btn = "#585A56";
	} else {
		$background_white = "white";
		$background_marron = "rgba(185, 168, 124)";
		$background_marronClaire = "rgba(185, 168, 124, 0.5)";
		$background_Jaune = "#DCD488";
		$background_btn = "#B9A87C";
		$border_btn = "#B9A87C";
	}
} else {
	$background_white = "white";
	$background_marron = "rgba(185, 168, 124)";
	$background_marronClaire = "rgba(185, 168, 124, 0.5)";
	$background_Jaune = "#DCD488";
	$background_btn = "#B9A87C";
	$border_btn = "#B9A87C";
}
?>

<body style="background-color: <?= $background_white ?>;">
	<?php include 'include/header.php' ?>
	<main>

		<div class="container-fluid" style="background-color: <?= $background_marronClaire ?>;">
			<div class="container">
				<div class="row forum__accueil__line">
					<div class="col-md-8 col-xs-12">
						<h1 class="forum__accueil__h1">
							Profil de <?= $results['pseudo'] ?>
						</h1>
						<div class="col-md-6 col-xs-12">
							<?php

							include('include/message.php');

							?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 col-xs-12">
						<div class="forum__body">
							<h2 style="margin-bottom: 0; padding-bottom: 10px;">Informations</h2>
							<div class="line mb-2"></div>
							<div class="profil__info">
								<div style="border-bottom: .5px solid rgba(0, 0, 0, .2);" class="mb-2">
									Email<b class="ms-5"> <?= $results['email'] ?> </b>
								</div>
								<div style="border-bottom: .5px solid rgba(0, 0, 0, .2);" class="mb-2">
									Pseudo<b class="ms-5"> <?= $results['pseudo'] ?> </b>
								</div>
								<div style="border-bottom: .5px solid rgba(0, 0, 0, .2);" class="mb-2">
									Nom<b class="ms-5"> <?= $results['nom'] ?> </b>
								</div>
								<div style="border-bottom: .5px solid rgba(0, 0, 0, .2);" class="mb-2">
									Prenom<b class="ms-5"> <?= $results['prenom'] ?> </b>
								</div>
								<div style="border-bottom: .5px solid rgba(0, 0, 0, .2);" class="mb-2">
									Date de naissance<b class="ms-5"> <?= date_format(date_create($results['age']), 'd/m/Y') ?> </b>
								</div>
								<div style="border-bottom: .5px solid rgba(0, 0, 0, .2);" class="mb-2">
									Points<b class="ms-4"> <?= $results['points']?></b><b class="ms-2"><?=($results['points'] >= 250) ? ('Vous êtes VIP') : ("Vous n'êtes pas VIP") ?> </b>
								</div>
								<?php
								if ($results['newsletter'] == 'true') {
								?>
									<div class="form-check form-switch">
										<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckCheckedDisabled" checked disabled>
										<label class="form-check-label" for="flexSwitchCheckCheckedDisabled">Newsletter</label>
									</div>
								<?php
								} else {
								?>
									<div class="form-check form-switch">
										<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDisabled" disabled>
										<label class="form-check-label" for="flexSwitchCheckDisabled">Newsletter</label>
									</div>
								<?php
								}
								?>
								<div>
									<img src="<?= $chemin_avatar ?>" class="profil__avatar" width="150" height="150">
								</div>
								<div class="forum__body__btn">
									<a href="avatar_create.php" class="forum__btn__create" style="background-color: <?= $background_Jaune ?>;">
										Modifier mon avatar
									</a>
								</div>
							</div>
							<div class="forum__body__btn">
								<a href="genpdf.php" class="forum__btn__create" style="background-color: <?= $background_Jaune ?>;">
									<i class="bi"></i> Exporter les infos en PDF
								</a>
							</div>
						</div>

						<div class="forum__body__btn">
							<a href="profil_editer.php" class="forum__btn__create" style="background-color: <?= $background_Jaune ?>;">
								<i class="bi bi-person-fill"></i> Modifier profil
							</a>
						</div>

					</div>
					<div class="col-md-6 col-xs-12">
						<div class="forum__body">
							<div class="row">
								<div class="col-8">
									<h4 class="mb-3">Ventes :</h4>
								</div>
								<div class="col-4">
									<a href="profil_historique.php" class="forum__btn__create" style="background-color: <?= $background_Jaune ?>;">
										Historique
									</a>
								</div>
							</div>


							<?php

							foreach ($ventes as $vente) {
							?>
								<a class="list__topic__link" href="achats_annonce.php?id=<?= $vente['id_annonce'] ?>">
									<div class="list__topic__sujet" style="background-color: <?= $background_marronClaire ?>;">
										<div><?= $vente['prix'] . ' ' . $vente['paiement_monnaie'] ?> - <?= $vente['marque'] ?> - <?= $vente['pseudo'] ?></div>
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



							<h4 class="mb-3">Achats :</h4>

							<?php

							foreach ($commandes as $commande) {
							?>
								<a class="list__topic__link" href="achats_annonce.php?id=<?= $commande['id_annonce'] ?>">
									<div class="list__topic__sujet" style="background-color: <?= $background_marronClaire ?>;">
										<div><?= $commande['prix'] . ' ' . $commande['paiement_monnaie'] ?> - <?= $commande['marque'] ?> - <?= $commande['pseudo'] ?></div>
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
						<div class="forum__body">
							Solde : <b class="me-3"><?= $results['solde'] ?> €</b>
							<?= ($results['solde'] >= 25) ? '(Vous pouvez retirer votre argent.)' : '(Vous devez avoir au minimun 25 € sur votre compte pour retirer votre argent.)' ?>
							<?php
							if ($results['solde'] >= 25) {
							?>
								<div class="forum__body__btn">
									<a href="profil_retirer_argent.php" class="forum__btn__create" style="background-color: <?= $background_Jaune ?>;">
										<i class="bi bi-coin"></i> Retirer mon argent
									</a>
								</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 col-xs-12">
						<div class="forum__body">
							<h3 style="margin-bottom: 0; padding-bottom: 10px;">Annonces en ligne</h3>
							<div class="line mb-2"></div>
							<div id="annonces" class="annonce_body">
								<?php
								foreach ($ann_online as $on) {
								?>
									<div class="body__annonce" style="margin-right: 20px;">
										<a class="body__link__achat" href="achats_annonce.php?id=<?= $on['id'] ?>" id="body_annonce">
											<div class="body__achat">
												<p class="text-center body__montant">
													<?= $on['reduction'] . ' ' . $on['type'] ?>
													<br>
													<?= $on['marque'] ?>
												</p>
												<div class="body__date">
													<i class="bi bi-calendar"></i><?= date_format(date_create($on['date_expiration']), 'd/m/Y') ?>
												</div>
												<div class="body__prix text-center">
													<?= $on['prix'] . ' €' ?>
												</div>
											</div>
										</a>
									</div>
								<?php
								}
								?>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xs-12">
						<div class="forum__body">
							<h3 style="margin-bottom: 0; padding-bottom: 10px;">Annonces en court de validation</h3>
							<div class="line mb-2"></div>
							<div id="annonces" class="annonce_body">
								<?php
								foreach ($ann_offline as $off) {
								?>
									<div class="body__annonce" style="margin-right: 20px;">
										<a class="body__link__achat" href="achats_annonce.php?id=<?= $off['id'] ?>" id="body_annonce">
											<div class="body__achat">
												<p class="text-center body__montant">
													<?= $off['reduction'] . ' ' . $off['type'] ?>
													<br>
													<?= $off['marque'] ?>
												</p>
												<div class="body__date">
													<i class="bi bi-calendar"></i><?= date_format(date_create($off['date_expiration']), 'd/m/Y') ?>
												</div>
												<div class="body__prix text-center">
													<?= $off['prix'] . ' €' ?>
												</div>
											</div>
										</a>
									</div>
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