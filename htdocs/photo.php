<?php
if ($_SESSION['login'] != 'Unregister') {
?>
<div id="photo">
	<img id="activ" src="rsc/cam.png">
	<img id="plus" src="rsc/plus.png">
	<img id="moin" src="rsc/moin.png">
	<img id="click" src="rsc/app.png">
	<video id="video"></video>
	<img id="onVid" src="rsc/hidden.png">
	<div id="toAdd">
		<p style="margin-top:0%;text-align:center;font-size:60%;">Les filtres</p>
		<img class="onImg" src="rsc/troll.png">
		<input type="radio" value="troll" name="toadd">
		<img class="onImg" src="rsc/arbre.png">
		<input type="radio" value="arbre" name="toadd">
		<img class="onImg" src="rsc/fract.png">
		<input type="radio" value="fract" name="toadd">
		<img class="onImg" src="rsc/nyancat.png">
		<input type="radio" value="nyancat" name="toadd">
		<img class="onImg" src="rsc/parasol.png">
		<input type="radio" value="parasol" name="toadd">
		<input class="onImg" type="button" value="Choose" onclick="checker();">
	</div>
	<canvas id="canvas"></canvas>
	<input id="toUpload" type="file" name="toUpload" accept="image/png" onchange="getImg();">
</div>

<div id="myMount">
	<p id="mount" style="margin-top:0%;text-align:center;font-size:60%;">Mes Montages</p>
<?php
	include 'config/database.php';
	try {
		$id = "SELECT * FROM `Account` WHERE `login`='".$_SESSION['login']."'";
		$reponse = $bdd->query($id);
		while ($log = $reponse->fetch())
		{
			$id = $log['id'];
		}
		$req = "SELECT * FROM Photo WHERE `id_auteur`='".$id."' ORDER BY  `id` DESC";
		$reponse = $bdd->query($req);
		while ($log = $reponse->fetch())
		{
			$path = basename($log['photo']);
			$func = "deleteIMG('public/".$path."')";
			echo '<div onclick="'.$func.'"><img class="imgdone" src="'.$log['photo'].'" alt="'.$log['photo'].'"></div>';
		}
	}
	catch (PDOException $e)
	{
		echo "Error: ".$e->getMessage();
	}
?>
</div>

<script type="text/javascript" src="js/function.js"></script>
<script type="text/javascript" src="js/photo.js"></script>

<?php
}
else {
?>	<div id="center">
	<p style="color: white;">Désolé,</p>
	<p style="color: white;">il faut etre enregistrer pour acceder a cette page</p>
	</div>
<?php
}
?>