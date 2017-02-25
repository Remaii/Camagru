<?php 
session_start();
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
		<!-- <div><a href="function/select.php?to=galerie">Galerie</a></div> -->
		<div><a href="../function/select.php?to=photo">Photomathon</a></div>
<?php
	if ($_SESSION['login'] != 'Unregister') {
		echo "<div id=\"userName\" value=\"".$_SESSION['login']."\"><a href=\"../function/select.php?to=compte\">ton Compte</a> <a href=\"../function/logout.php\">Logout</a></div>";
	}
	else {
		echo "<div><a href=\"../function/select.php?to=login\">Register/Login</a></div>";
	}
?>	
	</div>

<!-- Galerie -->
<div id="apercu">
	<img id="imgApe" src="../public/admin58b185679ac5e.png"><!-- src="../rsc/hidden.png"> -->
	<img id="like" src="../rsc/like.png">
	<div id="comment"></div>
</div>
<div id="miniGal"><?php
include '../config/database.php';
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
echo '<p id="pager" align="center">Page : ';
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
</div>
<script type="text/javascript">
function getApe(name) {
	var img = document.getElementById('imgApe');

	img.src = "../"+ name;
}

var like = document.getElementById('like');

like.addEventListener('click', function(){
	var xhr = new XMLHttpRequest(),
		to = document.getElementById('imgApe').src,
		tolen = to.indexOf('public'),
		src = document.getElementById('like').src,
		len = src.indexOf('rsc');

	src = src.slice(len);
	to = to.slice(tolen);
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			like.src = '../rsc/cross.png';
			alert(xhr.responseText);
		}
	}
	xhr.open("POST", "../function/like.php");
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("like=1&name="+src+"&to="+to);
}, false);

</script>

<!-- Footer -->
	<div id="footer">
		<p id="logued_on">Vous etes sur le compte: <?php echo $_SESSION['login']; ?></p>
		<p id="credit">Camagru © rthidet</p>
	</div>
</body>
</html>