document.getElementById("QuestionForm").addEventListener("submit", ajaxSubmit);

document.getElementById("tc").addEventListener("click", function(e){
	if (e.target.id != "tcRemove")
		return;
	if (e.target.childNodes[3] == undefined){
		clickedButton = e.target;
		removeTC(clickedButton.parentNode);
	}
});

document.getElementById("tcAdd").addEventListener("click", function(e){
	const tcdiv = document.getElementById("tc");

	let ntc = document.createElement("div");
	let nti = document.createElement("input");
	let nto = document.createElement("input");
	let ntx = document.createElement("input");

	ntc.setAttribute('id', 'testcase');
	ntc.setAttribute('class', 'QuestionItems QuestionTestCases');

	nti.setAttribute('id', 'testinput');
	nti.setAttribute('class', 'QuestionItems QuestionInput');
	nti.setAttribute('placeholder', 'inputs');
	nti.setAttribute('name', 'TestIn');
	
	nto.setAttribute('id', 'testoutput');
	nto.setAttribute('class', 'QuestionItems QuestionInput');
	nto.setAttribute('placeholder', 'Expected Output');
	nto.setAttribute('name', 'TestOut');

	ntx.setAttribute('id', 'tcRemove');
	ntx.setAttribute('type', 'button');
	ntx.setAttribute('class', 'QuestionItems QuestionButton');
	ntx.setAttribute('value', 'Remove');

	ntc.appendChild(nti);
	ntc.appendChild(nto);
	ntc.appendChild(ntx);
	ntc.innerHTML += "<br />";

	tcdiv.appendChild(ntc);
});

function removeTC(cb){
	cb.parentNode.removeChild(cb);
}
	

function ajaxSubmit(e){
	
	e.preventDefault();

	const SERVER = 'ajaxHandler.php';

	let difficulty = document.getElementById("difficulty").value;
	let topic = document.getElementById("topic").value;
	let fname = document.getElementById("fname").value;
	let qbody = document.getElementById("qbody").value;

	let vquestion = qbody;

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

