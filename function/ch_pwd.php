<?php
session_start();
include '../config/database.php';
include 'function.php';

if (isset($_POST['chpwd']) && $_POST['submit'] == 'Changer!') {
	$passwd = $_POST['chpwd'];
	$user = $_SESSION['login'];
	if (checkSecur($passwd) == FALSE) {
		echo"<link rel='stylesheet' type='text/css' href='../style/style.css'><script>alert('Mot de passe faible il doit faire 5 caractere minimum, 1 Majuscule et 1 chiffre requis');window.location.href = ('../index.php');</script>";
		return ;
	}
	$passwd = hash('whirlpool', $passwd);
	$req = "UPDATE `Account` SET `passwd`= :pwd WHERE `login`= :usr";
	$state = $bdd->prepare($req);
	$state->bindValue(':pwd', $passwd, PDO::PARAM_STR);
	$state->bindValue(':usr', $user, PDO::PARAM_STR);
	$state->execute();
	echo"<link rel='stylesheet' type='text/css' href='../style/style.css'><script>alert('Mot de passe Changer');window.location.href = ('../index.php');</script>";
}
?>