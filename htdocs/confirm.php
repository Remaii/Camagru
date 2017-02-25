<?php
session_start();
include('../config/database.php');
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$reponse = $db->query("UPDATE Account SET rank='2' WHERE login='".$_GET['login']."';");
header('Location: ../');
?>