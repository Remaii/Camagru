<?php
session_start();
if ($_SESSION['login'] != 'Unregister') {
	$_SESSION['login'] = 'Unregister';
	$_SESSION['select'] = 'htdocs/login.php';
}
header('Location: ../index.php');
?>