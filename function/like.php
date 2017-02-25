<?php 
include '../config/database.php';
$like = intval($_POST['like']);
$name = $_POST['name'];
$to = $_POST['to'];

if ($name && $to && ($like == 1 || $like == 0)) {


	if (file_exists("../".$to)) {
		//like ds la bdd
	}
}
else
	echo "error";
?>