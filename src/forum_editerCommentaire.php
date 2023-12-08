<?php session_start();
$title = 'Editer mon commentaire';
include('include/head.php');

if(!isset($_SESSION['email'])){
	header('location:forum.php');
	exit;
}

include('include/db.php');

if(!isset($_GET['id'])){
	header('location:forum.php');
	exit;
}

$get_id_topic_commentaire = (int) $_GET['id'];

if($get_id_topic_commentaire <= 0){
	header('location:forum.php');
	exit;
}

$q = 'SELECT *
FROM topic_commentaire
WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([$get_id_topic_commentaire]);

$req_topic_commentaire = $req->fetch();

if(!isset($req_topic_commentaire['id'])){
	header('location:forum.php');
	exit;
}

if($req_topic_commentaire['id_users'] !== $_SESSION['id']){
	header('location:forum_topic.php?id=' . $req_topic_commentaire['id_topic']);
	exit;
}


if(!empty($_POST)){
	extract($_POST);

	$valid = true;

	if(isset($_POST['modification'])){

		$commentaire = (String) trim($commentaire);

		if(empty($commentaire)){
			$valid = false;
			$err_commentaire = "Ce champ ne peut pas être vide";
		}elseif(strlen($commentaire) < 4){
			$valid = false;
			$err_commentaire = "Le commentaire doit faire plus de 3 caractères";
		}

		if($valid){

			$date_modification = date('Y-m-d H:i;s');

			$q = 'UPDATE topic_commentaire
			SET contenu = ?, date_modification = ?
			WHERE id = ?';
			$req = $bdd->prepare($q);
			$req->execute([
				$commentaire, $date_modification, $req_topic_commentaire['id']
			]);


			header('location:forum_topic.php?id=' . $req_topic_commentaire['id_topic']);
			exit;

		}
	}
}

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
					<div class="col-md-3 col-xs-0"></div>
					<div class="col-md-6 col-xs-12">
						<h1>Editer mon commentaire</h1>
					<form method="post">
						<div class="mb-3">
							<?php if(isset($err_commentaire)){ echo '<div class="topic__zone__error">' . $err_commentaire . '</div>'; } ?>
							<label class="form-label">Commentaire</label>
							<textarea class="form-control" type="text" name="commentaire" placeholder="Votre commentaire ..."><?php if(isset($commentaire)){ echo $commentaire; }else{ echo htmlspecialchars($req_topic_commentaire['contenu']); } ?></textarea>
						</div>
						<div class="mb-3">
							<button type="submit" name="modification" class="forum__btn__create" style="background-color: <?= $background_Jaune?>;">Modifier mon commentaire</button>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
		
		</main>

		<?php include 'include/footer.php' ?>
	</body>
	<script src="js/bootstrap.min.js"></script>
</html>

