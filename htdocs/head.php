<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<!-- <meta http-equiv="refresh" content="2"> -->
	<title>Camagru</title>
</head>
<body>
	<div id="head">
		<div><a href="htdocs/galerie.php">Galerie</a></div>
		<div><a href="function/select.php?to=photo">Photomathon</a></div>
<?php
	if ($_SESSION['login'] != 'Unregister') {
		echo "<div id=\"userName\" value=\"".$_SESSION['login']."\"><a href=\"function/select.php?to=compte\">ton Compte</a> <a href=\"function/logout.php\">Logout</a></div>";
	}
	else {
		echo "<div><a href=\"function/select.php?to=login\">Register/Login</a></div>";
	}
?>	
	</div>

	<div id="footer">
		<p id="logued_on">Vous etes sur le compte: <?php echo $_SESSION['login']; ?></p>
		<p id="credit">Camagru © rthidet</p>
	</div>