<?php
include '../config/database.php';
$name = $_POST['name'];
$req = "SELECT `nb_like` FROM `Photo` WHERE `photo`='".$name."'";
$state = $bdd->prepare($req);
$state->execute();
$log = $state->fetch();
if (intval($log['nb_like']) != 0)
	echo $log['nb_like'];
else
	echo '0';
?>