<?php 

if(isset($_GET['message']) && !empty($_GET['message']) && isset($_GET['type']) && !empty($_GET['type'])){
	echo '<div class="alert alert-'. htmlspecialchars($_GET['type']) . ' alert-dismissible fade show">' . htmlspecialchars($_GET['message']) . '
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>';
}

?>