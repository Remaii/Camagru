<?php
include 'function.php';
if (isset($_POST['name'])) {
	$id = getIdPhoto($_POST['name']);
	echo $id;
} else {
	echo '0';
}
?>