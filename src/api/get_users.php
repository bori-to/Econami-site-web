<?php

include('../include/db.php');
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
            foreach($reponse as $user){
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
<div id="pagination" class="mb-2">

    <?php
    if($pagesTotales > 1) {

        if($pageCourante > 1) {
            ?>
            <a style="border-radius: 10px;" class="page-numbers" href="back_end.php?page=<?= $pageCourante-1 ?>">Précédent</a>
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
                <a class="page-numbers" href="back_end.php?page=<?= $i ?>"><?= $i ?></a>
                <?php
            } elseif($i == 2 || $i == $pagesTotales-1) {
                ?>
                <span class="page-numbers dots">...</span>
                <?php
            }
        }

        if($pageCourante < $pagesTotales) {
            ?>
            <a style="border-radius: 10px;" class="page-numbers" href="back_end.php?page=<?= $pageCourante+1 ?>">Suivant</a>
            <?php
        } else {
            ?>
            <span style="border-radius: 10px;" class="page-numbers disabled">Suivant</span>
            <?php
        }
    }
    ?>

</div>