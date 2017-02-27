<?php
header("Content-Type: text/php");
include('../config/database.php');
if ($_POST['data'] && $_POST['login']) {
	$requete = "SELECT * FROM `Account` WHERE login=\"".$_POST['login']."\"";
	$table = $bdd->query($requete);
	while ($log = $table->fetch()) {
		$id = $log['id'];
	}
	$to = $_POST['data'];
	$requete = "INSERT INTO `Photo`(`id_auteur`, `photo`, `nb_like`) VALUES ('".$id."', '".$to."', '0')";
	$bdd->query($requete);
	echo $to;
}
else {
	echo "La Photo n'a pas pu etre partager :(";
}
?>