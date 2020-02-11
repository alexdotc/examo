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
			// TODO: Parse response from mid
			let elem = document.getElementById("response");
			let resp = JSON.parse(this.responseText);
			elem.innerHTML = `Back says ${resp.resp} and NJIT says`
			console.log(this.responseText);
		}
	}

	xhr.send(post_params);

}
