<?php
header('Location: ../index.php');
session_start();
if ($_GET['to']) {
	$_SESSION['select'] = "htdocs/".$_GET['to'].".php";
	if (file_exists("../".$_SESSION['select']))
		return;
	else
		$_SESSION['select'] = "htdocs/home.php";		
}
else
	$_SESSION['select'] = "htdocs/home.php";
?>