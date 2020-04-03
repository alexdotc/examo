document.getElementById("TakeForm").addEventListener("submit", ajaxSubmitExam);

ajaxShowExam(getExamNameParam(window.location.href), renderExam);

document.getElementById("TakeDiv").addEventListener("keydown", function(e){

	if(e.keyCode === 9){

	        let myta = document.getElementById(e.target.id);

        	if (myta && myta.id.startsWith("answerText"))
                	tabOverride(myta);
		
		e.preventDefault();
	}
});

function tabOverride(textArea){

	let start = textArea.selectionStart;
	let end = textArea.selectionEnd;
	let target = textArea;
	let value = textArea.value;

	target.value = value.substring(0, start) + "\t" + value.substring(end);

	textArea.selectionStart = textArea.selectionEnd = start + 1;
}

function getExamNameParam(currentURL){
	
	let sp = "exam=";
	let pInd = currentURL.search(sp);
	let exam = currentURL.substr(pInd + sp.length);
	
	return exam;
}

function ajaxShowExam(ename, callback){
	
	const SERVER = 'ajaxHandler.php';

	let post_params = 'RequestType=showExam&examname=' + ename;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", SERVER, true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	xhr.onload = function(){
		if (xhr.status == 200){
			let resp = JSON.parse(this.responseText);

			renderExam(ename, resp);
		}
	}

	xhr.send(post_params);

}

qpoints = [];

function renderExam(ename, questions){
	const divExam = document.getElementById("TakeDiv");
	const divName = document.getElementById("examName");

	divName.innerHTML = "Currently taking " + decodeURI(ename);

	let friendlyctr = 1;
	for (let question in questions){

		qpoints[friendlyctr-1] = questions[question]['points'];

		let li = document.createElement("div");
		let answer = document.createElement("textarea");

		li.setAttribute('class', 'TakeItems TakeQuestions');
		li.setAttribute('id', 'examquestion');
		li.innerHTML += '<strong>Question ' + friendlyctr + '</strong><br />';
		li.innerHTML += '<strong>' + questions[question]['points'] + ' Points</strong><br /><br />';
		li.innerHTML += questions[question]['questiontext'];

		answer.setAttribute('id', 'answerText' + questions[question]['questionID']);
		answer.setAttribute('class', 'TakeItems TakeAnswer');
		answer.setAttribute('cols', '100');
		answer.setAttribute('rows', '8');
		answer.setAttribute('wrap', 'soft');
		answer.setAttribute('placeholder', "Enter answer for question " + friendlyctr + " here");
		
		divExam.appendChild(li);
		divExam.appendChild(answer);

		divExam.innerHTML += '<hr />';

		++friendlyctr;
	}
}

function ajaxSubmitExam(e){
	
	e.preventDefault();

        let elem = document.getElementById("response");

        elem.innerHTML = "Submitting..."

	const SERVER = 'ajaxHandler.php';

	let examname = getExamNameParam(window.location.href);
	let allanswers = document.getElementsByClassName("TakeAnswer");

	let ids = [];
	let answers = "";

	for(let answer in allanswers){
		if(allanswers[answer]['type'] != 'textarea')
			continue;

		ids.push(allanswers[answer]['id'].substr(10));
		answers += (encodeURIComponent(allanswers[answer]['value']) + "HACKMAGICK"); //shitty hack for now
	}

	let post_params = 'RequestType=submitExam&examname=' + examname + '&ids=' + ids + '&answers=' + answers + '&points=' + qpoints;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", SERVER, true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	xhr.onload = function(){
		if (xhr.status == 200){
			let resp = this.responseText;
			try{
				resp = JSON.parse(resp);
			}
			catch{ }

			if(resp.search("grade successfully saved") != -1)
				elem.innerHTML = "Exam successfully submitted!";
			else
				elem.innerHTML = "Something went wrong while submitting your exam...";
		}
	}

	xhr.send(post_params);
}
