<?php 

session_start();

if(isset($_SESSION['id'])){
	$log = fopen('log.txt', 'a+');
	$line = date('d/m/Y - H:i:s') . ' - deconnexion de ' . $_SESSION['email'] . "\n";
	fputs($log, $line);
	fclose($log);
}

session_destroy();

header('location:index.php');
exit;

?>