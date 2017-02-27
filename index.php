<?php
	session_start();
	include 'config/database.php';
	if (!$_SESSION['login']) {
		$_SESSION['login'] = "Unregister";
	}
	if (!$_SESSION['select']) {
		$_SESSION['select'] = "htdocs/login.php";
	}
?>
<html>
<?php
	include("htdocs/head.php");
?>
	<div class="contenu">
	<?php
		include($_SESSION['select']);
	?>
	</div>
</body>
</html>