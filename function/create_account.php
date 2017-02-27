<?php
session_start();
include('../config/database.php');
include('function.php');

// function checkSecur($pwd) {
// 	$maj = 0;
// 	$num = 0;
// 	$i = 0;
// 	while ($pwd[$i]) {
// 		if ($pwd[$i] > 47 || $pwd < 58) {
// 			$num++;
// 		}
// 		else if ($pwd[$i] > 64 || $pwd < 91) {
// 			$maj++;
// 		}
// 	}
// 	if ($maj > 0 && $num > 0 && $i > 4) {
// 		return true;
// 	}
// 	else {
// 		return false;
// 	}
// }

$reponse = $bdd->query("SELECT * FROM Account");
if ($_POST['login'] && $_POST['pwd'] && $_POST['cfpwd'] && $_POST['mail']) {
	$login = $_POST['login'];
	$passwd = $_POST['pwd'];
	// if (checkSecur($passwd) == FALSE) {
	// 	echo"<link rel='stylesheet' type='text/css' href='../style/style.css'><script>alert('Mot de passe faible il doit faire 5 caractere minimum, 1 Majuscule et 1 chiffre requis');window.location.href = ('../index.php');</script>";
	// }
	$passwd = hash('whirlpool', $passwd);
	$cfmpasswd = hash('whirlpool', $_POST['cfpwd']);
	$mail = $_POST['mail'];
	if (strstr($mail, '@') == FALSE) {
		echo"<link rel='stylesheet' type='text/css' href='../style/style.css'><script>alert('Mauvais format de Mail');window.location.href = ('../index.php');</script>";
		return ;
	}
	if ($passwd === $cfmpasswd) {
		while ($logs = $reponse->fetch()) {
			if ($logs['login'] == $login || $logs['mail'] == $mail) {
				echo"<link rel='stylesheet' type='text/css' href='../style/style.css'><script>alert('Utilisateur ou Email deja utiliser');window.location.href = ('../index.php');</script>";
			}
		}
		$reponse->closeCursor();
		$requete = "INSERT INTO `Account`(`login`, `passwd`, `mail`, `rank`) VALUES (:login, :passwd, :mail,'3')";
		$state = $bdd->prepare($requete);
		$state->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
		$state->bindValue(':passwd', $passwd, PDO::PARAM_STR);
		$state->bindValue(':mail', $_POST['mail'], PDO::PARAM_STR);
		$state->execute();
		$_SESSION['login'] = $login;
		sendMail($mail, $login, 'register');
		$_SESSION['select'] = "htdocs/photo.php";
		header('Location: ../');
	}
}
else {
	echo"<link rel='stylesheet' type='text/css' href='../style/style.css'><script>alert('Ta rien mis ou un des champs est vide :/');window.location.href = ('../index.php');</script>";
	return ;
}
?>