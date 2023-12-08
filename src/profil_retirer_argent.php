<?php session_start();

if(!isset($_SESSION['email'])){
  header('location:connexion.php');
  exit;
}

if($_SESSION['solde'] < 25){
  header('location:index.php');
  exit;
}

if(!empty($_POST)){
  extract($_POST);

  $valid = true;

  if(isset($_POST['iban'])){

    $iban = $_POST['iban'];
    $solde = $_SESSION['solde'];
    $pseudo = $_SESSION['pseudo'];

    if($iban != strtoupper($iban)){
      $iban = strtoupper($iban);
    }

    if($valid){

      $destination = $_SESSION['email'];
      // $message = "Bonjour $pseudo,<br>
      // Ta demande de Transfère d'argent d'un montant de <b>$solde €</b> à bien était prise en compte.";
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
                <p class='para'>Bonjour $pseudo,<br>Ta demande de Transfère Avec montant de <b>$solde €</b> à bien était prise en compte.</p>
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

      $destination = 'esgieconami@gmail.com';
      // $message = "Demande de transfère d'argent d'un montant de <b>$solde €</b> à valider pour <b>$pseudo</b>,<br>
      // Numéro IBAN : <b>$iban</b>";
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
                <p class='para'>Demande de transfère d'argent d'un montant de <b>$solde €</b> à valider pour <b>$pseudo</b>,<br> Numéro IBAN : <b>$iban</b></p>
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

      $msg = 'Votre demande de transfère d\'argent à était transmise avec succès.';
      header('location:profil.php?type=success&message=' . $msg);
      exit;

    }
  }
}


$title = 'Profil - retirer argent';
include('include/head.php');

if(isset($_SESSION['id'])){
  include('include/log.php');
  writeLog($title);
}
?>
  <link rel="stylesheet" type="text/css" href="css/stylelog.css">
  </head>
  <?php
    if(isset($_COOKIE['theme'])){
      if($_COOKIE["theme"] == "dark") {
        $background_white = "#454D67";
        $background_marron = "#92A7B0";
        $background_marronClaire = "#3B5D6B";
        $background_Jaune= "#92A7B0";
        $background_btn = "#585A56";
        $border_btn = "#585A56";
      } else {
        $background_white = "white";
        $background_marron = "rgb(185, 168, 124)";
        $background_marronClaire = "rgba(185, 168, 124, 0.5)";
        $background_Jaune= "#DCD488";
        $background_btn = "#B9A87C";
        $border_btn = "#B9A87C";
      }
    }else{
      $background_white = "white";
      $background_marron = "rgb(185, 168, 124)";
      $background_marronClaire = "rgba(185, 168, 124, 0.5)";
      $background_Jaune= "#DCD488";
      $background_btn = "#B9A87C";
      $border_btn = "#B9A87C";
    }
  ?>
  <style type="text/css">
    header, footer{
      filter: blur(2px);
    }
  </style>
  <body class="my-login-page" style="background-color: <?= $background_white?>;">
    <?php include 'include/header.php' ?>
    <main style="background-color: <?= $background_marronClaire ?>; padding: 100px 0;" >
      <section class="h-100">
    <div class="container h-100">
      <div class="row justify-content-md-center align-items-center h-100">
        <div class="card-wrapper">
          <div class="card fat">
            <div class="card-body">
              <h4 class="">Transférer vers un compte bancaire.</h4>
              <h3 class=""><b><?= $_SESSION['solde'] ?> €</b>
              </h3>

              <?php 

              include('include/message.php');

              ?>

              <form method="POST" class="my-login-validation">
                <div class="form-group">
                  <label for="iban">Coordonnées bancaires du compte : IBAN</label>
                  <input id="iban" type="text" class="form-control" name="iban" required autofocus>
                  <div class="form-text text-muted">
                    Le transfert vers ton compte peut prendre jusqu'à 5 jours ouvrés.
                  </div>
                </div>

                <div class="form-group m-0">
                  <button type="submit" class="btn btn-dark btn-block">
                    Transférer vers un compte bancaire
                  </button>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

    </main>

    <?php include 'include/footer.php' ?>
  </body>
  <script src="js/bootstrap.min.js"></script>
</html>