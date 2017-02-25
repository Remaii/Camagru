<?php
function sendMail($mail, $login, $forwhat) {
	require('../config/database.php');
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
		$backend = "\r\n";
	}
	else {
		$backend = "\n";
	}
	$header = "Content-type: text/html; charset=utf-8" .$backend;
	$header .= "From: \"Camagru\"<rthidet@student.42.fr>".$backend;
	$header .= "Reply-To: rthidet@student.42.fr".$backend;
	$header .= "X-Mailer: PHP/".phpversion();

	if ($forwhat === "register") {
		$sujet = "Hey ".$login." valide ton inscription !";
		$mess_html = "
		<html>
		<body>
			<h1>Bonjour, ".$login."</h1><br>
			<p>Cette e-mail est envoyer par un Script ne pas repondre</p>
			<a href=\"http://localhost:8080/Camagru/htdocs/confirm.php?login=".$login."\">Lien d'activation</a>
		</body>
		</html>";
	}
	else if ($forwhat === "pwd") {
		$mabase = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$sujet = "Hey ".$login." tu a demander un nouveau mot de passe !";
		$pwd = md5(rand());
		$requ = "UPDATE Account SET passwd = :pwd WHERE login = :login";
		$state = $mabase->prepare($requ);
		$state->bindParam(':pwd', hash('whirlpool',$pwd), PDO::PARAM_STR);
		$state->bindParam(':login', $login, PDO::PARAM_STR);
		$state->execute();
		// $result = $bdd->query($requ);
		$mess_html = "
		<html>
		<body>
			<h1>Bonjour, ".$login."</h1><br>
			<p>Cette e-mail est envoyer par un Script ne pas repondre</p>
			<p>Ton nouveau mot de passe est : <strong>".$pwd."</strong></p>
			<a href=\"http://localhost:8080/Camagru/\">Camagru</a>
		</body>
		</html>";
	}
	else if ($forwhat === "comment") {

	}
	mail($mail, $sujet, $mess_html, $header);
}
?>