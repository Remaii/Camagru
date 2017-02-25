<?php
include '../config/database.php';
if ($_POST['path']){
	$path = $_POST['path'];
	try {
		$req = "DELETE FROM `Photo` WHERE `photo`='".$path."'";
		$reponse = $bdd->query($req);
		$path = "../".$path;
		unlink($path);
		echo 'OK';
	}
	catch (Exception $e) {
		echo $e;
	}
}
?>