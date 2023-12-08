<?php session_start();

//connexion à la bdd
include('include/db.php');

// Classement des utilisateurs en fonction de leur point
$q = 'SELECT pseudo, points, ROW_NUMBER() OVER (ORDER BY points DESC) AS classement
FROM users
ORDER BY points DESC
LIMIT 100';
$req = $bdd->prepare($q);
$req->execute();

$req_classementUsers = $req->fetchAll();

$title = 'Classement';
include('include/head.php');
?>
<!-- <link rel="stylesheet" type="text/css" href="css/styleforum.css">
 --></head>
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
 <style> 
		body { overflow-x: hidden; }
</style>
<body style="background-color: <?= $background_white?>;">
	<?php include 'include/header.php' ?>
	<main>
		<div class="row">
			<div class="col-2"></div>
			<div class="col-8 mb-4" style="background-color: <?= $background_marronClaire?>; border-radius: 10px;">
				<h1 class="text-center">
					CLASSEMENT
				</h1>
			</div>
		</div>
		<div class="container-fluid" style="background-color: <?= $background_marronClaire?>;">
			<div class="container">
				<div class="row forum__accueil__line">
					<div class="col-8">
						<h1 class="forum__accueil__h1">
							<i class="bi bi-award"></i>
						</h1>
					</div>
					<div class="col-4">
						<form class="mt-2" role="search">
							<input type="search" class="form-control" placeholder="Search..." id="search_user_input" aria-label="Search"oninput="searchUser()">
						</form>
					</div>
					<script src="js/searchUser.js"></script>
				</div>

				<div class="row" id="users_list">
					<div class="col-12">
						<table class="table table-striped table-bordered">

							<thead>
								<tr>
									<th scope="col">Classement</th>
									<th scope="col">Nom d'utilisateur</th>
									<th scope="col">Points</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($req_classementUsers as $user): ?>
									<tr>
										<td><?= $user['classement']?></td>
										<td><?= $user['pseudo'] ?></td>
										<td><?= $user['points'] ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>


	</div>
</div>


</div>

</main>

<?php include 'include/footer.php' ?>
</body>
<script src="js/bootstrap.min.js"></script>
</html>

