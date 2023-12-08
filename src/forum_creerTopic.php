<?php session_start();
$title = 'Créer un topic';
include('include/head.php');

if(!isset($_SESSION['email'])){
	header('location:connexion.php');
	exit;
}

include('include/db.php');

$q = 'SELECT id,titre FROM forum';
$req = $bdd->prepare($q);
$req->execute();

$req_forum = $req->fetchAll();

if(!empty($_POST)){
	extract($_POST);

	$valid = true;

	if(isset($_POST['creation'])){

		$titre = (String) ucfirst(trim($titre));
		$categorie = (int) $categorie;
		$contenu = (String) trim($contenu);

		if(empty($titre)){
			$valid = false;
			$err_titre = "Ce champ ne peut pas être vide";
		}elseif(strlen($titre) < 4){
			$valid = false;
			$err_titre = "Le titre doit faire plus de 3 caractères";
		}elseif(strlen($titre) > 50){
			$valid = false;
			$err_titre = "Le titre doit faire moins de 51 caractères (" . strlen($titre) . "/50)";
		}

		$q = 'SELECT id,titre FROM forum WHERE id = ?';
		$req = $bdd->prepare($q);
		$req->execute([$categorie]);

		$req_forum_verif = $req->fetch();

		if(!isset($req_forum_verif['id'])){
			$valid = false;
			$categorie = null;
			$err_cat = "Cette catégorie n'existe pas";
		}

		if(empty($contenu)){
			$valid = false;
			$err_contenu = "Ce champ ne peut pas être vide";
		}elseif(strlen($contenu) < 4){
			$valid = false;
			$err_contenu = "Le contenu doit faire plus de 3 caractères";
		}

		if($valid){

			$date_creation = date('Y-m-d H:i;s');

			$q = 'INSERT INTO topic
			(id_forum, titre, contenu, date_creation, date_modification, id_users)
			VALUES (?, ?, ?, ?, ?, ?)';
			$req = $bdd->prepare($q);
			$req->execute([			
				$req_forum_verif['id'],
				$titre,
				$contenu,
				$date_creation, 
				$date_creation,
				$_SESSION['id']
			]);

			$UID = $bdd->lastInsertId();

			if($UID >= 0){
				header('location:forum_topic.php?id=' . $UID);
				exit;
			}else{
				header('location:forum.php');
				exit;
			}

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
						<h1>Créer un topic</h1>
					<form method="post">
						<div class="mb-3">
							<?php if(isset($err_titre)){ echo '<div class="topic__zone__error">' . $err_titre . '</div>'; } ?>
							<label class="form-label">Titre</label>
							<input class="form-control" type="text" name="titre" value="<?php if(isset($titre)){ echo htmlspecialchars($titre); } ?>" placeholder="Titre">
						</div>
						<div class="mb-3">
							<?php if(isset($err_cat)){ echo '<div class="topic__zone__error">' . $err_cat . '</div>'; } ?>
							<label class="form-label">Catégorie</label>
							<select name="categorie" class="form-select">
								<?php 
									if(isset($categorie)){
										echo '<option value="' . $req_forum_verif['id'] . '">' . $req_forum_verif['titre'] . '</option>';
									}else{
										echo '<option hidden>Choississez votre catégorie</option>';
									}
								?>

								<?php
									foreach($req_forum as $rf){
								?>
								<option value="<?= $rf['id'] ?>"><?= $rf['titre'] ?></option>
								<?php		
									}
								?>
							</select>
						</div>
						<div class="mb-3">
							<?php if(isset($err_contenu)){ echo '<div class="topic__zone__error">' . $err_contenu . '</div>'; } ?>
							<label class="form-label">Contenu</label>
							<textarea class="form-control" type="text" name="contenu" placeholder="Votre topic ..."><?php if(isset($contenu)){ echo htmlspecialchars($contenu); } ?></textarea>
						</div>
						<div class="mb-3">
							<button type="submit" name="creation" class="forum__btn__create" style="background-color: <?= $background_Jaune?>;">Créer mon topic</button>
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

