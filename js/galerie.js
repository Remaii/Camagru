function getComment(name) {
	var xhr = getXHR(),
		user = document.getElementById('userName').getAttribute('value'),
		comment = document.getElementById('comment');

	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			comment.innerHTML = xhr.responseText;
		}
	}
	xhr.open("POST", "../function/getcomment.php");
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("name="+name+"&user="+user);
}

function getLike(name) {
	var xhr = getXHR(),
		nblike = document.getElementById('nb_like');

	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			nblike.innerHTML = xhr.responseText;
		}
	}
	xhr.open("POST", "../function/getlike.php");
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("name="+name);
}

function getIdPic(name) {
	var xhr = getXHR(),
		pic = document.getElementById('id_pic');

	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			pic.setAttribute('value', xhr.responseText);
		}
	}
	xhr.open("POST", "../function/getIdPic.php");
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("name="+name);
}

function getApe(name) {
	var img = document.getElementById('imgApe'),
		user = document.getElementById('userName').getAttribute('value'),
		like = document.getElementById('like'),
		tocom = document.getElementById('tocomment'),
		xhr = getXHR(),
		onload = img.getAttribute('onload'),
		rand = Math.floor((Math.random() * 5) + 1);

	if (onload != '') {
		img.setAttribute('onload', '');
	}
	tocom.setAttribute('style', 'display:block;');
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			if (xhr.responseText === '1') {
				like.src = '../rsc/like.png';
			} else if (user == 'Unregister') {
				like.src = '../rsc/hidden.png';
			} else {
				like.src = '../rsc/liked'+rand+'.png';
			}
			img.src = "../"+name;
			getLike(name);
			getComment(name);
			getIdPic(name);
		}
	}
	xhr.open("POST", "../function/bislike.php");
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("name="+name+"&user="+user);
}

var like = document.getElementById('like');

like.addEventListener('click', function(){
	var xhr = getXHR(),
		usr = document.getElementById('userName').getAttribute('value'),
		to = document.getElementById('imgApe').src,
		tolen = to.indexOf('public'),
		but = document.getElementById('like'),
		val_like = but.src,
		len = val_like.indexOf('rsc');

	val_like = val_like.slice(len);
	to = to.slice(tolen);
	if (val_like == 'rsc/hidden.png') {
		alert('Connecte toi pour pouvoir liker les photo !');
	} else if (val_like == 'rsc/like.png') {
		xhr.onreadystatechange = function(){
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
					but.src = '../rsc/liked1.png';
					getLike(to);
			}
			else if (xhr.readyState < 4) {
				but.src = '../rsc/load1.gif';
			}
		}
		xhr.open("POST", "../function/like.php");
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("like=0&to="+to+"&usr="+usr);
	} else {
		xhr.onreadystatechange = function(){
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
					but.src = '../rsc/like.png';
					getLike(to);
			}
			else if (xhr.readyState < 4) {
					but.src = '../rsc/load1.gif';
			}
		}
		xhr.open("POST", "../function/like.php");
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("like=1&to="+to+"&usr="+usr);
	}
}, false);