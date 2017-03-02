<?php 
session_start();
include '../config/database.php';
include '../function/function.php';
?>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../style/style.css">
	<!-- <meta http-equiv="refresh" content="2"> -->
	<title>Camagru</title>
<!-- 	<script type="text/javascript" src="../js/galerie.js"></script> -->
</head>
<body>
<!-- Menu  -->
	<div id="head">
		<div><a href="galerie.php">Galerie</a></div>
		<div><a href="../function/select.php?to=photo">Photomathon</a></div>
<?php
	if ($_SESSION['login'] != 'Unregister') {
		if ($_SESSION['login'] == 'admin') {
			echo "<div id=\"userName\" value=\"".$_SESSION['login']."\"><a href=\"../phpmyadmin\">Phpmyadmin</a> <a href=\"../config/setup.php\">Setup</a> <a href=\"../function/select.php?to=compte\">ton Compte</a> <a href=\"../function/logout.php\">Logout</a></div>";
		} else {
			echo "<div id=\"userName\" value=\"".$_SESSION['login']."\"><a href=\"../function/select.php?to=compte\">ton Compte</a> <a href=\"../function/logout.php\">Logout</a></div>";
		}
	}
	else {
		echo "<div id=\"userName\" value=\"".$_SESSION['login']."\"><a href=\"../function/select.php?to=login\">Register/Login</a></div>";
	}
?>	
	</div>

<!-- Aperçu -->
<div id="apercu">
<?php
	if (isset($_GET['id'])) {
		$photo = getNamePhoto(intval($_GET['id']));
		echo '<img id="imgApe" onload="getApe(\''.$photo.'\')" src="../'.$photo.'">
		<img id="like" src="../rsc/hidden.png">';

	}
	else {
		echo '<img id="imgApe" src="../rsc/hidden.png">
		<img id="like" src="../rsc/hidden.png">';	
	}
?>
	<div id="nb_like" value=""></div>
	<form id="tocomment" method="POST" action="../function/addCom.php" style="display: none;">
		<input id="id_pic" type="text" style="display: none;" name="id_photo" value="">
		<textarea type="text" style="width: 100%;height:50%;" name="comment" value=""></textarea>
		<input type="submit" name="submit" value="Commenter">
	</form>
	<div id="comment">
		
	</div>
</div>

<!-- Galerie -->
<div id="miniGal"><?php

// nombre d'element par pages
$nbPerPage = 5;
// recuperation du nombre d'element total
try {
	$state = $bdd->prepare("SELECT COUNT(*) AS 'total' FROM `Photo`");
	$state->execute();
	$donnee = $state->fetch(PDO::FETCH_ASSOC);
	$total = $donnee['total'];
	$nbDePage = ceil($total/$nbPerPage);
} catch (PDOException $e){
	echo 'Error: recuperation du nombre d\'element '.$e->getMessage();
}
// definition de la page actuelle
if (isset($_GET['page'])) {
	$pageActuel = intval($_GET['page']);
	if ($pageActuel > $nbDePage) {
		$pageActuel = $nbDePage;
	}
} else {
	$pageActuel = 1;
}
// definition de la premiere entree pour la bdd
$premiereEntree = ($pageActuel - 1) * $nbPerPage;
try {
	$state = $bdd->prepare("SELECT * FROM `Photo` ORDER BY `id` LIMIT ".$premiereEntree.", ".$nbPerPage);
	$state->execute();
	while ($log = $state->fetch(PDO::FETCH_ASSOC)) {
		$tmp = "getApe('".$log['photo']."')";
		echo '<div onclick="'.$tmp.'"><img class="imgGal" src="../'.$log['photo'].'"></div>';
	}
} catch (PDOException $e){
	echo 'Error: affichage des elements '.$e->getMessage();
}
echo '</div><p id="pager" align="center">Page : ';
if ($nbDePage != 0) {
	for($i=1;$i<=$nbDePage;$i++) {
		if($i == $pageActuel) {
			echo '['.$i.']'; 
		}
		else {
			echo ' <a href="galerie.php?page='.$i.'">'.$i.'</a> ';
		}
	}
}
else {
	echo '[0]';
}

echo '</p>';
?>
<script type="text/javascript" src="../js/function.js"></script>
<script type="text/javascript" src="../js/galerie.js"></script>

<!-- Footer -->
	<div id="footer">
		<p id="logued_on" style="margin-top: 25%;">Vous etes sur le compte: <?php echo $_SESSION['login']; ?></p>
		<p id="credit"  style="margin-top: 25%;">Camagru © rthidet</p>
	</div>
</body>
</html>