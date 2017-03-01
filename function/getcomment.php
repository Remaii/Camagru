<?php
include '../config/database.php';
include 'function.php';

$name = $_POST['name'];
$user = $_POST['user'];
$id_photo = getIdPhoto($name);
$id_user = getIdUser($user);
$req = "SELECT * FROM `Comment` WHERE `id_photo`='".$id_photo."'";
$state = $bdd->prepare($req);
$state->execute();
while ($log = $state->fetch(PDO::FETCH_ASSOC)) {
	if ($log['id_auteur'] == $id_user) {
		echo '<p class="commentaire" style="text-align:right;">Vous avez dit:<br>'.$log['comment'].'</p>';
	}
	else {
		echo '<p class="commentaire" style="text-align:left;">'.getNameUser($log['id_auteur']).' dit:<br>'.$log['comment'].'</p>';
	}
}
?>

