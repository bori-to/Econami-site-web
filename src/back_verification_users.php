<?php
include('include/db.php');

$q = 'SELECT * FROM users WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([$_POST['id']]);
$user = $req->fetch();

function erreur($erreur){
	switch ($erreur) {
		case '0':
			$msg = 'Vous devez remplir tous les champs obligatoire.';
			header('location:back_end.php?type=danger&message=' . $msg);
			exit;
			break;

		case '1':
			$msg = 'Le pseudo est déjà pris.';
			header('location:back_end.php?type=danger&message=' . $msg);
			exit;
			break;

		case '2':
			$msg = 'Adresse email non valide.';
			header('location:back_end.php?type=danger&message=' . $msg);
			exit;
			break;


		case '3':
			$msg = 'Le mot de passe doit faire entre 6 à 12 caractères.';
			header('location:back_end.php?type=danger&message=' . $msg);
			exit;
			break;

		case '4':
			$msg = 'Cette adresse email est déjà utilisée.';
			header('location:back_end.php?type=danger&message=' . $msg);
			exit;
			break;

		case '5':
			$msg = 'La newsletter doit être en true ou false';
			header('location:back_end.php?type=danger&message=' . $msg);
			exit;
			break;

		case '6':
			$msg = 'Nom invalide';
			header('location:back_end.php?type=danger&message=' . $msg);
			exit;
			break;

		case '7':
			$msg = 'Date de naissance invalide';
			header('location:back_end.php?type=danger&message=' . $msg);
			exit;
			break;

		case '8':
			$msg = 'Prénom invalide';
			header('location:back_end.php?type=danger&message=' . $msg);
			exit;
			break;
	}
}
// Verification des champs

if(empty($_POST['email']) 
	|| empty($_POST['pseudo'])
	|| empty($_POST['nom'])
	|| empty($_POST['prenom']) 
	|| !isset($_POST['email']) 
	|| !isset($_POST['pseudo']) 
	|| !isset($_POST['nom']) 
	|| !isset($_POST['prenom']) 
	){
	erreur(0);
}

// pseudo
$q = 'SELECT id FROM users WHERE pseudo = :pseudo ';
$req = $bdd->prepare($q);
$req->execute(['pseudo' => $_POST['pseudo']]);
$results = $req->fetchAll();
if(!empty($results) && $_POST['pseudo'] !== $user['pseudo']){
	erreur(1);
}

//email
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	erreur(2);
}
$q = 'SELECT id FROM users WHERE email = :email ';
$req = $bdd->prepare($q);
$req->execute(['email' => $_POST['email']]);
$results = $req->fetchAll();
if(!empty($results) && $_POST['email'] !== $user['email']){
	erreur(4);
}

// nom
if(preg_match('/\d/', $_POST['nom'])){
	erreur(6);
}

// prenom
if(preg_match('/\d/', $_POST['prenom'])){
	erreur(8);
}

// date naissance
if(!empty($_POST['age'])){
	$birthdate = $_POST['age'];
	$max_date = date('Y-m-d', strtotime('-100 years'));

	if($birthdate > date('Y-m-d') || $birthdate < $max_date){
	    erreur(7);
	}
}

if(empty($_POST['age'])){
	$_POST['age'] = 0;
}

if(empty($_POST['points'])){
	$_POST['points'] = 0;
}

if ($_POST['newsletter'] == 'on') {
	$news = 'true';
}else{
	$news = 'false';
}

$q = 'UPDATE users SET 
age=:age,
points=:points,
email=:email,
pseudo=:pseudo,
nom=:nom, 
prenom=:prenom, 
newsletter=:newsletter
WHERE id = :id';
var_dump($q);
$req = $bdd->prepare($q); // Renvoie déclaration pdo (statement)
$reponse = $req->execute([
				'age' => $_POST['age'],
				'points' => $_POST['points'],
				'email' => $_POST['email'],
				'pseudo' => $_POST['pseudo'],
				'nom' => $_POST['nom'],
				'prenom' => $_POST['prenom'],
				'newsletter' => $news,
				'id' => $_POST['id']
							]); // Execution de la requête préparée (on lui passe les valeurs)


if($reponse != 1){
	$msg = 'Erreurs lors de l\'inscription en base de donnée.';
	header('location:back_voir-profil.php?type=danger&message=' . $msg);
	exit;
}

// creation en bdd

$msg = 'Compte modifier avec succès !!';
header('location:back_end.php?type=success&message=' . $msg);
exit;
?>
