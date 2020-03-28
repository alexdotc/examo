document.getElementById("QuestionForm").addEventListener("submit", ajaxSubmit);

function ajaxSubmit(e){
	
	e.preventDefault();

	const SERVER = 'ajaxHandler.php';

	let difficulty = document.getElementById("difficulty").value;
	let topic = document.getElementById("topic").value;
	let fname = document.getElementById("fname").value;
	let fargs = document.getElementById("fargs").value;
	let fbody = document.getElementById("fbody").value;
	let fotype = document.getElementById("fotype").value;
	let foutput = document.getElementById("foutput").value;

	let vquestion = "Write a function named " + fname + ". Given " + fargs + ", the function should " + fbody + " and " + fotype + " " + foutput + ".";

	let tcin = document.getElementsByName("TestIn");
	let tcout = document.getElementsByName("TestOut");

	let tcs = "";

	for (let tc = 0; tc < tcin.length; ++tc){

		if (tc != 0)
			tcs += "?";

		i = tcin[tc].value;
		o = tcout[tc].value;

		tcf = fname + "(" + i + "):" + o;

		tcs += tcf;
	}
 
        let post_params = "RequestType=CreateQuestion" + "&topic=" + topic + "&difficulty=" + difficulty + "&questiontext=" + vquestion + "&testcases=" + tcs;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", SERVER, true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.onload = function(){
        	if (xhr.status == 200){
            		let elem = document.getElementById("response");

			if (this.responseText == "There was an error saving your question"){
				elem.innerHTML = "Error saving question...";
				return;
			}

			resp = JSON.parse(this.responseText);
			
			if (resp.startsWith("Question successfully saved with id"))
				elem.innerHTML = "Question successfully saved";
			else
				elem.innerHTML = resp;
		}
        }

	xhr.send(post_params);
}

