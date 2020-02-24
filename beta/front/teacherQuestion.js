document.getElementById("QuestionForm").addEventListener("submit", ajaxSubmit);

function ajaxSubmit(e){
	
	e.preventDefault();

	const SERVER = 'ajaxHandler.php';

	let difficulty = document.getElementById("difficulty").value;
	let topic = document.getElementById("topic").value;
	let vquestion = document.getElementById("VQuestion").value;
 
        let post_params = "RequestType=CreateQuestion" + "&Topic=" + topic + "&Difficulty=" + difficulty + "&QuestionText=" + vquestion;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", SERVER, true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.onload = function(){
        	if (xhr.status == 200){
            		let resp = JSON.parse(this.responseText);
            		acknowledge(resp);
		}
        }

	xhr.send(post_params);
}

function acknowledge(question){
	console.log(`Question Submitted: {question}`);
}
