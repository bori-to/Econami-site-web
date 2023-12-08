<?php
$dossier = 'captcha';
$nombre_dossiers = count(glob($dossier . '/*', GLOB_ONLYDIR));
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Connexion</title>
    <link rel="stylesheet" href="captcha/puzzle.css">
    <script>
      var nbDossiers = "<?php echo $nombre_dossiers; ?>";
    </script>
    <script src="captcha/puzzle.js"></script>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/stylelog.css">

    <script src="https://requirejs.org/docs/release/2.3.5/minified/require.js"></script>
    <link rel="icon" type="image/png" href="images/econami_onglet.png" />


	</head>
	<style type="text/css">
		header, footer{
			filter: blur(2px);
		}
	</style>
  <?php
    if(isset($_COOKIE['theme'])){
      if($_COOKIE["theme"] == "dark") {
        $background_white = "#454D67";
        $background_marron = "#92A7B0";
        $background_marronClaire = "#3B5D6B";
        $background_Jaune= "#92A7B0";
        $background_PAG= "#92A7B0";
        $background_btn = "#585A56";
        $border_btn = "#585A56";
      } else {
        $background_white = "white";
        $background_marron = "rgba(185, 168, 124)";
        $background_marronClaire = "rgba(185, 168, 124, 0.5)";
        $background_Jaune= "#DCD488";
        $background_btn = "#B9A87C";
        $border_btn = "#B9A87C";
      }
    }else{
      $background_white = "white";
      $background_marron = "rgba(185, 168, 124)";
      $background_marronClaire = "rgba(185, 168, 124, 0.5)";
      $background_Jaune= "#DCD488";
      $background_btn = "#B9A87C";
      $border_btn = "#B9A87C";
    }
  ?>
	<body class="my-login-page" style="background-color: <?= $background_white?>;">
  <?php include 'include/header.php' ?>
  <main style="background-color: <?= $background_marronClaire?>;">
    <br><br><br>
  <section class="h-100">
    <div class="container h-100">
      <div class="row justify-content-md-center h-100">
        <div class="card-wrapper">
          <div class="card fat">
            <div class="card-body">
              <h4 class="card-title">Connexion</h4>
              <?php 

              include('include/message.php');

              ?>

              <form method="POST" class="my-login-validation" action="verification.php">
                <div class="form-group">
                  <label for="email">Adresse E-Mail</label>
                  <input id="email" type="email" class="form-control" name="email" value="<?= isset($_COOKIE['email']) ? htmlspecialchars($_COOKIE['email']) : '' ?>" required autofocus>
                </div>

                <div class="form-group">
                  <label for="password">Mot de passe
                    <a href="oublimdp.php" class="float-right">
                      Mot de passe oublié ?
                    </a>
                  </label>
                  <input id="password" type="password" class="form-control" name="mot_de_passe" required data-eye>
                </div>

                <br>

                <h6>Compléter le captcha pour vous connectez :</h6>

                <div id="board">
                </div>
                <br>
                  <div class="form-group m-0">
                    <div id="connexionCaptcha">
                    </div>
                  </div>



                <!-- <div class="form-group m-0">
                  <button type="submit" class="btn btn-dark btn-block">
                    Connexion
                  </button>
                </div> -->
                <div class="mt-4 text-center">
                  Vous n'avez pas de compte ? <a href="inscription.php">S'inscrire</a>
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