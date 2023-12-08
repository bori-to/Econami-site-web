<?php session_start();
if (!isset($_SESSION['email']) || $_SESSION['type'] === '0') {
	header('location:index.php');
	exit;
}
//connexion à la bdd
include('include/db.php');
$ParPage = 10;
$TotalesReq = $bdd->query('SELECT id FROM newsletters');
$Totale = $TotalesReq->rowCount();
$pagesTotales = ceil($Totale/$ParPage);

if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0){
	$_GET['page'] = intval($_GET['page']);
	$pageCourante = $_GET['page'];
}else{
	$pageCourante = 1;
}

if(isset($_GET['page']) AND $_GET['page'] <= 0){
	$pageCourante = 1;
}

$depart = ($pageCourante-1)*$ParPage;


$q = 'SELECT * FROM newsletters ORDER BY id DESC LIMIT '.$depart.','.$ParPage.'';
$req = $bdd->prepare($q);
$req->execute();
$news = $req->fetchAll();

$title = 'NewsLetter - historique';
include('include/head.php');
?>
<link rel="stylesheet" type="text/css" href="css/pagination.css">
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
					<li class="breadcrumb-item active" aria-current="page"><a href="back_newsletter.php">Newsletter et Email</a></li>
					<li class="breadcrumb-item active" aria-current="page">Newsletter - historique</li>
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
					<h1>Historique</h1>
				</div>
				<div class="line"></div>
				<br>
				<div class="container">
					<div class="row">
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
						<?php
						foreach($news as $letter){
						?>
						<div class="col-md-6 col-12 text-center mb-4">
							<div style='background-color: #f6f9fc;'>
						        <div class='container'>
						          <div class='row'>
						            <div class='col-12' style='background-color: rgba(185, 168, 124, 0.5); border-radius: 10px; padding: 20px 20px;'>
						              <div class='m_a'>
						                <img src='https://econami.ddns.net/images/econami2.png'>
						              </div>
						              <div>
						                <p class='para'><?= $letter['contenu'] ?></p>
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
						          </div>
						        </div>
						      </div>
							<p>Date de création : <?= date_format(date_create($letter['date_creation']), 'd/m/Y à H:i') ?></p>
						</div>
					<?php
					}
					?>
					</div>
				</div>
				<div id="pagination" class="mb-2">

					<?php
					if($pagesTotales > 1) {

						if($pageCourante > 1) {
							?>
							<a style="border-radius: 10px;" class="page-numbers" href="back_histoNewsletter.php?page=<?= $pageCourante-1 ?>">Précédent</a>
							<?php
						} else {
							?>
							<span style="border-radius: 10px;" class="page-numbers disabled">Précédent</span>
							<?php
						}

						for($i=1;$i<=$pagesTotales;$i++){
							if($i == $pageCourante){
								?>
								<span class="page-numbers current"><?= $i ?></span>
								<?php
							} elseif($i == 1 || $i == $pagesTotales || ($i >= $pageCourante-2 && $i <= $pageCourante+2)) {
								?>
								<a class="page-numbers" href="back_histoNewsletter.php?page=<?= $i ?>"><?= $i ?></a>
								<?php
							} elseif($i == 2 || $i == $pagesTotales-1) {
								?>
								<span class="page-numbers dots">...</span>
								<?php
							}
						}

						if($pageCourante < $pagesTotales) {
							?>
							<a style="border-radius: 10px;" class="page-numbers" href="back_histoNewsletter.php?page=<?= $pageCourante+1 ?>">Suivant</a>
							<?php
						} else {
							?>
							<span style="border-radius: 10px;" class="page-numbers disabled">Suivant</span>
							<?php
						}
					}
					?>

					</div>
		<div><br><br></div>
	</main>

	<?php include 'include/footer.php' ?>
</body>
<script src="js/bootstrap.min.js"></script>

</html>