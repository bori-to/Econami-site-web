<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="css/light.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

<?php if(isset($_SESSION['email'])){ ?>
<?php
//connexion à la bdd
include('include/db.php');
if(isset($_SESSION['id'])){
	$q = 'SELECT * FROM users WHERE id = ?';
	$req = $bdd->prepare($q);
	$req->execute([$_SESSION['id']]);
	$avatar = $req->fetch();
}
$chemin_avatar = null;

if(isset($avatar['image'])){
	$chemin_avatar = 'avatar/' .  $avatar['image'];
}else{
	$chemin_avatar = 'avatar/defaut/icon_profil.svg';
} 
?>
	<div class="container">
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">


		<a href="index.php" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
			<img class="bi me-2" src="images/econami.png" alt="Logo econami" height="60px">
		</a>


		<nav class="navbar navbar-expand-lg">
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <img src="images/burger_menu.svg">
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
				<ul class="nav col-12 col-md-auto mb-2 mb-md-0">
				<li>
					<a id="titreC" style="color: black;" class="nav-link px-2 link space nav-link dropdown-toggle size">Vendre</a>
					<ul class="sub-menu dropdown-menu">
						<li>
							<a href="vente.php" title="Ouvrir" class="dropdown dropdown-item">Déposer une annonce</a>
						</li>
						<li>
							<a href="vente_info.php" title="Ouvrir" class="dropdown dropdown-item">Info</a>
						</li>
					</ul>
				</li>
				<li>
					<a style="color: black;" class="nav-link px-2 link space nav-link dropdown-toggle size">Achats</a>
					<ul class="sub-menu dropdown-menu">
						<li>
							<a href="achats.php" title="Ouvrir" class="dropdown dropdown-item">Recherche</a>
						</li>
						<li>
							<a href="achatsTop.php" title="Ouvrir" class="dropdown dropdown-item">TOP</a>
						</li>
						<li>
							<a href="achats_ventePrivee.php" title="Ouvrir" class="dropdown dropdown-item">Vente privée</a>
						</li>
					</ul>
				</li>
				<li>
					<a style="color: black;" class="nav-link px-2 link space nav-link dropdown-toggle size">Forum</a>
					<ul class="sub-menu dropdown-menu">
						<li>
							<a href="forum_accueil.php" title="Ouvrir" class="dropdown dropdown-item">Accueil</a>
						</li>
						<li>
							<a href="forum.php" title="Ouvrir" class="dropdown dropdown-item">Catégories</a>
						</li>
						<li>
							<a href="forum_question.php" title="Ouvrir" class="dropdown dropdown-item">Questions</a>
						</li>
					</ul>
				</li>
				<li>
					<a style="color: black;" class="nav-link px-2 link nav-link dropdown-toggle size">VIP</a>
					<ul class="sub-menu dropdown-menu">
						<li>
							<a href="point.php" title="Ouvrir" class="dropdown dropdown-item">Points</a>
						</li>
						<li>
							<a href="AvantageVip.php" title="Ouvrir" class="dropdown dropdown-item">Avantage</a>
						</li>
						<li>
							<a href="classement.php" title="Ouvrir" class="dropdown dropdown-item">Classement</a>
						</li>
					</ul>
				</li>
				</ul>
			</div>
		</nav>

		<div class="col-xl-3 text-end col-md-1 col-3">
			<?php 
			if(isset($_SESSION['email'])){	
					if(isset($_SESSION['type']) && $_SESSION['type'] === '1'){
						?>
						<div class="dropdown">
          					<a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            					<img src="<?= $chemin_avatar ?>" alt="mdo" width="32" height="32" class="rounded-circle">
          					</a>
          					<ul class="dropdown-menu text-small end-0 ms-xl-5">
          						<li><div class="dropdown-item">Solde : <?= $avatar['solde'] ?> €</div></li>
          						<li><a class="dropdown-item" href="panier.php">Panier</a></li>
            					<li><a class="dropdown-item" href="profil.php">Profil</a></li>
        					    <li><a class="dropdown-item" href="paramètres.php">Paramètres</a></li>
            					<li><a class="dropdown-item">
            						<?php
            						if(isset($_COOKIE['theme'])){
            							if($_COOKIE["theme"] == "dark"){
            						?>
            							<i class="bi bi-moon light" id="toggleDark"></i>
            						<?php
            							}else{
            						?>
            							<i class="bi bi-brightness-high-fill light" id="toggleDark"></i>
            						<?php
            							}
            						}else{
            							?>
            							<i class="bi bi-brightness-high-fill light" id="toggleDark"></i>
            						<?php
            						}
            						?>
            					</a></li>
            					<li><hr class="dropdown-divider"></li>
            					<li><a href="back_admin.php" class="dropdown-item">Administrateur</a></li>
            					<li><a class="dropdown-item" href="deconnexion.php">Déconnexion</a></li>
          					</ul>
          				</div>
						
						<?php
					}else{
						?>
						<div class="dropdown">
          					<a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            					<img src="<?= $chemin_avatar ?>" alt="mdo" width="32" height="32" class="rounded-circle">
          					</a>
          					<ul class="dropdown-menu text-small end-0 ms-xl-5">
          						<li><div class="dropdown-item">Solde : <?= $avatar['solde'] ?> €</div></li>
          						<li><a class="dropdown-item" href="panier.php">Panier</a></li>
            					<li><a class="dropdown-item" href="profil.php">Profil</a></li>
        					    <li><a class="dropdown-item" href="paramètres.php">Paramètres</a></li>
            					<li><a class="dropdown-item">
            						<?php
            						if(isset($_COOKIE['theme'])){
            							if($_COOKIE["theme"] == "dark"){
            						?>
            							<i class="bi bi-moon light" id="toggleDark"></i>
            						<?php
            							}else{
            						?>
            							<i class="bi bi-brightness-high-fill light" id="toggleDark"></i>
            						<?php
            							}
            						}else{
            							?>
            							<i class="bi bi-brightness-high-fill light" id="toggleDark"></i>
            						<?php
            						}
            						?>
            					</a></li>
            					<li><hr class="dropdown-divider"></li>
            					<li><a class="dropdown-item" href="deconnexion.php">Déconnexion</a></li>
          					</ul>
          				</div><?php
					}
				}else{
					echo '<button type="button" class="btn btn-outline-dark me-2"><a href="connexion.php" class="dropdown dropdown-item">Se connecter</a></button>';
					echo '<button type="button" class="btn btn-dark"><a href="inscription.php" class="dropdown dropdown-item">S\'inscrire</a></button>';
				}
			?>
			</div>
		</div>

</header>
</div>
<?php }else{ ?>
<div class="container">
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">


		<a href="index.php" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
			<img class="bi me-2" src="images/econami.png" alt="Logo econami" height="60px">
		</a>

		<nav class="navbar navbar-expand-lg">
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <img src="images/burger_menu.svg">
            </button>
        <div class="collapse navbar-collapse" id="navbarNav">
			<ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
				<li>
					<a style="color: black;" class="nav-link px-2 link space nav-link dropdown-toggle size">Vendre</a>
					<ul class="sub-menu dropdown-menu">
						<li>
							<a href="connexion.php" title="Ouvrir" class="dropdown dropdown-item">Déposer une annonce</a>
						</li>
						<li>
							<a href="vente_info.php" title="Ouvrir" class="dropdown dropdown-item">Info</a>
						</li>
					</ul>
				</li>
				<li>
					<a style="color: black;" class="nav-link px-2 link space nav-link dropdown-toggle size">Achats</a>
					<ul class="sub-menu dropdown-menu">
						<li>
							<a href="achats.php" title="Ouvrir" class="dropdown dropdown-item">Recherche</a>
						</li>
						<li>
							<a href="achatsTop.php" title="Ouvrir" class="dropdown dropdown-item">TOP</a>
						</li>
						<li>
							<a href="connexion.php" title="Ouvrir" class="dropdown dropdown-item">Vente privée</a>
						</li>
					</ul>
				</li>
				<li>
					<a style="color: black;" class="nav-link px-2 link space nav-link dropdown-toggle size">Forum</a>
					<ul class="sub-menu dropdown-menu">
						<li>
							<a href="forum_accueil.php" title="Ouvrir" class="dropdown dropdown-item">Accueil</a>
						</li>
						<li>
							<a href="forum.php" title="Ouvrir" class="dropdown dropdown-item">Catégories</a>
						</li>
						<li>
							<a href="forum_question.php" title="Ouvrir" class="dropdown dropdown-item">Questions</a>
						</li>
					</ul>
				</li>
				<li>
					<a style="color: black;" class="nav-link px-2 link nav-link dropdown-toggle size">VIP</a>
					<ul class="sub-menu dropdown-menu">
						<li>
							<a href="connexion.php" title="Ouvrir" class="dropdown dropdown-item">Points</a>
						</li>
						<li>
							<a href="AvantageVip.php" title="Ouvrir" class="dropdown dropdown-item">Avantage</a>
						</li>
						<li>
							<a href="classement.php" title="Ouvrir" class="dropdown dropdown-item">Classement</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		</nav>

		<div class="col-md-3 text-end">
			
			<?php
			if(isset($_COOKIE['theme'])){
				if($_COOKIE["theme"] == "dark"){
					?>
					<i class="bi bi-moon light" id="toggleDark"></i>
					<?php
				}else{
					?>
					<i class="bi bi-brightness-high-fill light" id="toggleDark"></i>
					<?php
				}
			}else{
				?>
				<i class="bi bi-brightness-high-fill light" id="toggleDark"></i>
				<?php
			}
			?>
			<button type="button" class="btn btn-outline-dark me-2"><a href="connexion.php" class="dropdown dropdown-item">Se connecter</a></button>
			<button type="button" class="btn btn-dark"><a href="inscription.php" class="dropdown dropdown-item">S'inscrire</a></button>
		</div>

</header>
</div>
<?php } ?>