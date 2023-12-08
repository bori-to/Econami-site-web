<?php


	$name = $_GET['name'];


	include('../include/db.php');

	$q = "SELECT * FROM users WHERE pseudo LIKE ? OR email LIKE ?";

	$stmt = $bdd->prepare($q);
	$success = $stmt->execute([
		"%" . $name . "%",
		"%" . $name . "%"
	]);	
	if($success){
		$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		?>
		<div id="tableaux" class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Pseudo</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prenom</th>
                                    <th scope="col">Date de naissance</th>
                                    <th scope="col">Points</th>
                                    <th scope="col">solde</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Newsletter</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($users as $user){
                                	$chemin_avatar = null;

									if(isset($user['image'])){
										$chemin_avatar = 'avatar/' .  $user['image'];
									}else{
										$chemin_avatar = 'avatar/defaut/icon_profil.svg';
									}
                                    echo "<tr>";
                                        echo '<td>'.$user['id'].'</td>';
                                        echo '<td>'.$user['email'].'</td>';
                                        echo '<td>'.$user['pseudo'].'</td>';
                                        echo '<td>'.$user['nom'].'</td>';
                                        echo '<td>'.$user['prenom'].'</td>';
                                        ?>
                                        <td> <?= date_format(date_create($user['age']), 'd/m/Y') ?> </td>
                                        <?php
                                        echo '<td>'.$user['points'].'</td>';
                                        echo '<td>'.$user['solde'].' €</td>';
                                        ?>
                                        <td>
                                        	<img src="<?= $chemin_avatar ?>" class="profil__avatar" width="32" height="32">
                                        </td>
                                        <td>
                                        	<?php
											if($user['newsletter'] == 'true'){
											?>
											<div class="form-check form-switch">
		  										<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckCheckedDisabled" checked disabled>
											</div>
											<?php
											}else{
											?>
											<div class="form-check form-switch">
		  										<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDisabled" disabled>
											</div>
											<?php
											}
											?>
                                        </td>
                                        <?php
                                        echo '<td>
                                                <form action="back_voir-profil.php" method="post">
													<button class="btn btn-primary" type="submit" id="button" name="id" value="' . $user['id'] . '"> Modifier </button>
												</form></td>';
												if($user['type'] === '2'){
												echo '
												<td>
												<form action="back_bannir.php" method="post">
													<button class="btn btn-warning" type="submit" id="button" name="id" value="' . $user['id'] . '"> Débannir </button>
												</form>
												</td>';
												}else{
												echo '
												<td>
												<form action="back_bannir.php" method="post">
													<button class="btn btn-warning" type="submit" id="button" name="id" value="' . $user['id'] . '"> Bannir </button>
												</form>
												</td>';
												}
										echo '<td>
                                                <form action="back_suprUsers.php" method="post">
													<button class="btn btn-danger" type="submit" id="button" name="id" value="' . $user['id'] . '"> Supprimer </button>
												</form>
                                                    
                                               </td>';
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
	}




?>