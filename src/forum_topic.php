<?php session_start();

//connexion à la bdd
include('include/db.php');


if(!isset($_GET['id'])){
	header('location:forum.php');
	exit;
}

$get_id_topic = (int) $_GET['id'];

if($get_id_topic <= 0){
	header('location:forum.php');
	exit;
}

$q = 'SELECT t.*, u.pseudo, u.image, u.points, f.titre AS titre_forum
	FROM topic t
	INNER JOIN users u ON u.id = t.id_users
	INNER JOIN forum f ON f.id = t.id_forum
	WHERE t.id = ?
	ORDER BY t.date_creation DESC';
$req = $bdd->prepare($q);
$req->execute([$get_id_topic]);

$req_topic = $req->fetch();

if($_SESSION['points'] < 250 && $req_topic['id_forum'] == 3){
	header('location:forum.php');
	exit;
}

if(!isset($req_topic['id'])){
	header('location:forum.php');
	exit;
}

$q = 'SELECT tc.*, u.pseudo, u.image, u.points
FROM topic_commentaire tc
INNER JOIN users u ON u.id = tc.id_users
WHERE tc.id_topic = ?
ORDER BY tc.date_creation DESC
';
$req = $bdd->prepare($q);
$req->execute([$req_topic['id']]);

$req_topic_commentaires = $req->fetchAll();

if(!empty($_POST)){
	extract($_POST);

	$valid = true;

	if(isset($_POST['poster'])){

		$commentaire = (String) trim($commentaire);

		if(empty($commentaire)){
			$valid = false;
			$err_commentaire = "Ce champ ne peut pas être vide";
		}elseif(strlen($commentaire) < 4){
			$valid = false;
			$err_commentaire = "Le commentaire doit faire plus de 3 caractères";
		}

		if($valid && isset($_SESSION['id'])){

			$date_creation = date('Y-m-d H:i;s');

			$q = 'INSERT INTO topic_commentaire
			(id_topic, id_users, contenu, date_creation, date_modification)
			VALUES (?, ?, ?, ?, ?)';
			$req = $bdd->prepare($q);
			$req->execute([
				$req_topic['id'], $_SESSION['id'], $commentaire, $date_creation, $date_creation
			]);

			header('location:forum_topic.php?id=' . $req_topic['id']);
			exit;
		}
	}elseif(isset($_POST['supp-com'])){

		$id_com = (int) $id_com;

		if($id_com <= 0){
			$valid = false;
			$err_commentaire = "Impossible de supprimer ce commentaire";
		}else{
			$q = 'SELECT id
			FROM topic_commentaire
			WHERE id = ? AND id_users = ?
			';
			$req = $bdd->prepare($q);
			$req->execute([
				$id_com, $_SESSION['id']
			]);

			$req_verif_com = $req->fetch();

			if(!isset($req_verif_com['id'])){
				$valid = false;
				$err_commentaire = "Impossible de supprimer ce commentaire";
			}
		}



		if($valid && isset($_SESSION['id'])){

			$q = 'DELETE FROM topic_commentaire
			WHERE id = ?
			';
			$req = $bdd->prepare($q);
			$req->execute([
				$req_verif_com['id']
			]);

			header('location:forum_topic.php?id=' . $req_topic['id']);
			exit;
		}
	}elseif(isset($_POST['supp-topic'])){

		if($_SESSION['id'] !== $req_topic['id_users'] && $_SESSION['type'] !== '1'){
			$valid = false;
			$err_topic = "Impossible de supprimer ce commentaire";
		}

		if($valid && isset($_SESSION['id'])){

			$q = 'DELETE FROM topic_commentaire
			WHERE id_topic = ?
			';
			$req = $bdd->prepare($q);
			$req->execute([
			$req_topic['id']
			]);

			$q = 'DELETE FROM topic
			WHERE id = ?
			';
			$req = $bdd->prepare($q);
			$req->execute([
			$req_topic['id']
			]);

			header('location:forum_topic.php');
			exit;

		}
	}
}

$title = 'Forum - ' . $req_topic['titre'];
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
						<div class="topic__body">
						<h1 class="topic__body__h1"><?php echo $req_topic['titre'] ?></h1>
					
						<?php if(isset($err_topic)){ echo '<div>' . $err_topic . '</div>'; } ?>
						<?php 
							if((isset($_SESSION['id']) && $_SESSION['id'] === $req_topic['id_users']) || (isset($_SESSION['type']) && $_SESSION['type'] === '1')){
						?>
						<div class="topic__body__action__btn">
							<div>
								<form method="post">
									<button class="topic__action__btn" type="submit" name="supp-topic" style="background-color: <?= $background_Jaune?>;">
										<i class="bi bi-trash2 btn__trash"></i>Supprimer mon topic
									</button>
								</form>
							</div>
							<div>
								<a class="topic__action__btn" href="forum_editerTopic.php?id=<?= $req_topic['id'] ?>" style="background-color: <?= $background_Jaune?>;">
								<i class="bi bi-pen btn__edit"></i>Editer mon topic
								</a>
							</div>
						</div>
						<?php
						}
						?>
						<?php
						$chemin_avatar = null;

						if(isset($req_topic['image'])){
							$chemin_avatar = 'avatar/' .  $req_topic['image'];
						}else{
							$chemin_avatar = 'avatar/defaut/icon_profil.svg';
						}
						?>
						<div class="topic__body__contenu"><?= nl2br($req_topic['contenu']) ?></div>
						<div class="topic__footer">
							<div style="<?php if($req_topic['points'] >= 250){ ?>
						                                    color: #DCD488;
						                                    <?php
						                                    }
						                                    ?>
						                                    ">
								<img src="<?= $chemin_avatar ?>" class="profil__avatar" width="16" height="16">
								<?= $req_topic['pseudo'] ?>
							</div>
							<div class="topic__footer__cat" style="background-color: <?= $background_Jaune?>;"><?= $req_topic['titre_forum'] ?></div>
							<div>Le <?= date_format(date_create($req_topic['date_creation']), 'd/m/Y à H:i') ?></div>
							<?php
								if($req_topic['date_creation'] < $req_topic['date_modification']){
							?>
							<div>Modifié le <?= date_format(date_create($req_topic['date_modification']), 'd/m/Y à H:i') ?></div>
							<?php
							}
							?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="container">
				<div class="row">
					<div class="col-md-2 col-xs-0"></div>
					<div class="col-md-8 col-xs-12">
						<div class="topic__body">
							<h1 class="topic__body__h1">Commentaires</h1>
					
							<div class="topic__body__com">
								<form method="post">
									<div class="mb-3">
										<?php if(isset($err_commentaire)){ echo '<div class="topic__zone__error">' . $err_commentaire . '</div>'; } ?>
										<label class="form-label">Votre commentaire</label>
										<textarea class="topic__com__body__textarea" type="text" name="commentaire" placeholder="Votre commentaire ..."><?php if(isset($commentaire)){ echo $commentaire; } ?></textarea>
									</div>
									<div class="mb-3">
										<?php
										if(!isset($_SESSION['email'])){
										?>
										<div class="topic__com__footer__btn">
											<a href="connexion.php" class="topic__action__btn" style="background-color: <?= $background_Jaune?>;">
											<i class="bi bi-send btn__send"></i>Poster</a>
										</div>
										<?php
										}else{
										?>
										<div class="topic__com__footer__btn">
											<button type="submit" name="poster" class="topic__action__btn" style="background-color: <?= $background_Jaune?>;">
											<i class="bi bi-send btn__send"></i>Poster</button>
										</div>
										<?php
										}
										?>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<?php
						foreach($req_topic_commentaires as $rtc){
							$chemin_avatar = null;

							if(isset($rtc['image'])){
								$chemin_avatar = 'avatar/' .  $rtc['image'];
							}else{
								$chemin_avatar = 'avatar/defaut/icon_profil.svg';
							}
					?>
					<div class="col-md-2 col-xs-0"></div>
					<div class="col-md-8 col-xs-12">
						<div class="topic__com__body">
						<div class="topic__com__pseudo">
							<div style="<?php if($rtc['points'] >= 250){ ?>
						                                    color: #DCD488;
						                                    <?php
						                                    }
						                                    ?>
						                                    ">
								<img src="<?= $chemin_avatar ?>" class="profil__avatar" width="16" height="16">
								<?= $rtc['pseudo'] ?>
							</div>
						</div>
						<?php 
							if(isset($_SESSION['id']) && $_SESSION['id'] === $rtc['id_users']){
						?>
						<div class="topic__body__action__btn">
							<div>
								<form method="post">
									<button class="topic__action__btn" type="submit" name="supp-com" style="background-color: <?= $background_Jaune?>;">
										<i class="bi bi-trash2 btn__trash"></i>Supprimer mon commentaire
									</button>
									<input type="hidden" name="id_com" value="<?= $rtc['id'] ?>">
								</form>
							</div>
							<div>
								<a class="topic__action__btn" href="forum_editerCommentaire.php?id=<?= $rtc['id'] ?>" style="background-color: <?= $background_Jaune?>;"><i class="bi bi-pen btn__edit"></i>Editer mon commentaires</a>
							</div>
						</div>
						<?php
							}
						?>
						<div class="topic__body__contenu__com"><?= nl2br($rtc['contenu']) ?></div>
						<div class="topic__footer">
						<div>Le <?= date_format(date_create($rtc['date_creation']), 'd/m/Y à H:i') ?></div>
						<?php
							if($rtc['date_creation'] < $rtc['date_modification']){
						?>
							<div>Modifier le <?= date_format(date_create($rtc['date_modification']), 'd/m/Y à H:i') ?></div>
						<?PHP
							}
						?>
						</div>
						</div>
					</div>
					<div class="col-2"></div>
					<?php 
					}
					?>
				</div>
			</div>
		</div>
		
		</main>

		<?php include 'include/footer.php' ?>
	</body>
	<script src="js/bootstrap.min.js"></script>
</html>

