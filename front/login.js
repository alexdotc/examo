document.getElementById("LoginForm").addEventListener("submit", login);

function login(e){

	e.preventDefault();
	
	const SERVER = 'frontEndCS490.php';

	let user = document.getElementById("user").value;
	let pass = document.getElementById("pass").value;
	
	let json = new Object();
	json.user = user;
	json.pass = pass;

	let post_params = JSON.stringify(json);
	
	let xhr = new XMLHttpRequest();
	xhr.open("POST", SERVER, true);
	xhr.setRequestHeader('Content-type', 'application/json');

	xhr.onload = function(){
		if (xhr.status == 200){
			// TODO: Parse response from mid
			let elem = document.getElementById("Resp");
			console.log(this.responseText);
			elem.innerHTML = this.responseText;
		}
	}

	xhr.send(post_params);

}
