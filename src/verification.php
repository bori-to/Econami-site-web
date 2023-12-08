<?php

function writeLog($success){
	$log = fopen('log.txt', 'a+');
	$line = date('d/m/Y - H:i:s') . ' - Tentative de connexion ' . ($success ? 'réussie' : 'échouée') . ' de ' . $_POST['email'] . "\n";
	fputs($log, $line);
	fclose($log);
}

if(isset($_POST['email']) && !empty($_POST['email'])){
	$email = $_POST['email'];
	$expire = time() + (7 * 24 * 60 * 60);
	setcookie("email", $email, $expire);
}

if(empty($_POST['email']) || empty($_POST['mot_de_passe']) || !isset($_POST['email']) || !isset($_POST['mot_de_passe'])){
	writeLog(false, $_POST['email']);
	$msg = 'Vous devez remplir les 2 champs.';
	header('location:connexion.php?type=danger&message=' . $msg);
	exit;
}

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	writeLog(false, $_POST['email']);
	$msg = 'Adresse email non valide.';
	header('location:connexion.php?type=danger&message=' . $msg);
	exit;
}




//connexion à la bdd
include('include/db.php');

// Si email et mdp existe en bdd : redirection
$q = 'SELECT * FROM users WHERE email = :email AND password = :password';
$req = $bdd->prepare($q);
$req->execute(['email' => $_POST['email'], 'password' => hash('sha512', $_POST['mot_de_passe'])]);

// Maintenant il faut chercher les résultat (lignes)
$results = $req->fetch(); // résultats sont mis dans un tableaux

// Si le tableau $results est vide : redirection
if(!$results){
	writeLog(false, $_POST['email']);
	$msg = 'Identifiants inconnus.';
	header('location:connexion.php?type=danger&message=' . $msg);
	exit;
}

if($results['type'] === '2'){
	writeLog(false, $_POST['email']);
	$msg = 'Vous êtes banni contacté les admins pour en savoir plus.';
	header('location:connexion.php?type=warning&message=' . $msg);
	exit;
}

session_start();
$date_visible = date('Y-m-d H:i;s');
$q = 'UPDATE users set date_visite = ? WHERE id = ?;';
$req = $bdd->prepare($q);
$req->execute([
	$date_visible,
	$results['id']
]);


// Ajout email à la session
$_SESSION['email'] = $_POST['email'];
$_SESSION['id'] = $results['id'];
$_SESSION['nom'] = $results['nom'];
$_SESSION['prenom'] = $results['prenom'];
$_SESSION['age'] = $results['age'];
$_SESSION['points'] = $results['points'];
$_SESSION['newsletter'] = $results['newsletter'];
$_SESSION['pseudo'] = $results['pseudo'];
$_SESSION['type'] = $results['type'];
$_SESSION['solde'] = $results['solde'];
$_SESSION['password'] = hash('sha512', $_POST['mot_de_passe']);

writeLog(true, $_POST['email']);
header('location:index.php');
exit;
?>
