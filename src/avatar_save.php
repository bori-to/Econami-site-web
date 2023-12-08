<?php session_start();
  if(!isset($_SESSION['email'])){
    header('location:connexion.php');
    exit;
  }
  // Récupérer l'image envoyée depuis la requête POST
  $image = $_POST['image'];

  // Supprimer les informations de base64 dans l'URL de l'image et décoder les données en binaire
  $image = str_replace('data:image/png;base64,', '', $image);
  $image = str_replace(' ', '+', $image);
  $image = base64_decode($image);

  if(!file_exists('avatar')){
    mkdir('avatar'); // chmod 0777 par défaut
  }

  $timestamp = time();

  $nom_image = 'image-' . $timestamp . '.png';
  $chemin_image = 'avatar/' . $nom_image;

  // Enregistrer l'image dans le dossier "resultat"
  file_put_contents($chemin_image, $image);

  include('include/db.php');

  $q = 'UPDATE users
  SET image = ? WHERE id = ?';
  $req = $bdd->prepare($q);
  $reponse = $req->execute([
    $nom_image,
    $_SESSION['id']
  ]);
?>
