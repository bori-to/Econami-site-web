<?php session_start();

//connexion à la bdd
include('include/db.php');

$q = 'SELECT top FROM annonce WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([
	htmlspecialchars($_GET['id'])
]);

$req_top = $req->fetch();

$q = 'SELECT a.*, u.pseudo 
FROM annonce a
INNER JOIN users u on u.id = a.id_users
WHERE a.id = ?
ORDER BY a.date_creation DESC;
';
$req = $bdd->prepare($q);
$req->execute([
	htmlspecialchars($_GET['id'])
]);

$req_annonce = $req->fetch();

if($req_annonce['valide'] == 3 && $_SESSION['points'] < 250 && $_SESSION['type'] != 1){ 
	header('location:achats.php');
  exit;
}

if($req_annonce['valide'] == 3 && $_SESSION['type'] != 1){
	if($req_annonce['date_creation'] > date("Y-m-d H:i:s", time())){
		header('location:achats.php');
  	exit;
	}
}

if(isset($_SESSION['id'])){
	$q = 'SELECT *
	FROM commande 
	WHERE id_users = ?
	';
	$req = $bdd->prepare($q);
	$req->execute([
		$_SESSION['id']
	]);

	$req_commande = $req->fetchAll();
}

if(isset($_SESSION['id'])){
	$q = 'SELECT COUNT(*) AS count FROM annonce a
	LEFT JOIN commande c ON a.id = c.id_annonce
	WHERE a.id = ? AND (a.id_users = ? OR c.id_users = ?);
	';
	$req = $bdd->prepare($q);
	$req->execute([
		htmlspecialchars($_GET['id']),
		$_SESSION['id'],
		$_SESSION['id']
	]);
	$req_coms = $req->fetch();
}

if(($req_annonce['valide'] == false && $_SESSION['type'] != 1 && $req_coms['count'] < 1)
	|| ($req_annonce['valide'] == '2' && $_SESSION['type'] != 1 && $req_coms['count'] < 1)){
	header('location:achats.php');
  exit;
}

if(!empty($_POST)){
  extract($_POST);

  $valid = true;

  if(isset($_POST['suppr_annonce'])){

    $suppr_annonce = $_POST['suppr_annonce'];

    if($req_annonce['valide'] == '2'){
    	$valid = false;
    	$msg = 'Votre annonce ne peut pas être supprimer elle correspond à une commande.';
      header('location:profil.php?type=success&message=' . $msg);
      exit;
    }

    if($valid){

      	$q = 'DELETE FROM annonce WHERE id = ?';
		$req = $bdd->prepare($q);
		$req->execute([
			htmlspecialchars($_GET['id'])
		]);
				if($_SESSION['type'] == 1){
					$msg = 'Annonce supprimer avec succès.';
	      	header('location:back_annonce.php?type=success&message=' . $msg);
	      	exit;
				}else{
	      	$msg = 'Votre annonce à était supprimer avec succès.';
	      	header('location:profil.php?type=success&message=' . $msg);
	      	exit;
	      }
    }
  }

  if(isset($_POST['valide_annonce'])){

    $valide_annonce = $_POST['valide_annonce'];

    if($_SESSION['type'] != '1'){
    	$valid = false;
    	$msg = "Vous êtes pas admin.";
      header('location:profil.php?type=success&message=' . $msg);
      exit;
    }

    if($valid){

    $q = 'UPDATE annonce SET valide = 1 WHERE id = ?';
		$req = $bdd->prepare($q);
		$req->execute([
			htmlspecialchars($_GET['id'])
		]);

      	$msg = "Annonce maintenant en ligne.";
      	header('location:back_annonce.php?type=success&message=' . $msg);
      	exit;
    }
  }
  if(isset($_POST['modifier_top'], $_POST['modifier_top_value'])){
    $top_value = $_POST['modifier_top_value'];
    $id = htmlspecialchars($_GET['id']);
    $q = 'UPDATE annonce SET top = CASE WHEN id = ? THEN ? ELSE 0 END WHERE top = ? OR id = ?;';
    $req = $bdd->prepare($q);
    $req->execute([$id, $top_value, $top_value, $id]);

    $msg = "L'annonce a été modifiée avec succès";
    header("location: achats_annonce.php?id=$id&type=success&message=$msg");
    exit;
}

}

$title = 'Annonce';
include('include/head.php');

$log = 'Annonce - id : ' . htmlspecialchars($_GET['id']);
if(isset($_SESSION['id'])){
	include('include/log.php');
	writeLog($log);
}
?>
	<link rel="stylesheet" type="text/css" href="css/style_achats.css">
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
	<body style="background-color: <?php echo $background_white;?>;">
		<?php include 'include/header.php' ?>
		<main>

			<div class="container-fluid">
				<div class="container">
					<div class="row">
						<div class="col-12 mb-4" style="background-color: <?php echo $background_marronClaire;?>; border-radius: 10px;">
							<h1 class="text-center">
								<?php echo $req_annonce['marque'] . ' - ' . $req_annonce['reduction'] . ' ' . $req_annonce['type']; ?> 
							</h1>
						</div>
					</div>
					<div class="row">
						<?php 

              				include('include/message.php');

              			?>

						<style>.alert{width: 50%;</style>
						<div class="col-md-9 col-xs-12 annonce__info" id="annonce" style="background-color: <?php echo $background_white;?>;">
							<div class="row">
								<div class="col-md-12 col-xs-12 annonce__info__marque text-center">
									Marque : <?= $req_annonce['marque'] ?>
								</div>
								<div class="col-md-4 col-sm-2 text-center">
									<?php
									if(isset($_SESSION['id']) && $_SESSION['type'] == '1' && $req_annonce['valide'] == '0'){       
												$res = false;
												?>
												<form method="post">
													<input type="hidden" name="suppr_annonce">
				                    <button class="btn__panier" type="submit" style="background-color: #b71540; width: 100px; font-size: .8rem;">
				                      Supprimer l'annonce
				                    </button>
												</form>
												<form method="post">
													<input type="hidden" name="valide_annonce">
				                    <button class="btn__panier" type="submit" style="background-color: #78e08f; width: 100px; font-size: .8rem;">
				                      Valider l'annonce
				                    </button>
												</form>
												<?php
											} elseif(isset($_SESSION['id']) && $_SESSION['type'] == '1' && $req_annonce['valide'] == '1'){       
												$res = false;
												?>
												<form method="post">
													<label class="form-label">Modifier son TOP</label>
													<select name="modifier_top_value" class="form-select">
														<?php
														$tops = array("aucun", "Top 1", "Top 2", "Top 3");
														foreach($tops as $key => $top){
															?>
															<option value="<?= $key ?>" <?= $key == $req_annonce['top'] ? "selected" : "" ?>><?= $top ?></option>
															<?php
														}
														?>
													</select>
													<div class="mt-4">
														<input type="hidden" name="modifier_top" value="<?= $req_annonce['id'] ?>">
														<button class="btn btn-secondary" type="submit">
															Modifier
														</button>    
													</div>
												</form>
												<?php
											} 
											?>

								</div>
								<div class="col-md-4 col-sm-8 annonce__info__reduction text-center">
									Réduction :
									<div>
										<?= $req_annonce['reduction'] ?>
										<?= $req_annonce['type'] ?>
									</div>
								</div>
								<div class="col-md-4 col-sm-2"></div>
								<div class="col-md-4 col-sm-2"></div>
								<div class="col-md-4 col-sm-8 annonce__info__expiration">
									Date d'expiration : <?= date_format(date_create($req_annonce['date_expiration']), 'd/m/Y') ?>
								</div>
								<div class="col-md-4 col-sm-2"></div>
								<div class="col-md-4 col-sm-2"></div>
								<div class="col-md-4 col-sm-8 annonce__info__creation">
									Date de création : <?= date_format(date_create($req_annonce['date_creation']), 'd/m/Y') ?>
								</div>
								<div class="col-md-4 col-sm-2"></div>
								<div class="col-md-4 col-sm-2"></div>
								<div class="col-md-4 col-sm-8 annonce__info__pseudo">
									Vendeur : <?= $req_annonce['pseudo'] ?>
								</div>
								<div class="col-md-4 col-sm-2"></div>
								<div class="col-md-4 col-sm-2"></div>
								<div class="col-md-4 col-sm-8 annonce__info__prix text-center">
									Prix : <?= $req_annonce['prix'] . ' €' ?>
								</div>
								<?php
								$coupon = false;
								$commande = 0;
								if(isset($_SESSION['id'])){
									foreach($req_commande as $com){
										if($com['id_annonce'] == htmlspecialchars($_GET['id'])){
											$commande = $commande + 1;
										}
									}
									if($req_annonce['id_users'] == $_SESSION['id'] 
										|| $commande == 1
										|| $_SESSION['type'] == '1'){
										?>
										<div class="col-md-4 col-sm-2"></div>
												<div class="col-md-4 col-sm-2"></div>
												<div class="col-md-4 col-sm-8 annonce__info__prix text-center">
													Coupon : <div style="font-size: 1.2rem;"><?= $req_annonce['coupon'] ?></div>
												</div>
										<?php
									}
								}
								?>
								<div class="col-md-4 col-sm-2"></div>
								<div class="col-md-4 col-sm-2"></div>
								<div class="col-md-4 col-sm-8 text-center">
									<?php
									if(isset($_COOKIE['panier']) AND !empty($_COOKIE['panier'])) {   // je vérifie que le cookie existe
										$panier = unserialize($_COOKIE['panier']);
										$res = true;
										foreach($panier as $contenue){
											if( $req_annonce['id'] == $contenue['id']){
												$res = false;
												?>
												<button class="btn__panier">
														Coupon déjà dans le panier
												</button>
												<?php
											}
				                        }

				                        if($req_annonce['valide'] == '2'){
											?>
											<button class="btn__panier">
												Coupon acheter
											</button>
											<?php
										}
				                        
				                        if(isset($_SESSION['id'])){
					                        if( $req_annonce['id_users'] == $_SESSION['id'] && $req_annonce['valide'] != '2'){
												$res = false;
												?>
												<form method="post">
													<input type="hidden" name="suppr_annonce">
				                    <button class="btn__panier" type="submit" style="background-color: #b71540;">
				                      Supprimer l'annonce
				                    </button>
												</form>
												<?php
											}
										}

				                        if($res == true){
				                        	if(isset($_COOKIE['panier']) AND empty($_COOKIE['panier'])) {
				                        		unset($_COOKIE['panier']);
				                        		setcookie('panier', '', time() - 3600, '/');
				                        	}
				                        	?>

				                        	<button class="btn__panier" style="background-color: <?= $background_Jaune?>;">
												<a style="color: snow;" class="body__link__achat" href="panier_ajout_cookie.php?id=<?= $req_annonce['id'] ?>">
													Ajouter au panier
												</a>
											</button>
											<?php
				                        }
									}else{
										if(isset($_SESSION['id']) AND $req_annonce['id_users'] == $_SESSION['id'] && $req_annonce['valide'] != '2'){
											$res = false;
											?>
											<form method="post">
												<input type="hidden" name="suppr_annonce">
				                                <button class="btn__panier" type="submit" style="background-color: #b71540;">
				                                    Supprimer l'annonce
				                                </button>
											</form>
											<?php
										}elseif($req_annonce['valide'] == '2'){
											?>
											<button class="btn__panier">
												Coupon acheter
											</button>
											<?php
										
										}else{
									?>

									<button class="btn__panier" style="background-color: <?= $background_Jaune?>;">
										<a style="color: snow;" class="body__link__achat" href="panier_ajout_cookie.php?id=<?= $req_annonce['id'] ?>">
											Ajouter au panier
										</a>
									</button>
									<?php
										}
									}
									?>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-xs-12">
							<img class="text-center img__annonce__logo img-fluid" src="images/econami.png" alt="Logo econami" height="60px">
						</div>
					</div>
					<?php
						if(isset($_SESSION['id']) && $_SESSION['type'] == '1'){
												?>
							<div class="btn btn-secondary">
				    	<a href="back_annonce.php" style="text-decoration: none; color: #DCD488;">
				    		Gérer les annonces
				    	</a>
				    </div>
				  <?php } ?>
				</div>
			</div>
		
		</main>

		<?php include 'include/footer.php' ?>
	</body>
	<script src="js/bootstrap.min.js"></script>
</html>

