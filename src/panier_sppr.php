<?php session_start();

if(!isset($_SESSION['email'])){
	header('location:connexion.php');
	exit;
}

$panier = unserialize($_COOKIE['panier']);

foreach ($panier as $index => $contenue) {
	if (isset($_POST['supprimer_annonce_' . $contenue['id']])) {
		// Supprimer l'article correspondant du tableau $panier
		unset($panier[$index]);
		$ser = serialize($panier);
		// Enregistrer le tableau de panier mis à jour dans le cookie
		setcookie('panier', $ser);

	}
}

if(empty($panier)){
	unset($_COOKIE['panier']);
	$duree = 7 * 24 * 60 * 60;
	setcookie('panier', '', time() - $duree, '/');
}

if(isset($_POST['panier'])){
	$panier = unserialize($_COOKIE['panier']);
	$duree = 7 * 24 * 60 * 60;
	setcookie('panier', serialize($panier), (time() - $duree));
	unset($panier);
}

if(isset($_POST['commande'])){
	$panier = unserialize($_COOKIE['panier']);
	$duree = 7 * 24 * 60 * 60;
	setcookie('panier', serialize($panier), (time() - $duree));
	unset($panier);

	header('location:profil.php');
	exit;
}

header('location:panier.php');
exit;

?>