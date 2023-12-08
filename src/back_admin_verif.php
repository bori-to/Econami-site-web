<?php session_start(); 
if(!isset($_SESSION['email']) || $_SESSION['type'] === '0'){
	header('location:index.php');
	exit;
}

//connexion à la bdd
include('include/db.php');


//connexion à la bdd
include('include/db.php');
$q = 'SELECT * FROM users WHERE id = :id';
$req = $bdd->prepare($q);
$req->execute(['id' => $_POST['id']]);
$results = $req->fetch();

if($results['type'] === '2'){

	$msg = 'Utilisateur banni.';
	header('location:back_end.php?type=warning&message=' . $msg);
	exit;
}
if($results['type'] === '0'){
	$q = 'UPDATE users SET type=1 WHERE id = :id';
	$req = $bdd->prepare($q);
	$reponse = $req->execute(['id' => $_POST['id']]);

	$msg = 'Utilisateur maintenant Administrateur.';
	header('location:back_end.php?type=success&message=' . $msg);
	exit;
}

if($results['type'] === '1'){
	$q = 'UPDATE users SET type=0 WHERE id = :id';
	$req = $bdd->prepare($q);
	$reponse = $req->execute(['id' => $_POST['id']]);

	$msg = 'Utilisateur maintenant Normal.';
	header('location:back_end.php?type=success&message=' . $msg);
	exit;
}
?>
