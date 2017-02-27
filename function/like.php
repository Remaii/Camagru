<?php 
include 'function.php';
$like = intval($_POST['like']);
$to = $_POST['to'];
$usr = $_POST['usr'];
$id_liker = getIdUser($usr);
$id_photo = getIdPhoto($to);
if (searchLike($id_photo, $id_liker)) {
	dislike($id_photo, $id_liker);
}
else if (!searchLike($id_photo, $id_liker)) {
	like($id_photo, $id_liker);
}
?>