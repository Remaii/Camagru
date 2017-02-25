<?php
include 'database.php';
try
{
	try {
		$oldbdd = new PDO($DB_DSNCP, $DB_USER, $DB_PASSWORD);
		if ($oldbdd != null)
		{
			$reponse = $oldbdd->query('DROP DATABASE IF EXISTS Camagru');
			$bdd = null;
		}
	} catch (Exception $e) {
	$newbdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$reponse = $newbdd->query('CREATE DATABASE IF NOT EXISTS Camagru');
	$reponse->closeCursor();
	$freshbdd = new PDO($DB_DSNCP, $DB_USER, $DB_PASSWORD);
	$freshbdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$reponse = $freshbdd->query('CREATE TABLE IF NOT EXISTS Account (
		id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		login VARCHAR(255),
		passwd VARCHAR(255),
		mail VARCHAR(255),
		rank INT
	)');
	$pass = '6a4e012bd9583858a5a6fa15f58bd86a25af266d3a4344f1ec2018b778f29ba83be86eb45e6dc204e11276f4a99eff4e2144fbe15e756c2c88e999649aae7d94';
	$reponse = $freshbdd->query("INSERT INTO `Account`(`login`, `passwd`, `mail`, `rank`) VALUES ('admin','".$pass."','rthidet@student.42.fr','1')");
	$reponse->closeCursor();
	$reponse = $freshbdd->query('CREATE TABLE IF NOT EXISTS Photo (
		id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		id_auteur INT NOT NULL,
		photo VARCHAR(255),
		nb_like INT
	)');
	$reponse->closeCursor();
	$reponse = $freshbdd->query('CREATE TABLE IF NOT EXISTS Comment (
		id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		id_photo INT NOT NULL,
		id_auteur INT NOT NULL,
		comment VARCHAR(300)
	)');
	}
}
catch (Exception $e)
{
	echo "Error: ".$e;
}
?>