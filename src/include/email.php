<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "include/PHPMailer/src/Exception.php";
require_once "include/PHPMailer/src/PHPMailer.php";
require_once "include/PHPMailer/src/SMTP.php";

$mail = new PHPMailer();


// Configuration
$name = 'email@gmail.com';

$mail = new PHPMailer();
$mail->CharSet = "UTF-8";
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = True;
$mail->Username = $name;
$mail->Password = 'password';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

//Destinataires
$mail->addAddress($destination);

// Expéditeur
$mail->setFrom($name);

//Contenu
$mail->isHTML(true);
$mail->Subject = "Econami :)";
$mail->Body = $message;
$mail->AltBody = $message;

//On envoie
$mail->send();
?>