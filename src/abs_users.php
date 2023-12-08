<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('include/db.php');
$q = 'SELECT * FROM users';
$req = $bdd->prepare($q);
$req->execute();
$abs = $req->fetchAll();

foreach($abs as $ab){
  $lastVisit = $ab['date_visite'];

  $q = 'SELECT * FROM abs_users WHERE actif = 1';
  $req = $bdd->prepare($q);
  $req->execute();
  $time = $req->fetch();

  if($time['date_abs'] == '1 mois'){
    $sendDate = date('Y-m-d', strtotime('+1 month', strtotime($lastVisit)));
  }
  if($time['date_abs'] == '3 mois'){
    $sendDate = date('Y-m-d', strtotime('+3 month', strtotime($lastVisit)));
  }
  if($time['date_abs'] == '6 mois'){
    $sendDate = date('Y-m-d', strtotime('+6 month', strtotime($lastVisit)));
  }
  if($time['date_abs'] == '1 an'){
    $sendDate = date('Y-m-d', strtotime('+12 month', strtotime($lastVisit)));
  }

    $currentDate = date('Y-m-d');

    $date = $time['date_abs'];
    if ($currentDate >= $sendDate) {
        $destination = $ab['email'];
        $pseudo = $ab['pseudo'];
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
                        <p class='para'>Bonjour $pseudo,<br>Tu tes pas connecter depuis plus de $date. <br><br>Viens vite voir les nouveaux coupons du site Econami !</p>
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

      
    }

}

?>