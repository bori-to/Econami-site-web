<?php session_start(); 
if(!isset($_SESSION['email']) || $_SESSION['type'] === '0'){
	header('location:index.php');
	exit;
} ?>



<?php


    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] != 4) {

        echo 'ok1';

    	$acceptable = ['image/png'];
		if(!in_array($_FILES['image_file']['type'], $acceptable)){
			$msg = 'Le fichier doit être de type png.';
			header('location:../back_captcha.php?message=' . $msg);
			exit;
		}	

        echo 'ok2';

        // Chemin de l'image téléchargée
        $original_image = $_FILES['image_file']['tmp_name'];

        echo 'ok2';

        // Ouvrir l'image avec la bibliothèque GD
        $image = imagecreatefrompng($original_image);

        echo 'ok2';

        // Taille de l'image
        $image_width = imagesx($image);
        $image_height = imagesy($image);

        // Taille d'une partie
        $part_width = $image_width / 3;
        $part_height = $image_height / 3;

        echo 'ok2.5';

        // Créer le dossier pour stocker les images
        $directory_name = pathinfo($_FILES['image_file']['name'], PATHINFO_FILENAME);
        if (!file_exists($directory_name)) {
            mkdir($directory_name);
        }

        echo 'ok3';

        // Parcourir toutes les parties de l'image
        for ($row = 0; $row < 3; $row++) {
            for ($col = 0; $col < 3; $col++) {
                // Découper la partie de l'image
                $part = imagecrop($image, [
                    'x' => $col * $part_width,
                    'y' => $row * $part_height,
                    'width' => $part_width,
                    'height' => $part_height,
                ]);

                // Enregistrer la partie de l'image dans un fichier
                $part_number = $row * 3 + $col + 1;
                $part_filename = $directory_name . '/' . $part_number . '.png';
                imagepng($part, $part_filename);

                // Libérer la mémoire
                imagedestroy($part);
            }
        }

        echo 'ok4';

        // Libérer la mémoire
        imagedestroy($image);

        // Rediriger vers une page de confirmation
        header('Location: ../file_captcha.php');
        exit;

    } else {
        echo "Une erreur est survenue lors du téléchargement de l'image.";
    }

?>