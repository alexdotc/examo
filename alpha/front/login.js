document.getElementById("LoginForm").addEventListener("submit", login);

function login(e){

	e.preventDefault();
	
	const SERVER = 'frontEndCS490.php';

	let ucid = document.getElementById("ucid").value;
	let password = document.getElementById("pass").value;
	
	let post_params = "ucid=" + ucid + "&password=" + password;
	
	let xhr = new XMLHttpRequest();
	xhr.open("POST", SERVER, true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	xhr.onload = function(){
		if (xhr.status == 200){
			let elem = document.getElementById("response");
			let resp = JSON.parse(this.responseText);

			if (resp.respNJIT == 'NJITyes')
				resp.respNJIT = 'YES';
			else if (resp.respNJIT == 'NJITno')
				resp.respNJIT = 'NO';

			if (resp.resp == 'backYes')
				resp.resp = 'YES';
			else if (resp.resp == 'backNo')
				resp.resp = 'NO';

			elem.innerHTML = `Back says ${resp.resp} and NJIT says ${resp.respNJIT}`;
			console.log(this.responseText);
		}
	}

	xhr.send(post_params);

}
