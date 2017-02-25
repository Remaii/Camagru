<?php
session_start();
include('../config/database.php');
$reponse = "SELECT * FROM Account";
$state = $bdd->prepare($reponse);
$state->execute();
$logst = 1;
if ($_POST['login'] != '' && $_POST['pwd'] != '') {
		while ($logs = $state->fetch()) {
			if ($logs['login'] == htmlentities($_POST['login'])) {
				if ($logs['passwd'] == hash('whirlpool', htmlentities($_POST['pwd']))) {
					$_SESSION['login'] = $logs['login'];
					$logst = 0;
				}
			}
		}
		if ($logst == 0) {
			$_SESSION['select'] = "htdocs/photo.php";
			header('Location: ../index.php');
		}
		else {
			echo"<link rel='stylesheet' type='text/css' href='../style/style.css'><script>alert('Mauvaise combinaison');window.location.href = ('../index.php');</script>";
		}
}
else {
	echo"<link rel='stylesheet' type='text/css' href='../style/style.css'><script>alert('Ta rien mis');window.location.href = ('../index.php');</script>";
}
?>