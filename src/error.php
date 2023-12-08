<?php
// Récupérer le code d'erreur HTTP
$error_code = $_SERVER["REDIRECT_STATUS"];

// Tableau associatif des erreurs et des messages correspondants
$error_messages = array(
    400 => "Bad Request",
    401 => "Unauthorized",
    403 => "Forbidden",
    404 => "Page Not Found",
    500 => "Internal Server Error",
    502 => "Bad Gateway",
    504 => "Gateway Timeout"
);

// Vérifier si le code d'erreur est dans la liste des erreurs connues
if (array_key_exists($error_code, $error_messages)) {
	?>
    <!DOCTYPE html>
	<html>
	<head>
		<title>Erreur: <?= $error_code ?>!</title>
		<meta charset="utf-8">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/paiement.css">
		<style type="text/css">
			body{
			  text-align:center;
			  padding: 70px 70px;
			}
			div{
			  font-family:monospace;
			  font-size:25pt;
			}
			.erreur{
			  font-size:50pt;
			}
		</style>
	</head>
	<body style="background-color: rgba(185, 168, 124, 0.5);">
		<div class="container">
			<div>
			  <div class="text-center erreur">Erreur: <?= $error_code . "<br>" . $error_messages[$error_code] ?></div>
			  <button class="btn__link" style="font-size: 25px;">
			  	<a href="https://econami.ddns.net/">Retourner à l'accueil</a>
			  </button>
			</div>
		</div>
	</body>
	</html>
<?php
} else {
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Erreur</title>
		<meta charset="utf-8">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/paiement.css">
		<style type="text/css">
			body{
			  text-align:center;
			  padding: 70px 70px;
			}
			div{
			  font-family:monospace;
			  font-size:25pt;
			}
			.erreur{
			  font-size:50pt;
			}
		</style>
	</head>
	<body style="background-color: rgba(185, 168, 124, 0.5);">
		<div class="container">
			<div>
			  <div class="text-center erreur">Erreur !</div>
			  <button class="btn__link" style="font-size: 25px;">
			  	<a href="https://econami.ddns.net/">Retourner à l'accueil</a>
			  </button>
			</div>
		</div>
	</body>
	</html>
<?php
}
?>