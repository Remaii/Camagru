<?php
session_start();
include '../config/database.php';
include 'function.php';

if ($_SESSION['login'] == 'Unregister') {
	echo"<link rel='stylesheet' type='text/css' href='../style/style.css'><script>alert('Connecte toi pour pourvoir commenter !');window.location.href = ('../index.php');</script>";
	return ;
}
if (isset($_POST['comment']) && isset($_POST['id_photo']) && $_POST['submit'] == "Commenter") {
	$id_auteur = getIdUser($_SESSION['login']);
	$id_pic = $_POST['id_photo'];
	$comment = $_POST['comment'];
	$req = "INSERT INTO `Comment`(`id_photo`, `id_auteur`, `comment`) VALUES (:id_pic, :id_auteur, :comment)";
	$state = $bdd->prepare($req);
	$state->bindValue(':id_pic', $id_pic, PDO::PARAM_STR);
	$state->bindValue(':id_auteur', $id_auteur, PDO::PARAM_STR);
	$state->bindValue(':comment', $comment, PDO::PARAM_STR);
	$state->execute();
	header('Location: ../htdocs/galerie.php');
} else {
	return;
}

?>