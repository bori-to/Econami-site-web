<?php

//connexion à la bdd
include('include/db.php');

// Si email et mdp existe en bdd : redirection
$q = 'SELECT * FROM forum ORDER BY ordre';
$req = $bdd->prepare($q);
$req->execute();

$req_forum = $req->fetchAll();

$title = 'Catégories';
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
							<div class="forum__body">
								<h1 class="forum__h1">Forum</h1>

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
						</div>
					</div>
				</div>
			</div>
		
		</main>

		<?php include 'include/footer.php' ?>
	</body>
	<script src="js/bootstrap.min.js"></script>
</html>

