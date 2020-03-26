ajaxShowGraded(getParam(window.location.href, 'exam'), renderExam);

window.onscroll = function() { return; }; // remove any scroll event handler

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

	let post_params = 'RequestType=showGradedExam&examname=' + ename + '&user=' + getParam(window.location.href, 'user');

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

	divName.innerHTML = "Currently viewing grades for " + decodeURI(ename) + " taken by " + questions[0]['ucid'];

	let friendlyctr = 1;
	for (let question in questions){

		let li = document.createElement("div");
		let expected = (questions[question]['expectedAnswers']).split("HACKMAGICK");
		let actual = (questions[question]['resultingAnswers']).split("HACKMAGICK");
		let deductions = (questions[question]['deductedPointsPerEachTest']).split(",");

                for(let d in deductions)
                        deductions[d] = deductions[d].trim();

		li.setAttribute('class', 'GradeItems GradeQuestions');
		li.setAttribute('id', 'examquestion' + questions[question]['gradesID'] + 'mscore' + questions[question]['maxScores']);

		li.innerHTML += '<strong>Question ' + friendlyctr + '</strong><br /><br />';
		li.innerHTML += '<strong>' + questions[question]['scores'] + ' out of ' + questions[question]['maxScores'] + ' Points</strong><br /><br />';
		li.innerHTML += questions[question]['questions'];
		li.innerHTML += "<br /><br /><strong>Student's Answer:</strong><br /><br /><pre>" + questions[question]['answers'] + '</pre><br /><br />';
		li.innerHTML += '<strong>Test Case Results: </strong><br /><br />';

		for(let tc = 0; tc < deductions.length; ++tc){
			
			let change = document.createElement("input");

			li.innerHTML += '<strong><em>Test Case ' + String(tc + 1) + '</em></strong><br />';
			li.innerHTML += "Expected Answer: " + expected[tc] + '<br />';
			li.innerHTML += " Resulting Answer: " + actual[tc] + '<br />';
			li.innerHTML += " <strong>Deducted Points </strong>";
			
			change.setAttribute('type', 'text');
			change.setAttribute('class', 'GradeItems GradeChange');
			change.setAttribute('name', 'tcD' + tc);
			change.setAttribute('id', 'tcD' + tc + 'q' + questions[question]['gradesID']);
			change.setAttribute('placeholder', 'points');
			change.setAttribute('value', deductions[tc]);
			
			li.appendChild(change);

			li.innerHTML += "<br /><br />";
		}

		li.innerHTML += "<strong>Function Name:</strong><br /><br />";
		li.innerHTML += "<strong>Deducted Points </strong>";
		
		let change = document.createElement("input");
		change.setAttribute('type', 'text');
		change.setAttribute('name', 'NameD');
		change.setAttribute('class', 'GradeItems GradeChange');
		change.setAttribute('id', 'NameD' + questions[question]['gradesID']);
		change.setAttribute('placeholder', 'Score');
		change.setAttribute('value', questions[question]['deductedPointscorrectName']);
		li.appendChild(change);

		let comment = document.createElement("textarea");
		comment.setAttribute('wrap', 'soft');
		comment.setAttribute('cols', '100');
		comment.setAttribute('rows', '6');
		comment.setAttribute('name', 'Comment');
		comment.setAttribute('class', 'GradeItems GradeComment');
		comment.setAttribute('id', 'comment');
		comment.setAttribute('placeholder', 'Leave a comment for the student');
		comment.innerHTML = questions[question]['comments'];
		li.innerHTML += '<br /><br /><strong>Leave Comment:</strong><br />';
		li.appendChild(comment);

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
	let allcomments = document.getElementsByName("Comment");
	let rb = (document.getElementsByName("ExamReleaseButton"))[0];
	let released;

	if (rb && rb['id'] == 'releaseButton')
		released = 'N';
	else if (rb && rb['id'] == 'withdrawButton')
		released = 'Y';

	let ids = [];
	let nameDs = [];
	let comments = [];
	let tcDs = [];
	let scores = [];

	for(let mod in allmods){

		if (allmods[mod]['type'] != 'text')
			continue;

		let nameD = allmods[mod]['value'];
		let tcDq = [];
		let id = allmods[mod]['id'].substr(5);
		let qdiv = document.getElementById(document.querySelector('[id^="examquestion' + id + '"').id);

		let qdc = qdiv.childNodes;
		let mscore = qdiv['id'].substr(qdiv['id'].search("mscore") + 6);
		let tcDsum = 0;
		
		for(let q in qdc){
			if (qdc[q]['type'] != 'text')
				continue;
			if (qdc[q]['id'].startsWith("tc")){
				if (qdc[q]['value'] == '')
					qdc[q]['value'] = '0';
				tcDq.push(qdc[q]['value']);
				tcDsum += parseInt(qdc[q]['value']);
			}
		}

		
		ids.push(id);
		tcDs.push(tcDq.join("..."));

		if (nameD == '')
			nameD = '0';

		nameDs.push(nameD);

		scores.push(String(parseInt(mscore) - parseInt(nameD) - tcDsum));
	}

	for(let comment in allcomments){

		if (allcomments[comment]['type'] != 'textarea')
			continue;

		comments.push(allcomments[comment]['value']);
	}

	console.log(tcDs);

	let post_params = 'RequestType=modifyGradedExam&examname=' + examname + '&user=' + user + '&ids=' + ids + '&scores=' + scores + '&comments=' + comments + '&released=' + released + '&tcDs=' + tcDs + '&nameDs=' + nameDs;

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
