<?php session_start(); 
if(!isset($_SESSION['email']) || $_SESSION['type'] === '0'){
    header('location:index.php');
    exit;
} ?>

<?php
// Chemin du dossier contenant les dossiers à renommer
$directory = 'captcha';

// Liste des noms de dossier dans le dossier
$dir_list = scandir($directory);

// Supprimer les dossiers "." et ".." de la liste
$dir_list = array_diff($dir_list, array('..', '.'));

// Renommer les dossiers temporairement
$i = 1;
foreach ($dir_list as $dir) {
    if (is_dir($directory.'/'.$dir)) {
        rename($directory.'/'.$dir, $directory.'/'.$i);
        $i++;
    }
}
$msg = 'Captcha ajouter avec succès !!';
header('Location: back_captcha.php?type=success&message=' . $msg);
exit;
?>
