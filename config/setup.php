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
if ($_SESSION['login'] == 'admin') {
try
{
	$oldbdd = new PDO($DB_DSNCP, $DB_USER, $DB_PASSWORD);
	if ($oldbdd != null)
	{
		echo "Suppression de l'ancienne base ->";
		$oldbdd->query('DROP DATABASE IF EXISTS Camagru');
		$oldbdd = null;
		echo " Base Camagru supprimer <br><br>";
	}
	echo "Creation d'une nouvelle Base de Donnée<br>";
	$newbdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$reponse = $newbdd->query('CREATE DATABASE IF NOT EXISTS Camagru');
	$reponse->closeCursor();
	echo "Connection a la nouvelle base<br><br>";
	$freshbdd = new PDO($DB_DSNCP, $DB_USER, $DB_PASSWORD);
	$freshbdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Creation de la table Account -->";
	$reponse = $freshbdd->query('CREATE TABLE IF NOT EXISTS Account (
		id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		login VARCHAR(255),
		passwd VARCHAR(255),
		mail VARCHAR(255),
		rank INT
	)');
	echo " Table account creer -->";
	$pass = '6a4e012bd9583858a5a6fa15f58bd86a25af266d3a4344f1ec2018b778f29ba83be86eb45e6dc204e11276f4a99eff4e2144fbe15e756c2c88e999649aae7d94';
	$reponse = $freshbdd->query("INSERT INTO `Account`(`login`, `passwd`, `mail`, `rank`) VALUES ('admin','".$pass."','rthidet@student.42.fr','1')");
	$reponse->closeCursor();
	echo " Admin ajouter<br><br>";
	echo "Creation de la table photo -->";
	$reponse = $freshbdd->query('CREATE TABLE IF NOT EXISTS Photo (
		id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		id_auteur INT NOT NULL,
		photo VARCHAR(255),
		nb_like INT
	)');
	$reponse->closeCursor();
	echo " Table Photo creer<br><br>Creation table Comment -->";
	$reponse = $freshbdd->query('CREATE TABLE IF NOT EXISTS Comment (
		id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		id_photo INT NOT NULL,
		id_auteur INT NOT NULL,
		comment VARCHAR(300)
	)');
	$reponse->closeCursor();
	echo " Table Comment creer<br><br>Creation table Like -->";
	$reponse = $freshbdd->query('CREATE TABLE IF NOT EXISTS t_like (
		id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
		id_photo INT NOT NULL,
		id_liker INT NOT NULL
	)');
	$reponse->closeCursor();
	echo " Table like creer<br><br>Verification de la presence de photo -->";
	$dir = '../public';
	$dh = opendir($dir);
	$nb_photo = 0;
	while (false !== ($filename = readdir($dh))) {
		if ($filename[0] != '.') {
			$file[] = $filename;
			$nb_photo++;
		}
	}
	echo " il y a ".$i." fichier(s)<br>Ajout:";
	$j = 0;
	while ($j < $nb_photo) {
		echo ".";
		$like = rand('0','100');
		$req = "INSERT INTO `Photo`(`id_auteur`, `photo`, `nb_like`) VALUES ('1','public/".$file[$j]."','".$like."')";
		$freshbdd->query($req);
		$j++;
	}
}
catch (Exception $e)
{
	echo "Error: ".$e;
}
} else {
	echo '<p>Vous n\'avez pas les droits </p>';
}
?>
</div>
</body>
</html>