<?php session_start();

include 'include/db.php';
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

            case '3':
                $msg = 'Le mot de passe n est pas le même';
                header('location:oubli_change_mdp.php?type=danger&message=' . $msg);
                exit;
                break;
    }
}
if($_POST['password'] == $_POST['password_confirm']){

    $q = 'UPDATE users SET password = ? WHERE email = ?';
			$req = $bdd->prepare($q);
			$req->execute([
				hash('sha512', $_POST['password']),			
				$_SESSION['email']
			]);
			$msg = 'Mot de passe modifier avec succès';
			header('location:connexion.php?type=success&message=' . $msg);
			exit;
}else{
    session_destroy();
    erreur(3);
    header('location:oubli_change_mdp.php');
    exit;
}