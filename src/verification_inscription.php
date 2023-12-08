<?php

function writeLog($success){
	$log = fopen('log.txt', 'a+');
	$line = date('d/m/Y - H:i:s') . ' - Tentative inscription ' . ($success ? 'réussie' : 'échouée') . ' de ' . $_POST['email'] . "\n";
	fputs($log, $line);
	fclose($log);
}


function erreur($erreur){
	switch ($erreur) {
		case '0':
			writeLog(false, $_POST['email']);
			$msg = 'Vous devez remplir tous les champs.';
			header('location:inscription.php?type=danger&message=' . $msg);
			exit;
			break;

		case '1':
			writeLog(false, $_POST['email']);
			$msg = 'Le pseudo est déjà pris.';
			header('location:inscription.php?type=danger&message=' . $msg);
			exit;
			break;

		case '2':
			writeLog(false, $_POST['email']);
			$msg = 'Adresse email non valide.';
			header('location:inscription.php?type=danger&message=' . $msg);
			exit;
			break;


		case '3':
			writeLog(false, $_POST['email']);
			$msg = 'Le mot de passe doit faire entre 6 à 12 caractères.';
			header('location:inscription.php?type=danger&message=' . $msg);
			exit;
			break;

		case '4':
			writeLog(false, $_POST['email']);
			$msg = 'Cette adresse email est déjà utilisée.';
			header('location:inscription.php?type=danger&message=' . $msg);
			exit;
			break;

		case '5':
			writeLog(false, $_POST['email']);
			$msg = 'Il faut accepter les termes et conditions';
			header('location:inscription.php?type=danger&message=' . $msg);
			exit;
			break;
	}
}
// Cookie
if(isset($_POST['email']) && !empty($_POST['email'])){
	$email = $_POST['email'];
	$expire = time() + (7 * 24 * 60 * 60);
	setcookie("email", $email, $expire);
}

// Verification des champs

if(empty($_POST['email']) 
	|| empty($_POST['mot_de_passe'])
	|| empty($_POST['nom'])  
	|| empty($_POST['prenom']) 
	|| empty($_POST['pseudo']) 
	|| !isset($_POST['email']) 
	|| !isset($_POST['nom']) 
	|| !isset($_POST['prenom']) 
	|| !isset($_POST['pseudo']) 
	|| !isset($_POST['mot_de_passe'])){
	erreur(0);
}

if(preg_match('/\d/', $_POST['nom'])){
	$msg = 'Nom invalide';
	header('location:profil_editer.php?type=danger&message=' . $msg);
	exit;
}

if(preg_match('/\d/', $_POST['prenom'])){
	$msg = 'Prenom invalide';
	header('location:profil_editer.php?type=danger&message=' . $msg);
	exit;
}

//connexion à la bdd
include('include/db.php');
// Si pseudo existe déjà en bdd : redirection vers le formulaire
$q = 'SELECT id FROM users WHERE pseudo = :pseudo ';
$req = $bdd->prepare($q);
$req->execute(['pseudo' => $_POST['pseudo']]);
$results = $req->fetchAll();
if(!empty($results)){
	erreur(1);
}

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	erreur(2);
}

//connexion à la bdd
include('include/db.php');
// Si pseudo existe déjà en bdd : redirection vers le formulaire
$q = 'SELECT id FROM users WHERE email = :email ';
$req = $bdd->prepare($q);
$req->execute(['email' => $_POST['email']]);
$results = $req->fetchAll();
if(!empty($results)){
	erreur(4);
}


if(strlen($_POST['mot_de_passe']) < 6 || strlen($_POST['mot_de_passe']) > 12){
	erreur(3);
}

if(empty($_POST['agree'])){
	erreur(5);
}

if(empty($_POST['newsletter'])){
	$_POST['newsletter'] = 'false';
}else{
	$_POST['newsletter'] = 'true';
}
// var_dump($q);

// Execution de la requête
// $reponse = $bdd->exec($q); // exec renvoie le nb de lignes modifiés
//Création de la clé

$longueurkey = 12;
$key = "";
for($i=1;$i<$longueurkey;$i++){
	$key.= mt_rand(0,9);
}

$pseudo = $_POST['pseudo'];
$destination = $_POST['email'];
$message = "
      <!DOCTYPE html>
      <html>
      <head>
        <title>Email econami</title>
        <meta charset='utf-8'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ' crossorigin='anonymous'>
        <style type='text/css'>
          .m_a{
            font-size:50pt;
            color: black;
          }
          .m_a img{
            width: 200px;
          }
          .para{
            font-size: 16px;
          }

          mark{
            background-color: #DCD488;
          }

          button{
            border: none;
            background-color: rgba(185, 168, 124,0);
          }

          .forum__body__btn {
              margin: 20px 0;
          }
          .forum__btn__create {
              background: #DCD488;
              color: black;
              align-items: center;
              cursor: pointer;
              border: 0;
              padding: 0.375rem;
              border-radius: 6px;
              font-size: .8rem;
              text-decoration: none;
              box-shadow: 1px 1px 5px rgba(0, 0, 0, .2);
              transition: all .5s ease;
              justify-content: center;
          }
          .forum__btn__create:hover {
              box-shadow: none;
          }
        </style>
      </head>
      <body style='background-color: #f6f9fc;'>
        <div class='container'>
          <div class='row'>
            <div class='col-3'></div>
            <div class='col-6' style='background-color: rgba(185, 168, 124, 0.5); border-radius: 10px; padding: 20px 20px;'>
              <div class='m_a'>
                <img src='https://econami.ddns.net/images/econami2.png'>
              </div>
              <div>
                <p class='para'>Bonjour $pseudo,<br><b>Ta clé est $key</b></p>
                <button class='forum__body__btn'>
                  <a href='https://econami.ddns.net/' class='forum__btn__create' style='background-color: #DCD488; font-size: 25px; color: black;'>
                    Econami
                  </a>
                </button>
                <p class='para'>Vous avez des questions ? Consultez le forum de <mark>Econami</mark> ou contactez-nous.</p>
                <p class='para'>Merci,<br><mark>Econami</mark></p>
                <p class='para'>© 2023 <mark>Econami</mark>, Inc</p>
              </div>
            </div>
            <div class='col-3'></div>
          </div>
        </div>
      </body>
      </html>
      ";

include('include/email.php');

// session_start();
// $_SESSION['newsletter'] = $_POST['newsletter'];
// $_SESSION['email'] = $_POST['email'];
// $_SESSION['prenom'] = $_POST['prenom'];
// $_SESSION['nom'] = $_POST['nom'];
// $_SESSION['pseudo'] = $_POST['pseudo'];
// $_SESSION['mot_de_passe'] = $_POST['mot_de_passe'];
// $_SESSION['type'] = '0';
// $_SESSION['key'] = $key;
?>
<form method="post" action="mail_verif.php" hidden>
    <input name="newsletter" value="<?= $_POST['newsletter'] ?>" hidden>
    <br>
    <input name="email" value="<?= $_POST['email'] ?>" hidden>
    <br>
    <input name="prenom" value="<?= $_POST['prenom'] ?>" hidden>
    <br>
    <input name="nom" value="<?= $_POST['nom'] ?>">
    <br>
    <input name="pseudo" value="<?= $_POST['pseudo'] ?>" hidden>
    <br>
    <input name="mot_de_passe" value="<?= $_POST['mot_de_passe'] ?>" hidden>
    <br>
    <input name="type" value="<?= $_POST['type'] ?>" hidden>
    <br>
    <input name="key" value="<?= $key ?>" hidden>
    <br>
    <input type="submit" value="Envoyer" hidden>
</form>
<script type="text/javascript">
	const form = document.querySelector('form');
	function submitForm() {
	  form.submit();
	}
	setTimeout(submitForm, 0);
</script>
