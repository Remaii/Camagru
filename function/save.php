<?php
header("Content-Type: text/php");
include('../config/database.php');
if ($_POST['data'] && $_POST['login']) {
	$requete = "SELECT * FROM `Account` WHERE `login`=\"".$_POST['login']."\"";
	$state = $bdd->prepare($requete);
	$state->execute();
	while ($log = $state->fetch(PDO::FETCH_ASSOC)) {
		$id = $log['id'];
	}
	$to = $_POST['data'];
	$requete = "INSERT INTO `Photo`(`id_auteur`, `photo`, `nb_like`) VALUES ('".$id."', '".$to."', '0')";
	$state = $bdd->prepare($requete);
	$state->execute();
	echo $to;
}
else {
	echo "La Photo n'a pas pu etre partager :(";
}
?>