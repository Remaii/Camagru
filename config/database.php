<?php
$DB_DSN = 'mysql:host=localhost;';
$DB_USER = 'root';
$DB_PASSWORD = 'root';
$DB_DSNCP = 'mysql:host=localhost;dbname=Camagru';
try {
	$bdd = new PDO($DB_DSNCP, $DB_USER, $DB_PASSWORD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e) {
	$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
?>