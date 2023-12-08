<?php session_start();

function erreur($erreur)
{
    switch ($erreur) {
        case '0':
            $msg = 'Vous devez remplir tous les champs.';
            header('location:inscription.php?type=danger&message=' . $msg);
            exit;
            break;

        case '1':
            $msg = 'Cet adresse email n existe pas.';
            header('location:inscription.php?type=danger&message=' . $msg);
            exit;
            break;

        case '2':
            $msg = 'La clé est invalide';
            header('location:connexion.php?type=danger&message=' . $msg);
            exit;
            break;
    }
}

include('include/db.php');

if ($_POST['key1'] === $_SESSION['key']) {
    header('location:oubli_change_mdp.php');
    exit;
} else {
    session_destroy();
    erreur(2);
    header('location:connexion.php');
    exit;
}
