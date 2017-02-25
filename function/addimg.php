<?php
header ("Content-type: image/png");
$img1 = $_POST['canvas'];
$img2 = $_POST['toadd'];
$user = $_POST['user'];
$prevPath = '../public/';
if (!$img1 || !$img2 || !$user) {
	return FALSE;
}
else {
	$img1 = str_replace('data:image/png;base64,', '', $img1);
	$img1 = str_replace(' ', '+', $img1);
	$data = base64_decode($img1);
	file_put_contents('tmp1.png', $data);
// charge la premiere image(photo prise avec la webcam) ainsi que sa taille
	$destination = imagecreatefrompng('tmp1.png');
	$largeurSource = imagesx($destination);
	$hauteurSource = imagesy($destination);
	$img2 = str_replace('data:image/png;base64,', '', $img2);
	$img2 = str_replace(' ', '+', $img2);
	$data = base64_decode($img2);
	file_put_contents('tmp2.png', $data);
// charge la photo a superposer ainsi que sa taille & sa transparence
	$toAdd = imagecreatefrompng('tmp2.png');
	$largeurtoAdd = imagesx($toAdd);
	$hauteurtoAdd = imagesy($toAdd);
// Calcul des coordonnées pour placer l'image toadd sur destination
	$dest_x = ($largeurSource - $largeurtoAdd) / 2;
	$dest_y = ($hauteurSource - $hauteurtoAdd) / 2;
//place l'image
	imagecopy($destination, $toAdd, $dest_x, $dest_y, 0, 0, $largeurtoAdd, $hauteurtoAdd);
	$uniq = uniqid();
	$name = $user.$uniq.".png";
	$succes = imagepng($destination, $prevPath.$name);
	if ($succes) {
		unlink('tmp1.png');
		unlink('tmp2.png');
		$ret = "public/".$name;
		echo $ret;
	}
	else
		echo "fail";
}
?>