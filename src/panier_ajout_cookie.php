<?php session_start();

if(!isset($_SESSION['email'])){
	header('location:connexion.php');
	exit;
}

//connexion à la bdd
include('include/db.php');
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

if(!empty($_GET)): // je verifie que le formulaire a bien été posté
	
	// print_r($_POST) Je regarde l'article que je veut ajouter au pannier
	/** retourne Array ( [article] => 5 [type] => propriete [propriete] => 5 [quantite] => 1 ) **/
		
	if(isset($_COOKIE['panier']) AND !empty($_COOKIE['panier'])) {   // je vérifie que le cookie existe
		$cart = unserialize($_COOKIE['panier']);  // je recupère les possibles articles déjà dans le panier
	}
	
	$cart[] = array(   // j'ajoute dans le tableau cart l'article, avec les informations qui sont dans article
				'id' => $req_annonce['id'],
				'reduction' => $req_annonce['reduction'],
			    'prix' => $req_annonce['prix'],
			    'marque' => $req_annonce['marque'],
			    'type' => $req_annonce['type'],
			    'date_expiration' => $req_annonce['date_expiration'],
			    'pseudo' => $req_annonce['pseudo']
			);
	
	$duree = 7 * 24 * 60 * 60;
	setcookie('panier', serialize($cart), (time() + $duree)); // je remplace/ajoute un nouveaux cookie, avec les informations du panier; je garde le cookie pour 2592000 (~1 mois)

else: // si non, j'affiche le tableau pour debugger
	echo '<pre>';
	print_r(unserialize($_COOKIE['panier'])); 
	echo '</pre>';
endif;

header('Location: panier.php');
exit();

?>