<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Inscription</title>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/stylelog.css">
    <link rel="icon" type="image/png" href="images/econami_onglet.png" />
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
	</head>
	<style type="text/css">
		header, footer{
			filter: blur(2px);
		}
	</style>
	<body class="my-login-page" style="background-color: <?= $background_white ?>;">
  <?php include 'include/header.php' ?>
  <main style="background-color: <?= $background_marronClaire ?>;">
    <br><br><br>
  <section class="h-100">
    <div class="container h-100">
      <div class="row justify-content-md-center h-100">
        <div class="card-wrapper">
          <div class="card fat">
            <div class="card-body">
              <h4 class="card-title">Validation par email</h4>

              <?php 

              include('include/message.php');

              ?>

              <form method="POST" class="my-login-validation" novalidate="" action="verification_email.php">
                <div class="form-group">
                  <label for="key2">Clé envoyé par email</label>
                  <input id="key2" type="text" class="form-control" name="key2" required autofocus>
                </div>
                <br>
                <div style="display: none;">
                  <input name="newsletter" value="<?= $_POST['newsletter'] ?>" hidden>
                  <br>
                  <input name="email" value="<?= $_POST['email'] ?>" hidden>
                  <br>
                  <input name="prenom" value="<?= $_POST['prenom'] ?>" hidden>
                  <br>
                  <input name="nom" value="<?= $_POST['nom'] ?>" hidden>
                  <br>
                  <input name="pseudo" value="<?= $_POST['pseudo'] ?>" hidden>
                  <br>
                  <input name="mot_de_passe" value="<?= $_POST['mot_de_passe'] ?>" hidden>
                  <br>
                  <input name="type" value="<?= $_POST['type'] ?>" hidden>
                  <br>
                  <input name="key" value="<?= $_POST['key'] ?>" hidden>
                </div>
                <div class="form-group m-0">
                  <button type="submit" class="btn btn-dark btn-block">
                    Valider
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
  </main>

  <?php include 'include/footer.php' ?>
</body>
</html>