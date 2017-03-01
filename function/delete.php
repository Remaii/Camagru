<?php
include '../config/database.php';
if ($_POST['path']){
	$path = $_POST['path'];
	try {
		$req = "DELETE FROM `Photo` WHERE `photo`='".$path."'";
		$state = $bdd->prepare($req);
		$state->execute();
		$path = "../".$path;
		unlink($path);
		echo 'OK';
	}
	catch (PDOException $e) {
		echo "Error delete photo: ".$e->getMessage();
	}
}
?>