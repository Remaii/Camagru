<?php
session_start();
include '../config/database.php';
include 'function.php';

if (isset($_POST['rmpwd']) && $_POST['submit'] == 'Supprimer') {
	$req = "SELECT * FROM `Account` WHERE `login`= :login";
	$state = $bdd->prepare($req);
	$state->bindValue(':login', $_SESSION['login'], PDO::PARAM_STR);
	$state->execute();
	$pass = hash('whirlpool', $_POST['rmpwd']);
	$log = $state->fetch(PDO::FETCH_ASSOC);
	if ($log['passwd'] == $pass){
		$req = "DELETE FROM `Account` WHERE `login`=:log";
		$state = $bdd->prepare($req);
		$state->bindValue(':log', $_SESSION['login'], PDO::PARAM_STR);
		$state->execute();
		$_SESSION['login'] = "Unregister";
		$_SESSION['select'] = "htdocs/login.php";
		echo"<link rel='stylesheet' type='text/css' href='../style/style.css'><script>alert('Votre Compte a ete supprimer');window.location.href = ('../index.php');</script>";
	}
	else {
		echo"<link rel='stylesheet' type='text/css' href='../style/style.css'><script>alert('Mauvais mot de passe');window.location.href = ('../index.php');</script>";
	}
}
?>