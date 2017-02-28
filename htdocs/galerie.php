<?php 
session_start();
include '../config/database.php';
?>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../style/style.css">
	<!-- <meta http-equiv="refresh" content="2"> -->
	<title>Camagru</title>
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
	<!-- <img id="imgApe" src="../public/leopard.jpg"> -->
	<!-- <img id="like" src="../rsc/load1.gif"> -->
	<img id="imgApe" src="../rsc/hidden.png">
	<img id="like" src="../rsc/hidden.png">
	<div id="nb_like" value=""></div>
	<form id="tocomment" method="POST" action="../function/addCom.php">
		<input id="id_pic" type="text" style="display: none;" name="id_photo" value="">
		<textarea type="text" style="width: 100%;" name="comment" value=""></textarea>
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
	$reponse = $bdd->query("SELECT COUNT(*) AS total FROM `Photo`");
	$donnee = $reponse->fetch();
	$total = $donnee['total'];
	$nbDePage = ceil($total/$nbPerPage);
} catch (Exception $e){
	echo 'Error: recuperation du nombre d\'element '.$e;
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
	$retour = $bdd->query("SELECT * FROM `Photo` ORDER BY `id` LIMIT ".$premiereEntree.", ".$nbPerPage);
	while ($log = $retour->fetch()) {
		$tmp = "getApe('".$log['photo']."')";
		echo '<div onclick="'.$tmp.'"><img class="imgGal" src="../'.$log['photo'].'"></div>';
	}
} catch (Exception $e){
	echo 'Error: affichage des elements '.$e;
}
echo '</div><p id="pager" align="center">Page : ';
for( $i = 1; $i <= $nbDePage; $i++) {
	if( $i == $pageActuel) {
		echo ' [ '.$i.' ] '; 
	}
	else {
		echo ' <a href="galerie.php?page='.$i.'">'.$i.'</a> ';
	}
}
echo '</p>';
?>
<!-- </div> -->
<script type="text/javascript" src="../js/function.js"></script>
<script type="text/javascript" src="../js/galerie.js"></script>

<!-- Footer -->
	<div id="footer">
		<p id="logued_on" style="margin-top: 25%;">Vous etes sur le compte: <?php echo $_SESSION['login']; ?></p>
		<p id="credit"  style="margin-top: 25%;">Camagru © rthidet</p>
	</div>
</body>
</html>