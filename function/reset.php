<?php
require('../config/database.php');
require('function.php');
if ($_POST['mail'] != null || $_POST['mail'] != '') {
	$ok = 1;
	$mail = htmlspecialchars($_POST['mail']);
	$req = "SELECT * FROM Account";
	$state = $bdd->prepare($req);
	$state->execute();
	while ($log = $state->fetch(PDO::FETCH_ASSOC)) {
		$login = $log['login'];
		if ($mail === $log['mail']) {
			$ok = 0;
			sendMail($mail, $login, "pwd");
		}
	}
	if ($ok === 0) {
		header("Location: ../index.php");
	}
	else {
		echo"<link rel='stylesheet' type='text/css' href='../style/style.css'><script>alert('Desole, adresse mail inconnue');window.location.href = ('../index.php');</script>";
	}
}
?>