<?php session_start();
if (!isset($_SESSION['email']) || $_SESSION['type'] === '0') {
	header('location:index.php');
	exit;
}
//connexion à la bdd
include('include/db.php');
$q = 'SELECT * FROM users';
$req = $bdd->prepare($q);
$reponse = $bdd->query($q);

$sql = "SELECT contenu FROM newsletters ORDER BY id DESC LIMIT 1";
$req = $bdd->prepare($sql);
$req->execute();
$news = $req->fetch();

if(!empty($_POST)){
	extract($_POST);

	$valid = true;

	if(isset($_POST['abs_users'])){
		if(isset($_POST['abs_value'])){
			$q = 'UPDATE abs_users set actif = 0 WHERE actif = 1;';
			$req = $bdd->prepare($q);
			$req->execute();

			$q = 'UPDATE abs_users set actif = 1 WHERE id = ?';
			$req = $bdd->prepare($q);
			$req->execute([$_POST['abs_value']]);
		}
	}

	if(isset($_POST['letter_actif'])){
		if(isset($_POST['letter_value'])){
			$q = 'UPDATE newsletters_send set actif = 0 WHERE actif = 1;';
			$req = $bdd->prepare($q);
			$req->execute();

			$q = 'UPDATE newsletters_send set actif = 1 WHERE id = ?';
			$req = $bdd->prepare($q);
			$req->execute([$_POST['letter_value']]);

			$q = 'SELECT date_send FROM newsletters_send WHERE actif = 1';
			$req = $bdd->prepare($q);
			$req->execute();
			$envoi = $req->fetch();

			if ($envoi['date_send'] == "1 jour") {
			  $frequence = "0 0 * * *"; 
			} elseif ($envoi['date_send'] == "1 semaine") {
			  $frequence = "0 0 * * 0";
			} elseif ($envoi['date_send'] == "1 mois") {
			  $frequence = "0 0 1 * *";
			} else {
			  $frequence = "0 0 * * 0";
			}

			shell_exec("crontab -u www-data -l > /var/www/econami/cron_temp");
			file_put_contents("/var/www/econami/cron_temp", $frequence." php /var/www/econami/mail.php\n");
			shell_exec("crontab /var/www/econami/cron_temp");
			unlink("/var/www/econami/cron_temp");

		}
	}

	if(isset($_POST['letter'])){
		if(isset($_POST['contenue_newsletter'])){
			$date_envoi = date('Y-m-d H:i:s');
			$q = 'INSERT INTO newsletters (contenu, date_creation) VALUES (?, ?)';
			$req = $bdd->prepare($q); // Renvoie déclaration pdo (statement)
			$reponse = $req->execute([
			$_POST['contenue_newsletter'],
			$date_envoi
			]);
			header("refresh:0");	
		}
	}
}

$title = 'Administrateur - NewsLetter';
include('include/head.php');
?>

</head>
<?php
if (isset($_COOKIE['theme'])) {
	if ($_COOKIE["theme"] == "dark") {
		$background_white = "#454D67";
		$background_marron = "#92A7B0";
		$background_marronClaire = "#3B5D6B";
		$background_Jaune = "#92A7B0";
		$background_btn = "#585A56";
		$border_btn = "#585A56";
	} else {
		$background_white = "white";
		$background_marron = "rgb(185, 168, 124)";
		$background_marronClaire = "rgba(185, 168, 124, 0.5)";
		$background_Jaune = "#DCD488";
		$background_btn = "#B9A87C";
		$border_btn = "#B9A87C";
	}
} else {
	$background_white = "white";
	$background_marron = "rgb(185, 168, 124)";
	$background_marronClaire = "rgba(185, 168, 124, 0.5)";
	$background_Jaune = "#DCD488";
	$background_btn = "#B9A87C";
	$border_btn = "#B9A87C";
}
?>

<body style="background-color: <?= $background_white ?>;">
	<?php include 'include/header.php' ?>
	<main>

		<div class="container">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="back_admin.php">Accueil administrateur</a></li>
					<li class="breadcrumb-item active" aria-current="page">Newsletter et Email</li>
					<li style="margin-left: 200px;">
						<?php

						include('include/message.php');

						?>
					</li>
				</ol>
			</nav>
			<div class="row">
				<?php
				$q = "SELECT * FROM abs_users where actif = 1";
				$req = $bdd->prepare($q);
				$req->execute();
				$abs_users = $req->fetch();
				?>
				<div class="col-12">
					<h1>Email en cas d'absence d'un utilisateur</h1>
				</div>
				<div class="line"></div>
				<br>
				<div class="col-md-4 col-6">
					<form method="post">				
						<select id="cat" name="abs_value" class="form-select">
							<?php 
							if(!empty($abs_users)){
								echo '<option value="' . $abs_users['id'] . '">' . $abs_users['date_abs'] . '</option>';
							}else{
								echo '<option hidden>Choississez le temps après une absence</option>';
							}
							$q = "SELECT * FROM abs_users where actif = 0";
							$req = $bdd->prepare($q);
							$req->execute();
							$abs_users_0 = $req->fetchAll();

									foreach($abs_users_0 as $us){
								?>
								<option value="<?= $us['id'] ?>"><?= $us['date_abs'] ?></option>
								<?php		
									}
								?>			
						</select>
						<div class="mt-4">
							<button class="btn btn-secondary" type="submit" name="abs_users">
								Modifier
							</button>	
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1>Newsletter en place</h1>
				</div>
				<div class="line"></div>
				<br>
				<?php
				$q = "SELECT * FROM newsletters_send where actif = 1";
				$req = $bdd->prepare($q);
				$req->execute();
				$letter_actif = $req->fetch();
				?>
				<div class="col-md-4 col-6">
					<p>Fréquence d'envoi des newsletters</p>
					<form method="post">			
						<select id="cat" name="letter_value" class="form-select">
							<?php 
							if(!empty($letter_actif)){
								echo '<option value="' . $letter_actif['id'] . '">' . $letter_actif['date_send'] . '</option>';
							}else{
								echo '<option hidden>Choississez le temps entre les newsletters</option>';
							}
							$q = "SELECT * FROM newsletters_send where actif = 0";
							$req = $bdd->prepare($q);
							$req->execute();
							$letter_actif_0 = $req->fetchAll();

									foreach($letter_actif_0 as $ln){
								?>
								<option value="<?= $ln['id'] ?>"><?= $ln['date_send'] ?></option>
								<?php		
									}
								?>			
						</select>
						<div class="mt-4 mb-4">
							<button class="btn btn-secondary" type="submit" name="letter_actif">
								Modifier
							</button>	
						</div>
					</form>
				</div>
				<div class="mb-2">
					Newsletter en place :
				</div>
				<div style="background-color: <?= $background_marronClaire?>; border-radius: 10px; padding: 10px 10px;">
					<?= $news['contenu'] ?>
				</div>
			</div>
		</div>
		<?php
		
		?>
		<br>
		<div class="container">
			<div class="row mb-4">
				<div class="col-12 text-center">
					<form class="mb-0" method="post">
						<div class="mb-3">
							<?php if (isset($err_contenu)) {
								echo '<div class="topic__zone__error">' . $err_contenu . '</div>';
							} ?>
							<label class="form-label">Contenu</label>
							<textarea class="form-control" type="text" name="contenue_newsletter" placeholder="NewsLetter"><?php if (isset($contenu)) {
																																echo htmlspecialchars($contenu);
																															} ?></textarea>
						</div>
						Modifier le contenu de la newsletter : 
						<button class="btn btn-secondary" type="submit" id="button" name="letter" value="<?php $newsLetter ?>">Modifier</button>
					</form>
				</div>
			</div>
			<button class="btn btn-secondary">
				<a href="back_histoNewsletter.php" style="text-decoration: none; color: white;">Historique newsletters</a>
			</button>
		</div>
		<div><br><br></div>
	</main>

	<?php include 'include/footer.php' ?>
</body>
<script src="js/bootstrap.min.js"></script>

</html>