<?php session_start(); 
if(!isset($_SESSION['email']) || $_SESSION['type'] === '0'){
	header('location:index.php');
	exit;
}

include('include/db.php');
$ParPage_topic = 6;
$TotalesReq_topic = $bdd->query('SELECT id FROM topic');
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

$ParPage_commentaire = 6;
$TotalesReq_commentaire = $bdd->query('SELECT id FROM topic_commentaire');
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

$q = 'SELECT * FROM users';
$req = $bdd->prepare($q);
$reponse = $bdd->query($q);

// Derniers topic
$q = 'SELECT t.*, u.pseudo 
FROM topic t
INNER JOIN users u on u.id = t.id_users
ORDER BY t.date_creation DESC LIMIT '.$depart_topic.','.$ParPage_topic.'
';
$req = $bdd->prepare($q);
$req->execute();

$req_dernierTopic = $req->fetchAll();

// Derniers commentaire
$q = 'SELECT c.*, u.pseudo 
FROM topic_commentaire c
INNER JOIN users u on u.id = c.id_users
ORDER BY c.date_creation DESC LIMIT '.$depart_commentaire.','.$ParPage_commentaire.'
';
$req = $bdd->prepare($q);
$req->execute();

$req_com = $req->fetchAll();

$title = 'Administrateur - Forum';
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
					<li class="breadcrumb-item active" aria-current="page">Forum</li>
					<li style="margin-left: 200px;">
						<?php 

						include('include/message.php');

						?>
					</li>
				</ol>
			</nav>
			<div class="row">
				<div class="col-12">
					<h1>Forum</h1>
				</div>
				<div class="line"></div>
				<br>
				
				<div class="container-fluid mb-4" style="background-color: <?= $background_marronClaire ?>; border-radius: 10px;">
					<div class="container">

						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="forum__body">
									<h2 class="forum__h1">Topics</h2>

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
												?>
												<a href="forum_topic.php?id=<?= $rdt['id'] ?>" class="list__topic__link">
													<div class="list__topic__sujet" style="background-color: <?= $background_marronClaire?>;">
														<div><?= $rdt['titre'] ?></div>
														<div class="list__topic__footer">
															<div><?= $rdt['pseudo'] ?></div>
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
											<div id="pagination" class="mb-2">

											<?php
											if($pagesTotales_topic > 1) {

												if($pageCourante_topic > 1) {
													?>
													<a style="border-radius: 10px;" class="page-numbers" href="back_forum.php?page_topic=<?= $pageCourante_topic-1 ?>">Précédent</a>
													<?php
												} else {
													?>
													<span style="border-radius: 10px;" class="page-numbers disabled">Précédent</span>
													<?php
												}

												for($i=1;$i<=$pagesTotales_topic;$i++){
													if($i == $pageCourante_topic){
														?>
														<span class="page-numbers current"><?= $i ?></span>
														<?php
													} elseif($i == 1 || $i == $pagesTotales_topic || ($i >= $pageCourante_topic-2 && $i <= $pageCourante_topic+2)) {
														?>
														<a class="page-numbers" href="back_forum.php?page_topic=<?= $i ?>"><?= $i ?></a>
														<?php
													} elseif($i == 2 || $i == $pagesTotales_topic-1) {
														?>
														<span class="page-numbers dots">...</span>
														<?php
													}
												}

												if($pageCourante_topic < $pagesTotales_topic) {
													?>
													<a style="border-radius: 10px;" class="page-numbers" href="back_forum.php?page_topic=<?= $pageCourante_topic+1 ?>">Suivant</a>
													<?php
												} else {
													?>
													<span style="border-radius: 10px;" class="page-numbers disabled">Suivant</span>
													<?php
												}
											}
											?>

											</div>
								</div>
							</div>

							<div class="col-md-6 col-xs-12">
								<div class="forum__body">
									<h2 class="forum__h1">Commentaires</h2>


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
											<div>
												<form action="back_forum_verif.php" method="post">
													<button class="topic__action__btn" type="submit" name="supp-com" value="<?= $rc['id'] ?>" style="background-color: <?= $background_Jaune?>;">
														<i class="bi bi-trash2 btn__trash"></i>
													</button>
												</form>
												
											</div>

										</div>
									</div>
								</a>
								<?php		
								}
								?>

								<div id="pagination" class="mb-2">

								<?php
								if($pagesTotales_commentaire > 1) {

									if($pageCourante_commentaire > 1) {
										?>
										<a style="border-radius: 10px;" class="page-numbers" href="back_forum.php?page_commentaire=<?= $pageCourante_commentaire-1 ?>">Précédent</a>
										<?php
									} else {
										?>
										<span style="border-radius: 10px;" class="page-numbers disabled">Précédent</span>
										<?php
									}

									for($j=1;$j<=$pagesTotales_commentaire;$j++){
										if($j == $pageCourante_commentaire){
											?>
											<span class="page-numbers current"><?= $j ?></span>
											<?php
										} elseif($j == 1 || $j == $pagesTotales_commentaire || ($j >= $pageCourante_commentaire-2 && $j <= $pageCourante_commentaire+2)) {
											?>
											<a class="page-numbers" href="back_forum.php?page_commentaire=<?= $j ?>"><?= $j ?></a>
											<?php
										} elseif($j == 2 || $j == $pagesTotales_commentaire-1) {
											?>
											<span class="page-numbers dots">...</span>
											<?php
										}
									}

									if($pageCourante_commentaire < $pagesTotales_commentaire) {
										?>
										<a style="border-radius: 10px;" class="page-numbers" href="back_forum.php?page_commentaire=<?= $pageCourante_commentaire+1 ?>">Suivant</a>
										<?php
									} else {
										?>
										<span style="border-radius: 10px;" class="page-numbers disabled">Suivant</span>
										<?php
									}
								}
								?>

								</div>
								</div>
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

