<?php
include 'function.php';
$name = $_POST['name'];
$user = $_POST['user'];
$id_liker = intval(getIdUser($user));
$id_photo = intval(getIdPhoto($name));
if (searchLike($id_photo, $id_liker)) {
	echo "1";
} else if (!searchLike($id_photo, $id_liker)){
	echo "0";
} else {
	echo searchLike($id_photo, $id_liker);
}
?>