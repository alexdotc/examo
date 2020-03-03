ajaxShowGraded(getExamNameParam(window.location.href), renderExam);

document.getElementById("GradeDiv").addEventListener("click", function(e){

	let clickedButton = document.getElementById(e.target.id);

	if (clickedButton && clickedButton.id == 'releaseButton')
		releaseExam(clickedButton);

	else if (clickedButton && clickedButton.id == 'withdrawButton')
		withdrawExam(clickedButton);
});

document.getElementById("GradeForm").addEventListener("submit", ajaxUpdateExam);


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
	const released = questions.pop();

	divName.innerHTML = "Currently viewing grades for " + ename + " taken by " + questions[0]['ucid'];

	let friendlyctr = 1;
	for (let question in questions){

		let li = document.createElement("div");
		let expected = (questions[question]['expectedAnswers']).split(",");
		let actual = (questions[question]['resultingAnswers']).split(",");
		let deductions = (questions[question]['deductedPointsPerEachTest']).split(",");

		li.setAttribute('class', 'GradeItems GradeQuestions');
		li.setAttribute('id', 'examquestion');
		li.innerHTML += '<strong>Question ' + friendlyctr + '</strong><br />';
		li.innerHTML += '<strong>' + questions[question]['scores'] + ' out of ' + questions[question]['maxScores'] + ' Points</strong><br /><br />';
		li.innerHTML += questions[question]['questions'];
		li.innerHTML += "<br />Student's Answer:<br />" + questions[question]['answers'] + '<br />';
		li.innerHTML += 'Test case results: <br /><br />';

		for(let tc = 0; tc < deductions.length; ++tc){
			
			let change = document.createElement("input");

			li.innerHTML += "Expected Answer: " + expected[tc];
			li.innerHTML += " Resulting Answer: " + actual[tc];
			li.innerHTML += " Deducted Points: " + deductions[tc] + '<br />';
			li.innerHTML += '<strong> Modify Deduction: </strong>';
			
			change.setAttribute('type', 'text');
			change.setAttribute('class', 'GradeItems GradeChange');
			change.setAttribute('name', 'tcD' + tc);
			change.setAttribute('id', 'tcD' + tc + 'q' + questions[question]['questID']);
			change.setAttribute('placeholder', 'points');
			
			li.appendChild(change);
			li.innerHTML += '<br /><br />';
		}
		
		if (questions[question]['deductedPointscorrectName'] != '0'){

			li.innerHTML += 'Deducted ' + questions[question]['deductedPointscorrectName'] + ' for incorrect function name<br />';
			let change = document.createElement("input");
			change.setAttribute('type', 'text');
			change.setAttribute('name', 'NameD');
			change.setAttribute('class', 'GradeItems GradeChange');
			change.setAttribute('id', 'NameD' + questions[question]['questID']);
			change.setAttribute('placeholder', 'points');
			li.innerHTML += '<strong> Modify Deduction: </strong>';
			li.appendChild(change);
		}

		divExam.appendChild(li);

		divExam.innerHTML += '<hr />';

		++friendlyctr;
	}

	let button = document.createElement("input");
	
	button.setAttribute('type', 'button');
	button.setAttribute('class', 'GradeItems GradeReleaseButton');
	button.setAttribute('id', 'releaseButton');
	button.setAttribute('name', 'ExamReleaseButton');
	button.setAttribute('value', 'Release Exam');

	divExam.appendChild(button);
}

function releaseExam(clickedButton){

	clickedButton.setAttribute('value', 'Withdraw Exam');
	clickedButton.setAttribute('id', 'withdrawButton');
}

function withdrawExam(clickedButton){

	clickedButton.setAttribute('value', 'Release Exam');
	clickedButton.setAttribute('id', 'releaseButton');
}

function ajaxUpdateExam(e){
	
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
