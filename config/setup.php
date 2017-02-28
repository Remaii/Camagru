<?php 
session_start();
?>
<html>
<head>
	<title>Setup Camagru</title>
	<link rel="stylesheet" type="text/css" href="../style/style.css">
</head>
<body>
<div id="head"><a href="../index.php">Index</a></div>
<div id="center">
<?php
include 'database.php';
try {
	$oldbdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	if ($oldbdd != null) {
		echo "Suppression de l'ancienne base ->";
		$sql = 'DROP DATABASE IF EXISTS Camagru';
		$state = $oldbdd->prepare($sql);
		$state->execute();
		$oldbdd = null;
		echo " Base Camagru supprimer <br><br>";
	}
	echo "Création d'une nouvelle Base de Donnée<br>";
	$newbdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	
	$sql = 'CREATE DATABASE IF NOT EXISTS Camagru';
	$state = $newbdd->prepare($sql);
	$state->execute();

	echo "Connection à la nouvelle base<br><br>";
	$freshbdd = new PDO($DB_DSNCP, $DB_USER, $DB_PASSWORD);
	$freshbdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Création de la table Account -->";

	$sql = 'CREATE TABLE IF NOT EXISTS Account (
		id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		login VARCHAR(255),
		passwd VARCHAR(255),
		mail VARCHAR(255),
		rank INT
	)';
	$state = $freshbdd->prepare($sql);
	$state->execute();
	
	echo " Table account créer -->";
	$pass = '6a4e012bd9583858a5a6fa15f58bd86a25af266d3a4344f1ec2018b778f29ba83be86eb45e6dc204e11276f4a99eff4e2144fbe15e756c2c88e999649aae7d94';
	
	$sql = "INSERT INTO `Account`(`login`, `passwd`, `mail`, `rank`) VALUES ('admin','".$pass."','rthidet@student.42.fr','1')";
	$state = $freshbdd->prepare($sql);
	$state->execute();
	
	echo " Admin ajouté<br><br>";
	echo "Création de la table photo -->";
	$sql = 'CREATE TABLE IF NOT EXISTS Photo (
		id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		id_auteur INT NOT NULL,
		photo VARCHAR(255),
		nb_like INT
	)';
	$state = $freshbdd->prepare($sql);
	$state->execute();

	echo " Table Photo créer<br><br>Création table Comment -->";
	$sql = 'CREATE TABLE IF NOT EXISTS Comment (
		id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		id_photo INT NOT NULL,
		id_auteur INT NOT NULL,
		comment VARCHAR(145)
	)';
	$state = $freshbdd->prepare($sql);
	$state->execute();

	echo " Table Comment créer<br><br>Création table Like -->";
	$sql = 'CREATE TABLE IF NOT EXISTS t_like (
		id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		id_photo INT NOT NULL,
		id_liker INT NOT NULL
	)';
	$state = $freshbdd->prepare($sql);
	$state->execute();

	echo " Table like créer<br><br>Vérification de la présence de photo -->";
	$dir = '../public';
	$dh = opendir($dir);
	$nb_photo = 0;
	while (false !== ($filename = readdir($dh))) {
		if ($filename[0] != '.') {
			$file[] = $filename;
			$nb_photo++;
		}
	}
	echo " il y a ".$nb_photo." fichier(s)<br>Ajout:";
	$j = 0;
	while ($j < $nb_photo) {
		echo ".";
		$like = rand('0',$nb_photo);
		$sql = "INSERT INTO `Photo`(`id_auteur`, `photo`, `nb_like`) VALUES ('1','public/".$file[$j]."','".$like."')";
		$state = $freshbdd->prepare($sql);
		$state->execute();
		$j++;
	}
	echo " Done";
} catch (PDOException $e) {
	echo "Error: ".$e->getMessage();
}
?>
</div>
</body>
</html>