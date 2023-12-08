<?php
try
{
	$bdd = new PDO('mysql:host=54.38.34.89:3306;dbname=econami', 'user', 'password', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
	die('Erreur PDO : ' . $e->getMessage());
}
?>