<?php session_start();
include('include/db.php');
$q = 'SELECT * FROM users WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([$_SESSION['id']]);
$results = $req->fetch();

$email = $results['email'];
$pseudo = $results['pseudo'];
$nom = $results['nom'];
$prenom =  $results['prenom'];
$date = date_format(date_create($results['age']), 'd/m/Y');

$chemin_avatar = null;

if (isset($results['image'])) {
	$chemin_avatar = 'avatar/' .  $results['image'];
} else {
	$chemin_avatar = 'avatar/defaut/icon_profil.svg';
}

use Dompdf\Dompdf;
use Dompdf\Options;


$html = "Email: <b>$email</b><br> Pseudo: <b>$pseudo</b><br> Nom: <b>$nom</b><br> Prenom: <b>$prenom</b><br> Date de naissance: <b>$date</b><br><br>
Avatar :<br>
	<p>$chemin_avatar</p>
";
require_once 'include/dompdf/autoload.inc.php';
$options = new Options();
$options->set('defaultFont', 'Courier');

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$fichier = 'Profil_Econami';

$dompdf->stream($fichier);
