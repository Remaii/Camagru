<?php
include '../config/database.php';
if ($_POST['path']){
	$path = $_POST['path'];
	try {
		$req = "SELECT * FROM `Photo` WHERE `photo`='".$path."'";
		$state = $bdd->prepare($req);
		$state->execute();
		$log = $state->fetch(PDO::FETCH_ASSOC);
		$id = $log['id'];
		$req = "DELETE FROM `Comment` WHERE `id_photo`='".$id."'";
		$state = $bdd->prepare($req);
		$state->execute();
		$req = "DELETE FROM `t_like` WHERE `id_photo`='".$id."'";
		$state = $bdd->prepare($req);
		$state->execute();
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