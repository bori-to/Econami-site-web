<?php session_start(); 
if(!isset($_SESSION['email']) || $_SESSION['type'] === '0'){
	header('location:index.php');
	exit;
}
//connexion à la bdd
include('include/db.php');
$q = 'SELECT * FROM users';
$req = $bdd->prepare($q);
$reponse = $bdd->query($q);

$title = 'Administrateur - captcha';
include('include/head.php');
?>

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
						<li class="breadcrumb-item active" aria-current="page">Captcha</li>
						<li style="margin-left: 150px;">
							<?php 

              				include('include/message.php');

              				?>
						</li>
					</ol>
				</nav>
				<div class="row">
					<div class="col-12">
						<h1>Captcha</h1>
					</div>
					<div class="line"></div>
					<br>
					<form method="post" action="captcha/decouper_image.php" enctype="multipart/form-data">
        				<label for="image_file">Sélectionner une image à ajouter en captcha :</label>
        				<input class="form-control" type="file" name="image_file" id="image_file">
        				<?php
						if (is_dir("captcha/1") 
							&& is_dir("captcha/2")
							&& is_dir("captcha/3")
							&& is_dir("captcha/4")
							&& is_dir("captcha/5")) {
  							echo "<h4 style='color: red;'>Il y a déja trop de captcha en place supprimer pour ajouter</h4>"; 
						} else {
  							?><input class="btn btn-primary" type="submit" value="Découper l'image et l'ajouter">
  						<?php
  						}
						?>
        				
    				</form>
    				<div><br></div>
    				<div class="line"></div>
					<br>

    				<?php

					function image($dir){	
						// Ouvre le dossier
						if (is_dir($dir)){
  							// Parcours tous les fichiers du dossier
							if ($dh = opendir($dir)){
    							$count = 0; // Initialisation du compteur
    							while (($file = readdir($dh)) !== false){
      								// Vérifie si le fichier est une image
    								if(in_array(pathinfo($file, PATHINFO_EXTENSION), array('jpg', 'jpeg', 'png', 'gif'))) {
        								// Affiche l'image
    									echo "
    									<img src='$dir/$file' alt='$file' style='display: inline-block; width: 33.33%; height: 200px;'>
    									";
        								$count++; // Incrémente le compteur
        								// Retourne à la ligne après chaque troisième image
        								if($count % 3 == 0) {
        								echo "<br>";
        								}
    								}
								}
								closedir($dh);
							}
						}
					}

					function supprimer_dossier($dir) {
  						if(is_dir($dir)) {
    						$objects = scandir($dir);
    						foreach($objects as $object) {
      							if($object != "." && $object != "..") {
        							if(filetype($dir."/".$object) == "dir") {
          								supprimer_dossier($dir."/".$object);
        							}
        							else {
          								unlink($dir."/".$object);
        							}
      							}
    						}
    						reset($objects);
    						rmdir($dir);
  						}
					}



					// Le chemin vers le dossier contenant les images
					if(isset($_POST['supprimer_dossier1'])) { 
  						// Appelle la fonction pour supprimer le dossier
  						supprimer_dossier("captcha/1");
					}
					?>
					<h1>Supprimer captcha 1</h1>
  						<form method="post">
    						<p>
      							Êtes-vous sûr de vouloir supprimer le captcha ? Cette action est irréversible !
    						</p>
    						<input class="btn btn-danger" type="submit" name="supprimer_dossier1" value="Supprimer le captcha numero 1">
  						</form><div><br></div><?php
					image("captcha/1"); ?><div><br></div> <div class="line"></div> <div><br></div>


					<?php
					if(isset($_POST['supprimer_dossier2'])) { 
  						// Appelle la fonction pour supprimer le dossier
  						supprimer_dossier("captcha/2");
					}
					?>
					<h1>Supprimer captcha 2</h1>
  						<form method="post">
    						<p>
      							Êtes-vous sûr de vouloir supprimer le captcha ? Cette action est irréversible !
    						</p>
    						<input class="btn btn-danger" type="submit" name="supprimer_dossier2" value="Supprimer le captcha numero 2">
  						</form><div><br></div>
					<?= image("captcha/2"); ?><div><br></div> <div class="line"></div> <div><br></div>

					<?php
					if(isset($_POST['supprimer_dossier3'])) { 
  						// Appelle la fonction pour supprimer le dossier
  						supprimer_dossier("captcha/3");
					}
					?>
					<h1>Supprimer captcha 3</h1>
  						<form method="post">
    						<p>
      							Êtes-vous sûr de vouloir supprimer le captcha ? Cette action est irréversible !
    						</p>
    						<input class="btn btn-danger" type="submit" name="supprimer_dossier3" value="Supprimer le captcha numero 3">
  						</form><div><br></div>
					<?= image("captcha/3"); ?><div><br></div> <div class="line"></div> <div><br></div>

					<?php
					if(isset($_POST['supprimer_dossier4'])) { 
  						// Appelle la fonction pour supprimer le dossier
  						supprimer_dossier("captcha/4");
					}
					?>
					<h1>Supprimer captcha 4</h1>
  						<form method="post">
    						<p>
      							Êtes-vous sûr de vouloir supprimer le captcha ? Cette action est irréversible !
    						</p>
    						<input class="btn btn-danger" type="submit" name="supprimer_dossier4" value="Supprimer le captcha numero 4">
  						</form><div><br></div>
					<?= image("captcha/4"); ?><div><br></div> <div class="line"></div> <div><br></div>

					<?php
					if(isset($_POST['supprimer_dossier5'])) { 
  						// Appelle la fonction pour supprimer le dossier
  						supprimer_dossier("captcha/5");
					}
					?>
					<h1>Supprimer captcha 5</h1>
  						<form method="post">
    						<p>
      							Êtes-vous sûr de vouloir supprimer le captcha ? Cette action est irréversible !
    						</p>
    						<input class="btn btn-danger" type="submit" name="supprimer_dossier5" value="Supprimer le captcha numero 5">
  						</form><div><br></div>
					<?= image("captcha/5"); ?><div><br></div> <div class="line"></div> <div><br></div>

				</div>
			</div>
			<div><br><br></div>
		</main>

		<?php include 'include/footer.php' ?>
	</body>
	<script src="js/bootstrap.min.js"></script>
</html>

