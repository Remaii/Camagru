<?php
function getIdPhoto($name) {
	include '../config/database.php';

	try {
		$req = "SELECT * FROM `Photo` WHERE `photo`='".$name."'";
		$state = $bdd->prepare($req);
		$state->execute();
		$log = $state->fetch(PDO::FETCH_ASSOC);
		$id = $log['id'];
		return $id;
	} catch (PDOException $e) {
		return "Error ".$e->getMessage();
	}
}
function getNamePhoto($id) {
	include '../config/database.php';

	try {
		$req = "SELECT * FROM `Photo` WHERE `id`='".$id."'";
		$state = $bdd->prepare($req);
		$state->execute();
		$log = $state->fetch(PDO::FETCH_ASSOC);
		$id = $log['photo'];
		return $id;
	} catch (PDOException $e) {
		return "Error ".$e->getMessage();
	}
}
function getIdUser($usr) {
	include '../config/database.php';

	try {
		$req = "SELECT * FROM `Account` WHERE `login`='".$usr."'";
		$state = $bdd->prepare($req);
		$state->execute();
		$log = $state->fetch(PDO::FETCH_ASSOC);
		$id = $log['id'];
		return $id;
	} catch (PDOException $e) {
		return "Error ".$e->getMessage();
	}
}
function getNameUser($id) {
	include '../config/database.php';

	try {
		$req = "SELECT * FROM `Account` WHERE `id`='".$id."'";
		$state = $bdd->prepare($req);
		$state->execute();
		$log = $state->fetch(PDO::FETCH_ASSOC);
		$name = $log['login'];
		return $name;
	} catch (PDOException $e) {
		return "Error ".$e->getMessage();
	}
}
function searchLike($id_photo, $id_liker) {
	include '../config/database.php';

	if ($id_photo != '0') {
		try {
			$req = "SELECT * FROM `t_like` WHERE `id_liker`='".$id_liker."'";
			$state = $bdd->prepare($req);
			$state->execute();
			while ($log = $state->fetch(PDO::FETCH_ASSOC)) {
				if ($log['id_photo'] == $id_photo) {
					return true;
				}
			}
			return false;
		} catch (PDOException $e) {
			return "Error searchLike: ".$e->getMessage();
		}
	} else if ($id_liker == 0) {
		return '-1';
	}
}
function update($id_photo, $nb) {
	include '../config/database.php';

	$req = "SELECT `nb_like` FROM `Photo` WHERE `id`='".$id_photo."'";
	$state = $bdd->prepare($req);
	$state->execute();
	$nb_like = $state->fetch()[0];
	$nb_like = intval($nb) + intval($nb_like);
	$req = "UPDATE `Photo` SET `nb_like`='".$nb_like."' WHERE `id`='".$id_photo."'";
	$state = $bdd->prepare($req);
	$state->execute();
}
function like($id_photo, $id_liker) {
	include '../config/database.php';
	
	try {
		$req = "INSERT INTO `t_like`(`id_photo`, `id_liker`) VALUES ('".$id_photo."','".$id_liker."')";
		$state = $bdd->prepare($req);
		$state->execute();
		update($id_photo, '1');
	} catch (PDOException $e) {
		echo "Like fail: ".$e->getMessage();
	}
}
function dislike($id_photo, $id_liker) {
	include '../config/database.php';

	try {
		$req = "DELETE FROM `t_like` WHERE `id_photo`='".$id_photo."' AND `id_liker`='".$id_liker."'";
		$state = $bdd->prepare($req);
		$state->execute();
		update($id_photo, '-1');
	} catch (PDOException $e) {
		echo "Dislike fail: ".$e->getMessage();
	}
}
function mailTo($id_aut_com, $id_photo, $comment) {
	include '../config/database.php';

	$photo = getNamePhoto($id_photo);
	$name = getNameUser($id_aut_com);
	try {
		$req = "SELECT * FROM `Photo` WHERE `id`='".$id_photo."'";
		$state = $bdd->prepare($req);
		$state->execute();
		$log = $state->fetch(PDO::FETCH_ASSOC);
		$id_auteur = $log['id_auteur'];
	} catch (PDOException $e) {
		return "Error get id_auteur ".$e->getMessage();
	}
	if ($id_auteur == $id_aut_com || $id_auteur == 1) {
		return ;
	}
	try {
		$req = "SELECT * FROM `Account` WHERE `id`='".$id_auteur."'";
		$state = $bdd->prepare($req);
		$state->execute();
		$log = $state->fetch(PDO::FETCH_ASSOC);
		$mail = $log['mail'];
		$login = $log['login'];
	} catch (PDOException $e) {
		return "Error get mail ".$e->getMessage();
	}
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
	$sujet = "Camagru New Comment !";
	$mess_html = "
	<html>
	<body>
		<h1>Bonjour, un nouveau commentaire est arrivé</h1><br>
		<p>".$name." a poster:</p>
		<p>".$comment."</p><br>
		<a href=\"http://".$_SERVER['HTTP_HOST']."/htdocs/galerie.php?id=".$id_photo."\">La Photo !</a>
		<p>Cette e-mail est envoyer par un Script ne pas repondre</p>
	</body>
	</html>";
	mail($mail, $sujet, $mess_html, $header);
}
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
			<p>Bienvenue sur Camagru!</p>
			<p>Cette e-mail est envoyer par un Script ne pas repondre</p>
		</body>
		</html>";
	}
	else if ($forwhat === "pwd") {
		$sujet = "Hey ".$login." tu a demander un nouveau mot de passe !";
		$pwd = chr(rand(65,90));
		$pwd .= rand('0', '9');
		$pwd .= chr(rand(97,122));
		$pwd .= chr(rand(97,122));
		$pwd .= chr(rand(65,90));
		$pwd .= rand('0', '9');
		$requ = "UPDATE `Account` SET `passwd` = :pwd WHERE `login` = :login";
		$state = $bdd->prepare($requ);
		$state->bindParam(':pwd', hash('whirlpool',$pwd), PDO::PARAM_STR);
		$state->bindParam(':login', $login, PDO::PARAM_STR);
		$state->execute();
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
	mail($mail, $sujet, $mess_html, $header);
}
?>