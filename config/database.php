<?php
$DB_DSN = 'mysql:host=localhost;';
$DB_USER = 'root';
$DB_PASSWORD = 'root';
$DB_DSNCP = 'mysql:host=localhost;dbname=Camagru';
try {
	$bdd = new PDO($DB_DSNCP, $DB_USER, $DB_PASSWORD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
	$link = $_SERVER['HTTP_HOST']."/Camagru/config/setup.php";
	// header('Location: '.$link'.');
	echo "<link rel='stylesheet' type='text/css' href='../style/style.css'><script>window.location.href = ('http://".$link."');</script>";
}
?>