<?php session_start();
$title = 'Modifier mon avatar';
include('include/head.php');

if(!isset($_SESSION['email'])){
	header('location:connexion.php');
	exit;
}

if(isset($_SESSION['id'])){
	include('include/log.php');
	writeLog($title);
}

if(!empty($_POST)){
	extract($_POST);

	if(isset($_POST['register'])){
		$msg = 'Avatar modifier avec succès';
		header('location:avatar_create.php?type=success&message=' . $msg);
		exit;
	}
}

?>
<link rel="stylesheet" type="text/css" href="css/styleforum.css">
<style type="text/css">
	#avatar {
	  position: relative;
	  display: inline-block;
	}

	.corps {
	  position: absolute;
	  top: 0;
	  left: 0;
	  z-index: 0;
	}

	.chapeau {
	  position: absolute;
	  top: 0;
	  left: 0;
	  z-index: 1;
	}

	.element1 {
	  position: absolute;
	  top: 0;
	  left: 0;
	  z-index: 2;
	}

	.element2 {
	  position: absolute;
	  top: 0;
	  left: 0;
	  z-index: 3;
	}

	img.corps, img.chapeau, img.element1, img.element2 {
	  width: 150px;
	  height: 150px;
	  border-radius: 50%;
	}

</style>
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

		<div class="container-fluid" style="background-color: <?= $background_marronClaire?>;">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-xs-0"></div>
					<div class="col-md-6 col-xs-12">
						<h1 id="h1">Modifier mon avatar</h1>
						<div id="success-message" style="display:none" class="alert alert-success alert-dismissible fade show">
							Avatar modifié avec succès !
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>

              			<div class="container">
              				<div class="row">
              					<div class="col-md-6 col-12">
								<form method="post" id="avatar-form">
							      <label for="corps">Corps :</label>
							      <select id="corps" name="corps" class="form-select">
							        <option value="image_avatar/corps/body_gris.png">Corps gris</option>
							        <option value="image_avatar/corps/body_jaune.png">Corps jaune</option>
							        <option value="image_avatar/corps/body_bleu.png">Corps bleu</option>
							        <option value="image_avatar/corps/body_rouge.png">Corps rouge</option>
							        <option value="image_avatar/corps/body_vert.png">Corps vert</option>
							        <?php
							        if($_SESSION['points'] >= 250){
							        ?>
							        <option value="image_avatar/corps/body_vip.png">Corps VIP</option>
							        <?php
							        } else {?>
							        	<option value="image_avatar/corps/body_vip.png" disabled>Corps VIP</option>
							        <?php }
							        ?>
							      </select>
							  	</div>

							  	<div class="col-md-6 col-12">
							      <label for="chapeau">Chapeau :</label>
							      <select id="chapeau" name="chapeau" class="form-select">
							        <option value="0">Aucun</option>
							        <option value="image_avatar/chapeaux/chapeau1.png">Chapeau Indiana Jones</option>
							        <option value="image_avatar/chapeaux/chapeau2.png">Chapeau haut de forme</option>
							        <option value="image_avatar/chapeaux/chapeau3.png">Casquette</option>
							        <option value="image_avatar/chapeaux/chapeau4.png">Chapeau cowboy</option>
							        <option value="image_avatar/chapeaux/chapeau5.png">Calvitie</option>
							        <option value="image_avatar/chapeaux/chapeau6.png">Chapeau de paille</option>
							        <option value="image_avatar/chapeaux/chapeau7.png">Naruto</option>
							        <?php
							        if($_SESSION['points'] >= 250){
							        ?>
							        <option value="image_avatar/chapeaux/chapeau8.png">Couronne VIP</option>
							        <?php
							        } else {?>
							        	<option value="image_avatar/chapeaux/chapeau8.png" disabled>Couronne en or (Disponible pour les VIP)</option>
							        <?php }
							        ?>
							      </select>
							  	</div>

							  	<div class="col-md-6 col-12">
							      <label for="element1">Element 1 :</label>
							      <select id="element1" name="element1" class="form-select">
							        <option value="0">Aucun</option>
							        <option value="image_avatar/ele1/elt1_ecouteur.png">Ecouteurs</option>
							        <option value="image_avatar/ele1/elt1_lunette.png">Lunettes</option>
							        <option value="image_avatar/ele1/elt1_medaille.png">Médaille</option>
							        <option value="image_avatar/ele1/elt1_masque.png">Masque</option>
							        <option value="image_avatar/ele1/elt1_bras.png">Bras de robot</option>
							        <option value="image_avatar/ele1/elt1_robot.png">Robot</option>
							        <?php
							        if($_SESSION['points'] >= 250){
							        ?>
							        <option value="image_avatar/ele1/elt1_vip.png">Boucle d'oreille en or</option>
							        <?php
							        } else {?>
							        	<option value="image_avatar/ele1/elt1_vip.png" disabled>Boucle d'oreille VIP (Disponible pour les VIP)</option>
							        <?php }
							        ?>
							      </select>
							    </div>

							    <div class="col-md-6 col-12">
							      <label for="element2">Element 2 :</label>
							      <select id="element2" name="element2" class="form-select">
							        <option value="0">Aucun</option>
							        <option value="image_avatar/ele2/elt2_barbe.png">Barbe</option>
							        <option value="image_avatar/ele2/elt2_costume.png">Costume</option>
							        <option value="image_avatar/ele2/elt2_cravate.png">Cravate</option>
							        <option value="image_avatar/ele2/elt2_nike.png">Chaussure</option>
							        <option value="image_avatar/ele2/elt2_moustache.png">Moustache</option>
							        <option value="image_avatar/ele2/elt2_arme.png">AK 47</option>
							        <option value="image_avatar/ele2/elt2_bouclier.png">Bouclier</option>
							        <option value="image_avatar/ele2/elt2_phone.png">Iphone</option>
							        <option value="image_avatar/ele2/elt2_banane.png">Banane sacoche</option>
							        <option value="image_avatar/ele2/elt2_chien.png">Chien</option>
							        <?php
							        if($_SESSION['points'] >= 250){
							        ?>
							        <option value="image_avatar/ele2/elt2_vip.png">Carte VIP</option>
							        <?php
							        } else {?>
							        	<option value="image_avatar/ele2/elt2_vip.png" disabled>Carte VIP (Disponible pour les VIP)</option>
							        <?php }
							        ?>
							      </select>
							    </div>
							    <div class="col-12 mt-4">
							    	<button type="submit" name="avatar" class="forum__btn__create" style="background-color: <?= $background_Jaune?>;">Modifier</button>
							    </div>
							    </form>
							    <div id="avatar">
							      <img src="image_avatar/corps/body_gris.png" alt="Avatar" class="corps">
							    </div>
							    
							    <div style="margin-top: 150px;" class="mb-4">
							    	<button id="save-btn" class="forum__btn__create" style="background-color: <?= $background_Jaune?>;">Enregistrer</button></br>
							    	<a href="profil.php" id="btn_retour" class="forum__btn__create" style="background-color: <?= $background_Jaune?>; width: 70px;">Retour</a>
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
	<script src="js/avatar.js"></script>
</html>