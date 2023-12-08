<?php session_start();

//connexion à la bdd
include('include/db.php');
$ParPage_topic = 5;
if(isset($_SESSION['id'])){
	$id_topic = $_SESSION['id'];
	$TotalesReq_topic = $bdd->query('SELECT id FROM topic WHERE id_users = '.$id_topic.'');
	$Totale_topic = $TotalesReq_topic->rowCount();
	$pagesTotales_topic = ceil($Totale_topic/$ParPage_topic);

	if(isset($_GET['page_topic']) AND !empty($_GET['page_topic']) AND $_GET['page_topic'] > 0){
		$_GET['page_topic'] = intval($_GET['page_topic']);
		$pageCourante_topic = $_GET['page_topic'];
	}else{
		$pageCourante_topic = 1;
	}

	if(isset($_GET['page_topic']) AND $_GET['page_topic'] <= 0){
		$pageCourante_topic = 1;
	}

	$depart_topic = ($pageCourante_topic-1)*$ParPage_topic;

	$ParPage_commentaire = 10;
	$TotalesReq_commentaire = $bdd->query('SELECT id FROM topic_commentaire WHERE id_users = '.$id_topic.'');
	$Totale_commentaire = $TotalesReq_commentaire->rowCount();
	$pagesTotales_commentaire = ceil($Totale_commentaire/$ParPage_commentaire);

	if(isset($_GET['page_commentaire']) AND !empty($_GET['page_commentaire']) AND $_GET['page_commentaire'] > 0){
		$_GET['page_commentaire'] = intval($_GET['page_commentaire']);
		$pageCourante_commentaire = $_GET['page_commentaire'];
	}else{
		$pageCourante_commentaire = 1;
	}

	if(isset($_GET['page_commentaire']) AND $_GET['page_commentaire'] <= 0){
		$pageCourante_commentaire = 1;
	}

	$depart_commentaire = ($pageCourante_commentaire-1)*$ParPage_commentaire;

}

// Liste catégorie
$q = 'SELECT * FROM forum ORDER BY ordre';
$req = $bdd->prepare($q);
$req->execute();

$req_forum = $req->fetchAll();

// Liste commentaires
if(isset($_SESSION['email'])){
	$q = 'SELECT * FROM topic_commentaire WHERE id_users = ? ORDER BY date_creation DESC LIMIT '.$depart_commentaire.','.$ParPage_commentaire.'
	';
	$req = $bdd->prepare($q);
	$req->execute([
		$_SESSION['id']
	]);
}

$req_com = $req->fetchAll();

// Derniers topic
$q = 'SELECT t.*, u.pseudo, u.image, u.points
FROM topic t
INNER JOIN users u on u.id = t.id_users
ORDER BY t.date_creation DESC LIMIT 0,5';
$req = $bdd->prepare($q);
$req->execute();

$req_dernierTopic = $req->fetchAll();

if(isset($_SESSION['email'])){
// Vos topics
	$q = 'SELECT t.*, u.pseudo, u.image, u.points
	FROM topic t
	INNER JOIN users u on u.id = t.id_users
	WHERE pseudo = ?
	ORDER BY t.date_creation DESC LIMIT '.$depart_topic.','.$ParPage_topic.'
	';
	$req = $bdd->prepare($q);
	$req->execute([
		$_SESSION['pseudo']
	]);
}

$req_vosTopic = $req->fetchAll();


$title = 'Forum';
include('include/head.php');

if(isset($_SESSION['id'])){
	include('include/log.php');
	writeLog($title);
}
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

			<div class="container-fluid" style="background-color: <?= $background_marronClaire?>;">
				<div class="container">
					<div class="row forum__accueil__line">
						<div class="col-8">
							<h1 class="forum__accueil__h1">
								Forum
							</h1>
						</div>
						<div class="col-4">
							<h1 class="forum__accueil__h1">
								<i class="bi bi-house"></i>
							</h1>
						</div>
					</div>

					<div class="row">
						<div class="col-md-8 col-xs-12">
							<div class="forum__body">
								<h2 class="forum__h1">Catégories</h2>

								<div class="forum__body__btn">
									<a href="forum_creerTopic.php" class="forum__btn__create" style="background-color: <?= $background_Jaune?>;">
										<i class="bi bi-plus btn__topic"></i> Créer un topic
									</a>
								</div>

								<?php
								foreach($req_forum as $rf){

									$q = 'SELECT COUNT(id) AS NbCommentaire
										FROM topic
										WHERE id_forum = ?';
										$req = $bdd->prepare($q);
										$req->execute([
											$rf['id']
										]);

										$req_nb_topic = $req->fetch();
										$nb_topic = $req_nb_topic['NbCommentaire'];

										if($nb_topic > 1){
											$lib__topic = "Il y a " . $nb_topic . " topics";
										}else{
											$lib__topic = "Il y a " . $nb_topic . " topic";
										}
								?>
								<a class="list__link__forum" href="forum_listeTopics.php?id=<?= $rf['id'] ?>">
									<div class="list__cat__forum">
										<div><?= $rf['titre'] ?></div>
										<div class="list__forum__footer">
											<div>
												<?= $lib__topic ?>
											</div>
										</div>
									</div>
								</a>
								<?php		
								}
								?>
							</div>

							<div class="row">
								<div class="col-md-6 col-xs-12">
									<div class="forum__body">
										<h4 class="forum__h1">Derniers topics</h4>

										<div class="mt-4 mb-4">
											<?php
											foreach($req_dernierTopic as $rdt){
												$q = 'SELECT COUNT(id) AS NbCommentaire
												FROM topic_commentaire
												WHERE id_topic = ?';
												$req = $bdd->prepare($q);
												$req->execute([
													$rdt['id']
												]);

												$req_nb_commentaire = $req->fetch();
												$nb_commentaire = $req_nb_commentaire['NbCommentaire'];

												$chemin_avatar = null;

												if(isset($rdt['image'])){
													$chemin_avatar = 'avatar/' .  $rdt['image'];
												}else{
													$chemin_avatar = 'avatar/defaut/icon_profil.svg';
												}
												?>
												<a href="forum_topic.php?id=<?= $rdt['id'] ?>" class="list__topic__link">
													<div class="list__topic__sujet" style="background-color: <?= $background_marronClaire?>;">
														<div><?= $rdt['titre'] ?></div>
														<div class="list__topic__footer">
															<div>
																<img src="<?= $chemin_avatar ?>" class="profil__avatar" width="16" height="16">
																<?= $rdt['pseudo'] ?>
															</div>
															<div><i class="bi bi-chat-dots" style="margin-right: 2px;"></i><?= $nb_commentaire ?></div>
															<?php
															if($rdt['date_creation'] < $rdt['date_modification']){
																?>
																<div>Modifié le <?= date_format(date_create($rdt['date_modification']), 'd/m/Y à H:i') ?></div>
																<?php
															}else{
																?>
																<div>Le <?= date_format(date_create($rdt['date_creation']), 'd/m/Y à H:i') ?></div>
																<?php
															}
															?>
														</div>
													</div>
												</a>
											<?php		
											}
											?>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
									<div class="forum__body">
										<h4 class="forum__h1">Vos topics</h4>
									

									<div class="mt-4">
											<?php
											foreach($req_vosTopic as $rvt){
												$q = 'SELECT COUNT(id) AS NbCommentaire
												FROM topic_commentaire
												WHERE id_topic = ?';
												$req = $bdd->prepare($q);
												$req->execute([
													$rvt['id']
												]);

												$req_nb_commentaire = $req->fetch();
												$nb_commentaire = $req_nb_commentaire['NbCommentaire'];

												$q = 'SELECT image FROM users WHERE id = ?';
												$req = $bdd->prepare($q);
												$req->execute([
													$_SESSION['id']
												]);
												$req_avatar = $req->fetch();

												$chemin_avatar = null;

												if(isset($req_avatar['image'])){
													$chemin_avatar = 'avatar/' .  $req_avatar['image'];
												}else{
													$chemin_avatar = 'avatar/defaut/icon_profil.svg';
												}
												?>
												<a href="forum_topic.php?id=<?= $rvt['id'] ?>" class="list__topic__link">
													<div class="list__topic__sujet" style="background-color: <?= $background_marronClaire?>;">
														<div><?= $rvt['titre'] ?></div>
														<div class="list__topic__footer">
															<div>
																<img src="<?= $chemin_avatar ?>" class="profil__avatar" width="16" height="16">
																<?= $rvt['pseudo'] ?>
															</div>
															<div><i class="bi bi-chat-dots" style="margin-right: 2px;"></i><?= $nb_commentaire ?></div>
															<?php
															if($rvt['date_creation'] < $rvt['date_modification']){
																?>
																<div>Modifié le <?= date_format(date_create($rvt['date_modification']), 'd/m/Y à H:i') ?></div>
																<?php
															}else{
																?>
																<div>Le <?= date_format(date_create($rvt['date_creation']), 'd/m/Y à H:i') ?></div>
																<?php
															}
															?>
														</div>
													</div>
												</a>
											<?php		
											}
											?>
									</div>
									<?php
									if(isset($_SESSION['id'])){
									?>
									<div id="pagination">

											<?php
											if($pagesTotales_topic > 1) {
												if($pageCourante_topic > 1) {
													?>
													<a style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_PAG ?>;
													<?php
													}
													?> 
													border-radius: 10px;" class="page-numbers mb-2" href="forum_accueil.php?page_topic=<?= $pageCourante_topic-1 ?>"><</a>
													<?php
												} else {
													?>
													<span style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_PAG ?>;
													<?php
													}
													?> 
													border-radius: 10px;" class="page-numbers disabled mb-2"><</span>
												<?php
												}

												for($i=1;$i<=$pagesTotales_topic;$i++){
													if($i == $pageCourante_topic){
														?>
														<span class="page-numbers current mb-2" style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_PAG ?>;
													<?php
													}
													?> 
													"><?= $i ?></span>
														<?php
													} elseif($i == 1 || $i == $pagesTotales_topic || ($i >= $pageCourante_topic-2 && $i <= $pageCourante_topic+2)) {
														?>
														<a class="page-numbers mb-2" href="forum_accueil.php?page_topic=<?= $i ?>" style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_PAG ?>;
													<?php
													}
													?> 
													"><?= $i ?></a>
														<?php
													} elseif($i == 2 || $i == $pagesTotales_topic-1) {
														?>
														<span class="page-numbers dots mb-2" style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_PAG ?>;
													<?php
													}
													?> 
													">...</span>
														<?php
													}
												}

												if($pageCourante_topic < $pagesTotales_topic) {
													?>
													<a style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_PAG ?>;
													<?php
													}
													?> 
													border-radius: 10px;" class="page-numbers mb-2" href="forum_accueil.php?page_topic=<?= $pageCourante_topic+1 ?>">></a>
													<?php
												} else {
													?>
													<span style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_PAG ?>;
													<?php
													}
													?> 
													border-radius: 10px;" class="page-numbers disabled mb-2">></span>
													<?php
												}
											}
											?>

											</div>
									<?php
									}
									?>
									</div>
								</div>
								</div>
							</div>

							<div class="col-md-4 col-xs-12">
							<div class="forum__body">
								<h2 class="forum__h1">Vos commentaires</h2>

								<div class="mt-4">
								<?php
								foreach($req_com as $rc){
								?>
								<a class="list__link__forum" href="forum_topic.php?id=<?= $rc['id_topic'] ?>">
									<div class="list__cat__forum">
										<div><?= $rc['contenu'] ?></div>
										<div class="list__forum__footer">
											<div>
												<?= date_format(date_create($rc['date_creation']), 'd/m/Y à H:i') ?>
											</div>
										</div>
									</div>
								</a>
								<?php		
								}
								?>
								</div>
								<?php
									if(isset($_SESSION['id'])){
									?>
									<div id="pagination">

											<?php
											if($pagesTotales_commentaire > 1) {
												if($pageCourante_commentaire > 1) {
													?>
													<a style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_PAG ?>;
													<?php
													}
													?> 
													border-radius: 10px;" class="page-numbers mb-2" href="forum_accueil.php?page_commentaire=<?= $pageCourante_commentaire-1 ?>"><</a>
													<?php
												} else {
													?>
													<span style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_PAG ?>;
													<?php
													}
													?> 
													border-radius: 10px;" class="page-numbers disabled mb-2"><</span>
												<?php
												}

												for($i=1;$i<=$pagesTotales_commentaire;$i++){
													if($i == $pageCourante_commentaire){
														?>
														<span class="page-numbers current mb-2" style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_PAG ?>;
													<?php
													}
													?> 
													"><?= $i ?></span>
														<?php
													} elseif($i == 1 || $i == $pagesTotales_commentaire || ($i >= $pageCourante_commentaire-2 && $i <= $pageCourante_commentaire+2)) {
														?>
														<a class="page-numbers mb-2" href="forum_accueil.php?page_commentaire=<?= $i ?>" style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_PAG ?>;
													<?php
													}
													?> 
													"><?= $i ?></a>
														<?php
													} elseif($i == 2 || $i == $pagesTotales_commentaire-1) {
														?>
														<span class="page-numbers dots mb-2" style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_PAG ?>;
													<?php
													}
													?> 
													">...</span>
														<?php
													}
												}

												if($pageCourante_commentaire < $pagesTotales_commentaire) {
													?>
													<a style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_PAG ?>;
													<?php
													}
													?> 
													border-radius: 10px;" class="page-numbers mb-2" href="forum_accueil.php?page_commentaire=<?= $pageCourante_commentaire+1 ?>">></a>
													<?php
												} else {
													?>
													<span style="
													<?php 
													if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
													?> 
														background-color: <?= $background_PAG ?>;
													<?php
													}
													?> 
													border-radius: 10px;" class="page-numbers disabled mb-2">></span>
													<?php
												}
											}
											?>

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

