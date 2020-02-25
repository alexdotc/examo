document.getElementById("QuestionForm").addEventListener("submit", ajaxSubmit);

function ajaxSubmit(e){
	
	e.preventDefault();

	const SERVER = 'ajaxHandler.php';

	let difficulty = document.getElementById("difficulty").value;
	let topic = document.getElementById("topic").value;
	let vquestion = document.getElementById("VQuestion").value;
        let tc1 = document.getElementById("testcase1").value;
        let tc2 = document.getElementById("testcase2").value;

        let tcs = [tc1,tc2];
 
        let post_params = "RequestType=CreateQuestion" + "&Topic=" + topic + "&Difficulty=" + difficulty + "&QuestionText=" + vquestion + "&TestCases=" + tcs;

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
