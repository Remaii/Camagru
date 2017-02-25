<style type="text/css">
	#form_log
	{
		position: absolute;
		left: 45%;
		top: 40%;
		text-align: left;
		width: 20vw;
	}
</style>

<form id="form_log" method="post" action="function/connect.php">
	<input id="changeur" type="button" value="Creer un compte"><br>
	<label style="color:white;">Login</label><br>
	<input type="text" name="login"><br>
	<label style="color:white;">Mot de passe</label><br>
	<input type="password" name="pwd">
	<input id="forgot" type="button" href="function/select.php?to=resetpwd" value="Oublier?"><br>
	<input type="submit" name="log_but" value="Login">
</form>
<script src="js/login.js"></script>