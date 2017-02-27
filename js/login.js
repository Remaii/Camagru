function toLogin() {
	var form = document.getElementById('form_log'),
		forgot = document.createElement('input'),
		lab_log = document.createElement('label'),
		login = document.createElement('input'),
		lab_pwd = document.createElement('label'),
		pwd = document.createElement('input'),
		submit = document.createElement('input');

	form.innerHTML = '';
	form.setAttribute('id','form_log');
	form.setAttribute('method','post');
	form.setAttribute('action','function/connect.php');
	forgot.setAttribute('id','forgot');
	forgot.setAttribute('type','button');
	forgot.setAttribute('value','Oublier?');
	lab_log.innerHTML = "Login<br>";
	login.setAttribute('type','text');
	login.setAttribute('name','login');
	lab_pwd.innerHTML = "Mot de Passe<br>";
	pwd.setAttribute('type','password');
	pwd.setAttribute('name','pwd');
	submit.setAttribute('id', 'sub');
	submit.setAttribute('type', 'submit');
	submit.setAttribute('value', 'Login');
	submit.setAttribute('name', 'log_but');

	form.appendChild(lab_log);
	form.appendChild(login);
	form.innerHTML += '<br>';
	form.appendChild(lab_pwd);
	form.appendChild(pwd);
	form.innerHTML += '<br>';
	form.appendChild(submit);
	form.appendChild(forgot);
}
function toRegister() {
	var form = document.getElementById('form_log'),
		lab_log = document.createElement('label'),
		login = document.createElement('input'),
		lab_pwd = document.createElement('label'),
		pwd = document.createElement('input'),
		lab_cfpwd = document.createElement('label'),
		cfpwd = document.createElement('input'),
		lab_mail = document.createElement('label'),
		mail = document.createElement('input'),
		submit = document.createElement('input');

	form.innerHTML = '';
	form.setAttribute('id','form_log');
	form.setAttribute('method','post');
	form.setAttribute('action','function/create_account.php');
	lab_log.innerHTML = "Login<br>";
	login.setAttribute('type','text');
	login.setAttribute('name','login');
	lab_pwd.innerHTML = "Mot de Passe<br>";
	pwd.setAttribute('type','password');
	pwd.setAttribute('name','pwd');
	lab_cfpwd.innerHTML = "Confirmer Mot de Passe<br>";
	cfpwd.setAttribute('type','password');
	cfpwd.setAttribute('name','cfpwd');
	lab_mail.innerHTML = "Mail<br>";
	mail.setAttribute('type','mail');
	mail.setAttribute('name','mail');
	submit.setAttribute('id', 'sub');
	submit.setAttribute('type', 'submit');
	submit.setAttribute('value', 'Register');
	submit.setAttribute('name', 'regist_but');

	form.appendChild(lab_log);
	form.appendChild(login);
	form.innerHTML += '<br>';
	form.appendChild(lab_pwd);
	form.appendChild(pwd);
	form.innerHTML += '<br>';
	form.appendChild(lab_cfpwd);
	form.appendChild(cfpwd);
	form.innerHTML += '<br>';
	form.appendChild(lab_mail);
	form.appendChild(mail);
	form.innerHTML += '<br>';
	form.appendChild(submit);
}
function toReset() {
	var form = document.getElementById('form_log'),
		lab_mail = document.createElement('label'),
		mail = document.createElement('input'),
		submit = document.createElement('input');

	form.innerHTML = '';
	form.setAttribute('id','form_log');
	form.setAttribute('method','post');
	form.setAttribute('action','function/reset.php');
	lab_mail.innerHTML = "Mail<br>";
	mail.setAttribute('type','mail');
	mail.setAttribute('name','mail');
	submit.setAttribute('id', 'sub');
	submit.setAttribute('type', 'submit');
	submit.setAttribute('value', 'Reset');
	submit.setAttribute('name', 'resetpwd');
	form.appendChild(lab_mail);
	form.appendChild(mail);
	form.innerHTML += '<br>';
	form.appendChild(submit);
}

var change = document.getElementById('changeur'),
	forgot = document.getElementById('forgot');

forgot.addEventListener('click', function(){
	toReset();
},false);

change.addEventListener('click', function(){
	var submit = document.getElementById('sub'),
		forgot = document.getElementById('forgot')
		name = submit.getAttribute('name');

	if (name == 'log_but'){
		toRegister();
		change.setAttribute('value', 'Connection');
	} else if (name == 'regist_but') {
		toLogin();
		change.setAttribute('value', 'Créer un compte');
		
		var forgot = document.getElementById('forgot');

		forgot.addEventListener('click', function(){
			toReset();
		},false);
	} else if (name == 'resetpwd') {
		toRegister();
		change.setAttribute('value', 'Connection');
	}
}, false);