<?php
session_start();
include('../config/database.php');
$reponse = $bdd->prepare("UPDATE Account SET rank='2' WHERE `login`= :log");
$reponse->bindValue(':log', $_GET['login'], PDO::PARAM_STR);
$reponse->execute();
header('Location: ../');
?>