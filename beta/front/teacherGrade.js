document.getElementById("GradeForm").addEventListener("submit", ajaxUpdateGrades);

ajaxShowGraded(getExamNameParam(window.location.href), renderExam);

function getExamNameParam(currentURL){
	
	let sp = "exam=";
	let pInd = currentURL.search(sp);
	let exam = currentURL.substr(pInd + sp.length);
	
	return exam;
}

function ajaxShowGraded(ename, callback){
	
	const SERVER = 'ajaxHandler.php';

	let post_params = 'RequestType=showGradedExam&examname=' + ename;

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

function renderExam(ename, questions){
	const divExam = document.getElementById("GradeDiv");
	const divName = document.getElementById("examName");

	divName.innerHTML = "Currently viewing grades for " + ename + " taken by " + questions[0]['ucid'];

	let friendlyctr = 1;
	for (let question in questions){
		let li = document.createElement("div");
		let expected = (questions[question]['expectedAnswers']).split(",");
		let actual = (questions[question]['resultingAnswers']).split(",");
		let deductions = (questions[question]['deductedPointsPerEachTest']).split(",");

		li.setAttribute('class', 'TakeItems TakeQuestions');
		li.setAttribute('id', 'examquestion');
		li.innerHTML += '<strong>Question ' + friendlyctr + '</strong><br />';
		li.innerHTML += '<strong>' + questions[question]['scores'] + 'out of ' + questions[question]['maxScores'] + 'Points</strong><br /><br />';
		li.innerHTML += questions[question]['questions'];
		li.innerHTML += "<br />Student's Answer:<br />" + questions[question]['answers'] + '<br />';
		li.innerHTML += 'Test case results: <br />';

		for(let tc = 0; tc < deductions.length; ++tc){
			li.innerHTML += "Expected Answer: " + expected[tc];
			li.innerHTML += " Resulting Answer: " + actual[tc];
			li.innerHTML += " Deducted Points: " + deductions[tc] + '<br />';
		}
		
		if (questions[question]['deductedPointscorrectName'] != '0')
			li.innerHTML += 'Deducted ' + questions[question]['deductedPointscorrectName'] + ' for incorrect function name<br />';

		divExam.appendChild(li);

		divExam.innerHTML += '<hr />';

		++friendlyctr;
	}
}

function ajaxUpdateGrades(e){
	
	e.preventDefault();

	const SERVER = 'ajaxHandler.php';

	let examname = getExamNameParam(window.location.href);
	let allanswers = document.getElementsByClassName("TakeAnswer");

	let ids = [];
	let answers = [];

	for(let answer in allanswers){
		if(allanswers[answer]['type'] != 'textarea')
			continue;
		console.log(allanswers[answer]);
		ids.push(allanswers[answer]['id'].substr(10));
		answers.push(allanswers[answer]['value']);
	}

	let post_params = 'RequestType=submitExam&examname=' + examname + '&ids=' + ids + '&answers=' + answers;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", SERVER, true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	xhr.onload = function(){
		if (xhr.status == 200){
			let elem = document.getElementById("response");
			let resp = JSON.parse(this.responseText);

			elem.innerHTML = resp;
		}
	}

	xhr.send(post_params);
}
