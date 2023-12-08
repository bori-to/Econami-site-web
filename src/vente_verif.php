<?php session_start();
include('include/db.php');
if (!isset($_SESSION['email'])) {
  header('location:index.php');
  exit;
}

if (isset($_POST['categorie']) && $_SESSION['type'] == 1) {
  $cat = htmlspecialchars($_POST["categorie"]);

  if (isset($_POST['date_apparition']) && $cat == 3) {
    $date_creation = htmlspecialchars($_POST["date_apparition"]);
  } else {
    $date_creation = date('Y-m-d');
  }
} else {
  $date_creation = date('Y-m-d');
}

if(isset($_POST['categorie']) && empty($_POST['categorie'])){
  $date_creation = date('Y-m-d');
}


$reduction = htmlspecialchars($_POST["reduction"]);
$prix = htmlspecialchars($_POST["prix"]);
$marque = htmlspecialchars($_POST["marque"]);
$marque = trim($marque);
$date_expiration = htmlspecialchars($_POST["date_expiration"]);
$coupon = htmlspecialchars($_POST["coupon"]);
$coupon = trim($coupon);


function erreur($erreur)
{
  switch ($erreur) {
    case '0':
      $msg = 'Vous devez remplir tous les champs.';
      header('location:vente.php?type=danger&message=' . $msg);
      exit;
      break;

    case '1':
      $msg = 'Une réduction ne peut pas exéder les 100%';
      header('location:vente.php?type=danger&message=' . $msg);
      exit;
      break;

    case '2':
      $msg = 'Le prix de la réduction est inférieur au prix de vente';
      header('location:vente.php?type=danger&message=' . $msg);
      exit;
      break;

    case '3':
      $msg = 'La date d expiration ne peut pas être inférieur à la date du jour';
      header('location:vente.php?type=danger&message=' . $msg);
      exit;
      break;

    case '4':
      $msg = 'Choississez une catégorie';
      header('location:vente.php?type=danger&message=' . $msg);
      exit;
      break;
  }
}

if (
  empty($_POST["type"])
  || empty($prix)
  || empty($reduction)
  || empty($marque)
  || empty($date_expiration)
  || empty($coupon)
) {
  erreur(0);
  header('location:vente.php');
  exit;
}

$type = $_POST["type"];

if ($type = '%' && $reduction > 100) {
  erreur(1);
  header('location:vente.php');
  exit;
}
if ($type = '€' && $type != '%') {
  if ($prix >= $reduction && $_POST["type"] == '€') {
    erreur(2);
    header('location:vente.php');
    exit;
  }
}
if (strtotime($date_expiration) < time()) {
  erreur(3);
  header('location:vente.php');
  exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['date_apparition']) && $cat == 3) {
  $q = 'SELECT email FROM users WHERE points > 250';
  $req = $bdd->prepare($q);
  $rep = $bdd->query($q);

  $emails = array();
  while ($donnees = $rep->fetch()) {
    $emails[] = $donnees['email'];
  }

  $date = date_format(date_create($date_creation), 'd/m/Y à H:i');

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
                  <p class='para'>
                    Nouveaux coupon bientôt disponible en vente privée ! <br> <br>
                    Coupon : <b> $marque - $reduction $type </b> <br>
                    Prix : <b> $prix € </b> <br>
                    Date de mise en vente : <b> $date </b>
                  </p>
                  <button class='forum__body__btn'>
                    <a href='https://econami.ddns.net/achats_ventePrivee.php' class='forum__btn__create' style='background-color: #DCD488; font-size: 25px; color: black;'>
                      Econami - Ventes Privées
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
  foreach ($emails as $key) {
    $mail->addAddress($key);
  }

  // Expéditeur
  $mail->setFrom($name);

  //Contenu
  $mail->isHTML(true);
  $mail->Subject = "Econami :)";
  $mail->Body = $message;
  $mail->AltBody = $message;

  //On envoie
  $mail->send();
}


if (isset($_POST['categorie']) && $_SESSION['type'] == 1) {
  if ($cat == 'Choississez votre catégorie') {
    erreur(4);
  }
  if ($cat == 'Choississez votre catégorie') {
    $cat = 0;
  }
  $q = 'INSERT INTO annonce (coupon, reduction, prix, marque, type, id_users,date_expiration,date_creation, valide) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
  $req = $bdd->prepare($q);
  $reponse = $req->execute([
    $coupon,
    $reduction,
    $prix,
    $marque,
    $_POST["type"],
    $_SESSION['id'],
    $date_expiration,
    $date_creation,
    $cat
  ]);
  $msg = 'Coupon déposer et en cours de validation.';
  header('location:vente.php?type=success&message=' . $msg);
  exit;
} else {
  $q = 'INSERT INTO annonce (coupon, reduction, prix, marque, type, id_users,date_expiration,date_creation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
  $req = $bdd->prepare($q); // Renvoie déclaration pdo (statement)
  $reponse = $req->execute([
    $coupon,
    $reduction,
    $prix,
    $marque,
    $_POST["type"],
    $_SESSION['id'],
    $date_expiration,
    $date_creation
  ]); // Execution de la requête préparée (on lui passe les valeurs)
  $msg = 'Coupon déposer et en cours de validation.';
  header('location:vente.php?type=success&message=' . $msg);
  exit;
}
