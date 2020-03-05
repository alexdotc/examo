ajaxShowGraded(getParam(window.location.href, 'exam'), renderExam);

document.getElementById("GradeDiv").addEventListener("click", function(e){

	let clickedButton = document.getElementById(e.target.id);

	if (clickedButton && clickedButton.id == 'releaseButton')
		releaseExam(clickedButton);

	else if (clickedButton && clickedButton.id == 'withdrawButton')
		withdrawExam(clickedButton);
});

document.getElementById("GradeForm").addEventListener("submit", ajaxUpdateExam);


function getParam(currentURL, param){
	
	let sp = param + "=";
	let pInd = currentURL.search(sp);
	let eInd = currentURL.indexOf('?', pInd);

	if (eInd == -1)
		eInd = currentURL.length;

	let param_val = currentURL.substring(pInd + sp.length, eInd);
	
	return param_val;
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
		li.innerHTML += '<strong>Question ' + friendlyctr + '</strong><br /><br />';
		li.innerHTML += '<strong>' + questions[question]['scores'] + ' out of ' + questions[question]['maxScores'] + ' Points</strong><br /><br />';
		li.innerHTML += questions[question]['questions'];
		li.innerHTML += "<br /><br /><strong>Student's Answer:</strong><br />" + questions[question]['answers'] + '<br /><br />';
		li.innerHTML += '<strong>Test Case Results: </strong><br /><br />';

		for(let tc = 0; tc < deductions.length; ++tc){
			
			let change = document.createElement("input");

			li.innerHTML += "Expected Answer: " + expected[tc];
			li.innerHTML += " Resulting Answer: " + actual[tc];
			li.innerHTML += " Deducted Points: " + deductions[tc] + '<br />';
			//li.innerHTML += '<strong> Modify Deduction: </strong>';
			
			change.setAttribute('type', 'text');
			change.setAttribute('class', 'GradeItems GradeChange');
			change.setAttribute('name', 'tcD' + tc);
			change.setAttribute('id', 'tcD' + tc + 'q' + questions[question]['questID']);
			change.setAttribute('placeholder', 'points');
			
			//li.appendChild(change);
		}
		
		if (questions[question]['deductedPointscorrectName'] != 0){

			li.innerHTML += 'Deducted ' + questions[question]['deductedPointscorrectName'] + ' for incorrect function name<br />';
		}
			let change = document.createElement("input");
			change.setAttribute('type', 'text');
			change.setAttribute('name', 'NameD');
			change.setAttribute('class', 'GradeItems GradeChange');
			change.setAttribute('id', 'NameD' + questions[question]['gradesID']);
			change.setAttribute('placeholder', questions[question]['scores']);
			li.innerHTML += '<br /><strong> Modify Question Score: </strong>';
			li.appendChild(change);

		divExam.appendChild(li);

		divExam.innerHTML += '<hr />';

		++friendlyctr;
	}

	let button = document.createElement("input");
	
	button.setAttribute('type', 'button');
	button.setAttribute('class', 'GradeItems GradeReleaseButton');
	button.setAttribute('name', 'ExamReleaseButton');
	
	if (released == 'Y'){
		button.setAttribute('id', 'withdrawButton');
		button.setAttribute('value', 'Withdraw Exam');
	}
	else if (released == 'N'){
		button.setAttribute('id', 'releaseButton');
		button.setAttribute('value', 'Release Exam');
	}

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

	let examname = getParam(window.location.href, 'exam');
	let user = getParam(window.location.href, 'user');
	let allmods = document.getElementsByName("NameD");
	let rb = (document.getElementsByName("ExamReleaseButton"))[0];
	let released;

	if (rb && rb['id'] == 'releaseButton')
		released = 'N';
	else if (rb && rb['id'] == 'withdrawButton')
		released = 'Y';

	let ids = [];
	let scores = [];
	let comments = ['c1','c2']; // placeholder

	for(let mod in allmods){

		if (allmods[mod]['type'] != 'text')
			continue;

		let score = allmods[mod]['value'];
		let id = allmods[mod]['id'].substr(5);

		ids.push(id);

		if (score == '')
			score = allmods[mod]['placeholder'];
		
		scores.push(score);
	}

	let post_params = 'RequestType=modifyGradedExam&examname=' + examname + '&user=' + user + '&ids=' + ids + '&scores=' + scores + '&comments=' + comments + '&released=' + released;

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
