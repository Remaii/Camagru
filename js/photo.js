function checker() {
	var inputs = document.querySelectorAll('input[type=radio]:checked'),
		inputsLength = inputs.length,
		img = document.getElementById('onVid'),//cadre superposer
		vid = document.getElementById('video'),//stream
		but = document.getElementById('click');//bouton snap
		wV = vid.offsetWidth,	//largeur de la video
		hV = vid.offsetHeight,	//hauteur de la video
		toV = vid.offsetTop,	//position Top de la video
		leV = vid.offsetLeft,	//position Left de la video
		toI = img.offsetTop,	//position Top de l'image a ajouter
		leI = img.offsetLeft,	//position Left de l'image
		wI = 0,					//largeur de l'image
		hI = 0,					//hauteur de l'image
		cibleh = 0,				// valeur calculer position de l'image Top
		ciblew = 0,				// valeur calculer position de l'image Left
		name = null,
		pos = 0;
	if (inputs[0] == null)
		return ;
	for (var i = 0; i < inputsLength; i++) {
		img.setAttribute('src', "rsc/"+inputs[i].value+".png");
		name = img.src;
		pos = name.indexOf('rsc');
		name = name.slice(pos);
		hI = img.offsetHeight;
		wI = img.offsetWidth;
		ciblew = ((wV - wI) / 2) + leV;
		cibleh = ((hV - hI) / 2) + toV;
		img.style.top = cibleh+"px";
		img.style.left = ciblew+"px";
	}
}
function getImg() {
	var fileIn = document.getElementById('toUpload').files[0],
		activ = document.getElementById('activ'),
		vide = document.getElementById('video'),
		read = new FileReader(),
		name = null,
		dbdot = 0,
		dot = 0;

	read.addEventListener('load', function(){
		name = read.result;
		dbdot = name.indexOf(':');
		dot = name.indexOf(';');
		name = name.slice(dbdot, dot);
		if (name == ':image/png') {
			var newImg = document.createElement('img');
			newImg.setAttribute('src', read.result);
			newImg.setAttribute('id', 'video');
			vide.parentNode.replaceChild(newImg, vide);
			activ.src = 'rsc/cross.png';
		}
		else {
			return (alert("Uniquement des image au format png !"));
		}
	});
	read.readAsDataURL(fileIn);
}
function camera() {
		var streaming = false,
		video = document.getElementById('video'),
		canvas = document.getElementById('canvas'),
		button = document.getElementById('click'),
		toAdd = document.getElementById('onVid'),
		data = null,
		width = video.offsetWidth,
		height = video.offsetHeight,
		constraint = { audio: false, video: true};

		navigator.mediaDevices.getUserMedia(constraint).then(function(stream) {
			if (navigator.mozGetUserMedia) {
				video.mozSrcObject = stream;
			}
			else {
				var vendorURL = window.URL || window.webkitURL;
				video.src = vendorURL ? vendorURL.createObjectURL(stream) : stream;
			}
				video.play();
		},
		function(err) {
			console.log("An error occured!" + err);
		}
	);
	video.addEventListener('canplay', function(ev){
		if (!streaming) {
			height = video.videoHeight / (video.videoWidth / width);
			video.setAttribute('width', width);
			video.setAttribute('height', height);
			canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);
			streaming = true;
		}
	}, false);

	if (streaming == false && video.src == null) {
		return 0;
	}
	else{
		return 1;
	}
}
function share(callback, nb) {
	var xhr = getXHR(),
		user = document.getElementById('userName').getAttribute('value'),
		imgToUp = nb;

	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			callback(xhr.responseText);
		}
	};
	xhr.open("POST", "function/save.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("data="+imgToUp+"&login="+user);
}
function read(oData) {
	var img = document.getElementById('imgret');

	img.removeAttribute('id');
	img.setAttribute('class', 'imgdone');
	img.src = oData;
}
function deleteIMG(path) {
	var xhr = getXHR();
	var inputs = document.getElementById('myMount').querySelectorAll('img'),
		len = inputs.length,
		div = null,
		pos = 0,
		r = null,
		name = null;

	if ((r = confirm('Vous etes sur le point de supprimer la photo')) == true) {
		for (var i = 0; i < len; i++) {
			name = inputs[i].src;
			pos = name.indexOf('public');
			name = name.slice(pos);
			if (name == path)
			{
				div = inputs[i].parentNode;
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 4) {
						if (xhr.responseText == 'OK') {
							div.parentNode.removeChild(div);
							i = len;
						}
					}
				}
				xhr.open("POST", "function/delete.php", true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("path="+name);
			}
		}
	}
}
function snap() {
	var cnv = document.createElement('canvas'),//document.getElementById('canvas'),
		add = document.getElementById('onVid'),
		video = document.getElementById('video'),
		mount = document.getElementById('mount'),
		button = document.getElementById('click'),
		cnv2 = document.createElement('canvas'),
		div = document.createElement('div'),
		ret = document.createElement('img'),
		xhr = getXHR(),
		onV = null,
		Vid = null,
		user = document.getElementById('userName').getAttribute('value');

	cnv2.width = add.offsetWidth;
	cnv2.height = add.offsetHeight;
	cnv2.getContext('2d').drawImage(add, 0, 0, add.offsetWidth, add.offsetHeight);
	cnv.width = video.offsetWidth;
	cnv.height = video.offsetHeight;
	cnv.getContext('2d').drawImage(video, 0, 0, video.offsetWidth, video.offsetHeight);
	onV = cnv2.toDataURL();
	Vid = cnv.toDataURL();
	onV = encodeURIComponent(onV);
	Vid = encodeURIComponent(Vid);
	xhr.onreadystatechange = function() {
		if (xhr.readyState <= 3) {
			button.src = 'rsc/load1.gif';
		}
		else if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			ret.setAttribute('id', 'imgret');
			ret.src = xhr.responseText;
			div.appendChild(ret);
			div.setAttribute('onclick', "deleteIMG('"+xhr.responseText+"')");
			mount.after(div);
			share(read, xhr.responseText);
			cnv.src = null;
			button.src = 'rsc/app.png';
		}
	};
	xhr.open("POST", "function/addimg.php");
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("canvas="+Vid+"&toadd="+onV+"&user="+user);
}

var click = document.getElementById('click'),
	plus = document.getElementById('plus'),
	moin = document.getElementById('moin'),	
	activ = document.getElementById('activ');

activ.addEventListener('click', function(ev) {
	var nameActiv = activ.src,
		posActiv = nameActiv.indexOf('rsc'),
		change = null,
		onV = document.getElementById('onVid'),
		view = document.getElementById('video');

	nameActiv = nameActiv.slice(posActiv);
	if (nameActiv != 'rsc/cross.png') {
		if (view.tagName != 'VIDEO') {
			change = document.createElement('video');
			change.setAttribute('id', 'video');
			view.parentNode.replaceChild(change, view);
		}
		camera();
		activ.src = 'rsc/cross.png';
	}
	else {
		if (view.tagName == 'VIDEO') {
			view.pause();
			view.src = null;
		}
		else if (view.tagName == 'IMG') {
			view.src = 'rsc/hidden.png';
		}
		onV.src = 'rsc/hidden.png';
		activ.src = "rsc/cam.png";
	}
},false);

click.addEventListener('click', function(ev) {
	var activ = document.getElementById('activ'),
		view = document.getElementById('video'),
		imgUp = document.getElementById('onVid'),
		nmCl = click.src,
		posCl = nmCl.indexOf('rsc'),
		nmAc = activ.src,
		posAc = nmAc.indexOf('rsc'),
		nmIm = imgUp.src,
		posIm = nmIm.indexOf('rsc');

	nmAc = nmAc.slice(posAc);
	nmIm = nmIm.slice(posIm);
	nmCl = nmCl.slice(posCl);
	if (nmAc == 'rsc/cross.png'){// || nmAc == 'rsc/cam.png') {
		if (nmIm != 'rsc/hidden.png' && nmCl != 'rsc/load1.gif') {
			snap();
			ev.preventDefault();
		}
		else {
			alert('Selectionne un filtre');
		}
	}
	else {
		alert('Active la Camera ou upload une image');
	}
},false);

moin.addEventListener('click', function(ev){
	var imgUp = document.getElementById('onVid'),
		img_h = imgUp.offsetHeight,
		img_w = imgUp.offsetWidth;

	if (img_w > 50 || img_h > 50) {
		img_w -= 10;
		img_h -= 10;
		imgUp.style.width = img_w;
		imgUp.style.height = img_h;
	}
	checker();
},false);

plus.addEventListener('click',function(ev){
	var vid = document.getElementById('video'),
		imgUp = document.getElementById('onVid'),
		vid_w = vid.offsetWidth,
		vid_h = vid.offsetHeight,
		img_h = imgUp.offsetHeight,
		img_w = imgUp.offsetWidth;

	if (img_w < vid_w && img_h < vid_h) {
		img_w += 10;
		img_h += 10;
		imgUp.style.width = img_w;
		imgUp.style.height = img_h;
	}
	checker();
},false);

window.addEventListener('resize',function(ev) {
	checker();
},false);