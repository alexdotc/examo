ajaxShowExam(getExamNameParam(window.location.href), renderExam);

function getExamNameParam(currentURL){
	
	let sp = "exam=";
	let pInd = currentURL.search(sp);
	let exam = currentURL.substr(pInd + sp.length);
	
	return exam;
}

function ajaxShowExam(ename, callback){
	
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
	const divExam = document.getElementById('ViewDiv');
	const divName = document.getElementById('examName');
	const released = questions.pop();

	divName.innerHTML = "Currently viewing " + decodeURI(ename);

	let friendlyctr = 1;
	for (let question in questions){
		let li = document.createElement("div");
		let deductions = (questions[question]['deductedPointsPerEachTest']).split(",");

		li.setAttribute('class', 'ViewItems ViewQuestions');
		li.setAttribute('id', 'examquestion');
		li.innerHTML += '<strong>Question ' + friendlyctr + '</strong><br />';
		li.innerHTML += '<strong>Score: ' + questions[question]['scores'] + ' out of ' + questions[question]['maxScores'] + ' Points</strong><br /><br />';
		li.innerHTML += questions[question]['questions'];

		li.innerHTML += '<br /><br /><strong>Your Answer:</strong><br />';
		li.innerHTML += '<pre>' + questions[question]['answers'] + '</pre><br />';
		
		if (questions[question]['deductedPointscorrectName'] != 0)
			li.innerHTML += '<br /><strong>Deducted ' + questions[question]['deductedPointscorrectName'] + ' for incorrect function name</strong>';

		let passed = 0;
		for (let tc = 0; tc < deductions.length; ++tc)
			if (deductions[tc] == 0)
				++passed;
		
		li.innerHTML += '<br /><br /><strong>Passed ' + passed + ' out of ' + deductions.length + ' test cases</strong><br />';

		for (let tc = 0; tc < deductions.length; ++tc)
			if (deductions[tc].trim() != '0')
				li.innerHTML += '<strong>Deducted ' + deductions[tc] + ' for test case ' + (tc + 1) + '<br />';

		if (questions[question]['comments'] != ''){
			li.innerHTML += '<br /><strong>Instructor Comments:</srong><br />';
			li.innerHTML += questions[question]['comments'];
		}
		
		divExam.appendChild(li);

		divExam.innerHTML += '<hr />';

		++friendlyctr;
	}
}

