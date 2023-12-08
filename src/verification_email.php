<?php session_start();

function writeLog($success){
	$log = fopen('log.txt', 'a+');
	$line = date('d/m/Y - H:i:s') . ' - Tentative inscription ' . ($success ? 'réussie' : 'échouée') . ' de ' . $_POST['email'] . "\n";
	fputs($log, $line);
	fclose($log);
}

include('include/db.php');

if($_POST['key2'] === $_POST['key']){
	$nom = trim($_POST['nom']);
	$prenom = trim($_POST['prenom']);
	$pseudo = trim($_POST['pseudo']);
	$date_visite = date('Y-m-d H:i;s');
	$q = 'INSERT INTO users (newsletter, nom, prenom, pseudo, email, password, type, date_visite) VALUE (:newsletter, :nom, :prenom, :pseudo,:email, :password, :type, :date_visite)';
	$req = $bdd->prepare($q); // Renvoie déclaration pdo (statement)
	$reponse = $req->execute([
	'newsletter' => $_POST['newsletter'],
	'nom' => $nom,
	'prenom' => $prenom,
	'pseudo' => $pseudo,
	'email' => $_POST['email'], 
	'password' => hash('sha512', $_POST['mot_de_passe']),
	'type' => '0',
	'date_visite' => $date_visite
						]); // Execution de la requête préparée (on lui passe les valeurs)


	if($reponse != 1){
		$msg = 'Erreurs lors de l\'inscription en base de donnée.';
		header('location:inscription.php?type=danger&message=' . $msg);
		exit;
	}

	// creation en bdd
	writeLog(true, $_POST['email']);
	$msg = 'Compte créé avec succès !!';
	header('location:inscription.php?type=success&message=' . $msg);
	exit;
}else{
	session_destroy();
	writeLog(false, $_POST['email']);
	$msg = 'la clé est invalide !';
	header('location:inscription.php?type=danger&message=' . $msg);
	exit;
}
?>
