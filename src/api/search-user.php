<?php

if(isset($_GET['name']) && !empty($_GET['name']) && $_GET['name'] !== ' ' && strlen($_GET['name']) >= 1){

	$name = $_GET['name'];


	include('../include/db.php');

	$q = 'SELECT pseudo, points
	FROM users WHERE pseudo LIKE ?
	ORDER BY points DESC
	LIMIT 100 ';
/*
$q ='SELECT ROW_NUMBER() OVER (ORDER BY points DESC) AS classement
FROM users WHERE pseudo LIKE ?
ORDER BY points DESC
LIMIT 100 ';
*/

$stmt = $bdd->prepare($q);
$success = $stmt->execute([
	"%" . $name . "%"
]);	
if($success){
	$user = $stmt->fetchAll(PDO::FETCH_ASSOC);

	?>
	<div class="row">
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
					<?php foreach($user as $users): ?>
						<tr>
							<?php
							$q ='SELECT count(*) as classement FROM users WHERE points > (SELECT points FROM users WHERE pseudo = ?)';
							$stmt = $bdd->prepare($q);
							$success = $stmt->execute([$users['pseudo']]);	
							$classement = $stmt->fetch(PDO::FETCH_ASSOC);
							$nbrClassement = $classement['classement'] + 1;?>

								<td> <?= $nbrClassement ?></td>
								<td><?= $users['pseudo'] ?></td>
								<td><?= $users['points'] ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

		</div>
		<?php
	}
}



?>