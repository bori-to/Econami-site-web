<?php
$title = 'Mot de passe oublié';
if (isset($_SESSION['id'])) {
  include('include/log.php');
  writeLog($title);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mot de passe oublié</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/stylelog.css">

</head>
<style type="text/css">
  header,
  footer {
    filter: blur(2px);
  }
</style>
<?php
if (isset($_COOKIE['theme'])) {
  if ($_COOKIE["theme"] == "dark") {
    $background_white = "#454D67";
    $background_marron = "#92A7B0";
    $background_marronClaire = "#3B5D6B";
    $background_Jaune = "#92A7B0";
    $background_PAG = "#92A7B0";
    $background_btn = "#585A56";
    $border_btn = "#585A56";
  } else {
    $background_white = "white";
    $background_marron = "rgba(185, 168, 124)";
    $background_marronClaire = "rgba(185, 168, 124, 0.5)";
    $background_Jaune = "#DCD488";
    $background_btn = "#B9A87C";
    $border_btn = "#B9A87C";
  }
} else {
  $background_white = "white";
  $background_marron = "rgba(185, 168, 124)";
  $background_marronClaire = "rgba(185, 168, 124, 0.5)";
  $background_Jaune = "#DCD488";
  $background_btn = "#B9A87C";
  $border_btn = "#B9A87C";
}
?>

<body class="my-login-page" style="background-color: <?= $background_white ?>;">
  <?php include 'include/header.php' ?>
  <main style="background-color: <?= $background_marronClaire ?>;">
    <br><br><br>
    <section class="h-100">
      <div class="container h-100">
        <div class="row justify-content-md-center align-items-center h-100">
          <div class="card-wrapper">
            <div class="card fat">
              <div class="card-body">
                <h4 class="card-title">Mot de passe oublié</h4>

                <?php

                include('include/message.php');

                ?>

                <form method="POST" class="my-login-validation" action="oubli_verif_email.php" novalidate="">
                  <div class="form-group">
                    <label for="email">Adresse E-Mail</label>
                    <input id="email" type="email" class="form-control" name="email" value="" required autofocus>
                    <div class="form-text text-muted">
                      En cliquant sur "Réinitialiser le mot de passe", nous enverrons un lien de réinitialisation du mot de passe
                    </div>
                  </div>

                  <div class="form-group m-0">
                    <button type="submit" class="btn btn-dark btn-block" onclick="window.location.href='oubli_verif_email.php'">
                      réinitialiser le mot de passe
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="footer">
              <br>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php include 'include/footer.php' ?>
</body>

</html>