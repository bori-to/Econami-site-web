<?php session_start(); 
if(!isset($_SESSION['email']) || $_SESSION['type'] === '0'){
	header('location:index.php');
	exit;
}
//connexion à la bdd
include('include/db.php');
$ParPage = 10;
$TotalesReq = $bdd->query('SELECT id FROM users');
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
//connexion à la bdd

$q = 'SELECT * FROM users LIMIT '.$depart.','.$ParPage.'';
$req = $bdd->prepare($q);
$reponse = $bdd->query($q);

$title = 'Administrateur - Utilisateurs';
include('include/head.php');
?>
	<link rel="stylesheet" type="text/css" href="css/pagination.css">
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
	<body style="background-color: <?= $background_white?>;" onload="getUsers()">
		<?php include 'include/header.php' ?>
		<main>

			<div class="container">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="back_admin.php">Accueil administrateur</a></li>
						<li class="breadcrumb-item active" aria-current="page">Utilisateurs</li>
						<li style="margin-left: 150px;">
							<?php 

              				include('include/message.php');

              				?>
						</li>
					</ol>
				</nav>
				<div class="row">
					<div class="col-8">
						<h1>Utilisateurs</h1>
					</div>

					<div class="col-4">
						<form method="post">
          					<input name="tab" type="search" class="form-control" id="search_users_input" placeholder="Search..." aria-label="Search"oninput="searchUsers()">
          				</form>
					</div>
					<div id="users_list"></div>
					<script src="js/searchUsers.js"></script>     
				</div>
			</div>
			<div><br><br></div>
		</main>

		<?php include 'include/footer.php' ?>
	</body>
	<script src="js/bootstrap.min.js"></script>
</html>

