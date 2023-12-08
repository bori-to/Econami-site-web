<?php

function writeLog($page){

	$log = fopen('log.txt', 'a+');

	$line = 'Navigation : ' . date('d/m/Y - H:i:s') . ' - ' . $_SESSION['email'] . ' / ' . $_SESSION['pseudo'] . ' est maintenant sur la page ' . $page . "\n";

	fputs($log, $line);

	fclose($log);
}

// writeLog($title);

?>