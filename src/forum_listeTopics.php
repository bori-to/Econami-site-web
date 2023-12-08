<?php session_start();

//connexion à la bdd
include('include/db.php');

if(!isset($_GET['id'])){
	header('location:forum.php');
	exit;
}

$get_id_forum = (int) $_GET['id'];

if($get_id_forum <= 0){
	header('location:forum.php');
	exit;
}

$q = 'SELECT * FROM forum WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([$get_id_forum]);

$req_forum = $req->fetch();

$q = 'SELECT t.*, u.pseudo, u.image 
FROM topic t
INNER JOIN users u on u.id = t.id_users
WHERE t.id_forum = ?
ORDER BY t.date_creation DESC';
$req = $bdd->prepare($q);
$req->execute([$get_id_forum]);

$req_listeTopics = $req->fetchAll();

$title = 'Forum - ' . $req_forum['titre'];
include('include/head.php');

if(isset($_SESSION['id'])){
	include('include/log.php');
	writeLog($title);
}
?>
	<link rel="stylesheet" type="text/css" href="css/styleforum.css">
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
				<div class="row">
					<div class="col-md-2 col-xs-0"></div>
					<div class="col-md-8 col-xs-12">
						<div class="list__topic__body">
							<h1 class="list__topic__h1"><?php echo $req_forum['titre'] ?></h1>
							<div>
								<?php
									foreach($req_listeTopics as $rlt){

										$q = 'SELECT COUNT(id) AS NbCommentaire
										FROM topic_commentaire
										WHERE id_topic = ?';
										$req = $bdd->prepare($q);
										$req->execute([
											$rlt['id']
										]);

										$req_nb_commentaire = $req->fetch();
										$nb_commentaire = $req_nb_commentaire['NbCommentaire'];

										$chemin_avatar = null;

										if(isset($rlt['image'])){
											$chemin_avatar = 'avatar/' .  $rlt['image'];
										}else{
											$chemin_avatar = 'avatar/defaut/icon_profil.svg';
										}
								?>
								<a href="forum_topic.php?id=<?= $rlt['id'] ?>" class="list__topic__link">
									<div class="list__topic__sujet" style="background-color: <?= $background_marronClaire?>;">
										<div><?= $rlt['titre'] ?></div>
										<div class="list__topic__footer">
											<div>
												<img src="<?= $chemin_avatar ?>" class="profil__avatar" width="16" height="16">
												<?= $rlt['pseudo'] ?>
											</div>
											<div><i class="bi bi-chat-dots" style="margin-right: 2px;"></i><?= $nb_commentaire ?></div>
											<?php
												if($rlt['date_creation'] < $rlt['date_modification']){
											?>
												<div>Modifié le <?= date_format(date_create($rlt['date_modification']), 'd/m/Y à H:i') ?></div>
											<?php
												}else{
													?>
													<div>Le <?= date_format(date_create($rlt['date_creation']), 'd/m/Y à H:i') ?></div>
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
				</div>
			</div>
		</div>
		
		</main>

		<?php include 'include/footer.php' ?>
	</body>
	<script src="js/bootstrap.min.js"></script>
</html>

