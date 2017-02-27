<input id="changeur" type="button" value="Creer un compte"><br>
<form id="form_log" method="post" action="function/connect.php">
	<label style="color:white;">Login</label><br>
	<input type="text" name="login"><br>
	<label style="color:white;">Mot de passe</label><br>
	<input type="password" name="pwd"><br>
	<input id="sub" type="submit" name="log_but" value="Login">
	<input id="forgot" type="button" href="function/select.php?to=resetpwd" value="Oublier?">
</form>
<script src="js/login.js"></script>