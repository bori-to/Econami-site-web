<div id="pagination" class="mb-2">

<?php
if($pagesTotales > 1) {

	if($pageCourante > 1) {
		?>
		<a style="border-radius: 10px;" class="page-numbers" href="back_commande.php?page=<?= $pageCourante-1 ?>">Précédent</a>
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
			<a class="page-numbers" href="back_commande.php?page=<?= $i ?>"><?= $i ?></a>
			<?php
		} elseif($i == 2 || $i == $pagesTotales-1) {
			?>
			<span class="page-numbers dots">...</span>
			<?php
		}
	}

	if($pageCourante < $pagesTotales) {
		?>
		<a style="border-radius: 10px;" class="page-numbers" href="back_commande.php?page=<?= $pageCourante+1 ?>">Suivant</a>
		<?php
	} else {
		?>
		<span style="border-radius: 10px;" class="page-numbers disabled">Suivant</span>
		<?php
	}
}
?>

</div>