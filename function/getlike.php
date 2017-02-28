<?php
include '../config/database.php';
$name = $_POST['name'];
$req = "SELECT `nb_like` FROM `Photo` WHERE `photo`='".$name."'";
$rep = $bdd->query($req);
$log = $rep->fetch();
if ($log['nb_like'])
	echo $log['nb_like'];
else
	echo '0';
?>