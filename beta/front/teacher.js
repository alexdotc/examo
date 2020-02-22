hashevent();

window.addEventListener("hashchange", hashevent);

function hashevent(){

	console.log(location.hash);
	let hash = (location.hash).substr(1);
	let hashes = { home: 'teacherHome.php',
		       question: 'teacherQuestion.php',
		       exam: 'teacherExam.php' };

	if(!hash)
		hash = 'home';
	
	hash = hashes[hash];

	ajaxGet(hash, morph);
}

function ajaxGet(page, callback){

	let resp;
	let xhr = new XMLHttpRequest();

	xhr.open("GET", page, true);

	xhr.onload = function(){
		if(xhr.status == 200){
			resp = this.responseText;
			callback(resp);
		}
	}

	xhr.send(null);
}

function morph(content){
	const divMain = document.getElementById("main");

	divMain.innerHTML = content;
}
