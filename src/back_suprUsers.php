<?php session_start(); 
if(!isset($_SESSION['email']) || $_SESSION['type'] === '0'){
	header('location:index.php');
	exit;
}

include('include/db.php');
$q = 'SELECT * FROM users WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([$_POST['id']]);
$user = $req->fetch();

if($user['type'] === '0' || $user['type'] === '2'){

	$q = 'DELETE FROM commande WHERE id_users = ?';
	$req = $bdd->prepare($q);
	$req->execute([		
		$_POST['id']
	]);

	$q = 'DELETE FROM annonce WHERE id_users = ?';
	$req = $bdd->prepare($q);
	$req->execute([		
		$_POST['id']
	]);

	$q = 'DELETE FROM topic_commentaire WHERE id_users = ?';
	$req = $bdd->prepare($q);
	$req->execute([		
		$_POST['id']
	]);

	$q = 'DELETE FROM topic WHERE id_users = ?';
	$req = $bdd->prepare($q);
	$req->execute([		
		$_POST['id']
	]);

	$q = 'DELETE FROM users WHERE id = ?';
	$req = $bdd->prepare($q);
	$req->execute([		
		$_POST['id']
	]);

	$msg = 'Utilisateur supprimer avec succès';
	header('location:back_end.php?type=success&message=' . $msg);
	exit;
}

if($results['type'] === '1'){

	$msg = 'Un Administrateur ne peux pas être supprimer.';
	header('location:back_end.php?type=warning&message=' . $msg);
	exit;
}


?>
