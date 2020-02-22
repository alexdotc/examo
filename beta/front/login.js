document.getElementById("LoginForm").addEventListener("submit", login);

function login(e){

	e.preventDefault();
	
	const SERVER = 'frontEndCS490.php';
	const STUDENT_PAGE = 'student.php';
	const TEACHER_PAGE = 'teacher.php';

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

			if(resp.resp == 'backYes')
				window.location.replace(TEACHER_PAGE);
			
			// TODO: Replace with real check for student page, testing backdoor for now
			else if (resp.respNJIT == 'NJITyes')
				window.location.replace(STUDENT_PAGE);

			else
				elem.innerHTML = "Login Failed...";

			console.log(this.responseText);
		}
	}

	xhr.send(post_params);

}
