<?php session_start(); 
if(!isset($_SESSION['email']) || $_SESSION['type'] === '0'){
	header('location:index.php');
	exit;
}

//connexion à la bdd
include('include/db.php');
$q = 'DELETE FROM topic_commentaire WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([
	$_POST['supp-com']
]);

$msg = 'Commentaire supprimer';
header('location:back_forum.php?type=success&message=' . $msg);
exit;



?>