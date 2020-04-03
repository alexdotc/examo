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
		li.innerHTML += "<br /><br /><strong>Student's Answer:</strong><br /><br /><pre>" + questions[question]['answers'] + '</pre><br />';
		li.innerHTML += '<strong>Results: </strong><br /><br />';

		let gtable = document.createElement("table");

		gtable.setAttribute('id', 'gtable' + questions[question]['gradesID']);
		gtable.setAttribute('class', 'GradeItems GradeTable');
		
		let gti = document.createElement("tr");
		gti.innerHTML = "<td><strong>Grader Item</strong></td><td><strong>Expected Answer</strong></td><td><strong>Actual Answer</td><td><strong>Deducted Points</strong></td>"
		gtable.appendChild(gti);

		let gtr_fname = document.createElement("tr");
		gtr_fname.setAttribute('id', 'gtrfname');
		gtr_fname.setAttribute('class', 'GradeItems GradeTR');

		let gtd1_fname = document.createElement("td");
		gtd1_fname.setAttribute('id', 'gtd1fname');
		gtd1_fname.setAttribute('class', 'GradeItems GradeTD');
		gtd1_fname.innerHTML = "<strong><em>Function Name</em></strong>";

		let gtd2_fname = document.createElement("td");
		gtd2_fname.setAttribute('id', 'gtd2fname');
		gtd2_fname.setAttribute('class', 'GradeItems GradeTD');
		gtd2_fname.innerHTML = "<em>(see question)</em>";

		let gtd3_fname = document.createElement("td");
		gtd3_fname.setAttribute('id', 'gtd3fname');
		gtd3_fname.setAttribute('class', 'GradeItems GradeTD');
		gtd3_fname.innerHTML = "<em>(see answer)</em>";

		let gtd4_fname = document.createElement("td");
		gtd4_fname.setAttribute('id', 'gtd4fname');
		gtd4_fname.setAttribute('class', 'GradeItems GradeTD');
		
		let change_fname = document.createElement("input");
		change_fname.setAttribute('type', 'text');
		change_fname.setAttribute('name', 'NameD');
		change_fname.setAttribute('class', 'GradeItems GradeChange');
		change_fname.setAttribute('id', 'NameD' + questions[question]['gradesID']);
		change_fname.setAttribute('placeholder', 'Deduction');
		change_fname.setAttribute('value', questions[question]['deductedPointscorrectName']);

		gtd4_fname.appendChild(change_fname);
		gtr_fname.appendChild(gtd1_fname);
		gtr_fname.appendChild(gtd2_fname);
		gtr_fname.appendChild(gtd3_fname);
		gtr_fname.appendChild(gtd4_fname);
		gtable.appendChild(gtr_fname);
		
		let gtr_colon = document.createElement("tr");
		gtr_fname.setAttribute('id', 'gtrcolon');
		gtr_fname.setAttribute('class', 'GradeItems GradeTR');

		let gtd1_colon = document.createElement("td");
		gtd1_colon.setAttribute('id', 'gtd1colon');
		gtd1_colon.setAttribute('class', 'GradeItems GradeTD');
		gtd1_colon.innerHTML = "<strong><em>Missing Colon</em></strong>";

		let gtd2_colon = document.createElement("td");
		gtd2_colon.setAttribute('id', 'gtd2colon');
		gtd2_colon.setAttribute('class', 'GradeItems GradeTD');
		gtd2_colon.innerHTML = "<em>(not missing)</em>";

		let gtd3_colon = document.createElement("td");
		gtd3_colon.setAttribute('id', 'gtd3colon');
		gtd3_colon.setAttribute('class', 'GradeItems GradeTD');
		gtd3_colon.innerHTML = "<em>(see answer)</em>";

		let gtd4_colon = document.createElement("td");
		gtd4_colon.setAttribute('id', 'gtd4colon');
		gtd4_colon.setAttribute('class', 'GradeItems GradeTD');
		
		let change_colon = document.createElement("input");
		change_colon.setAttribute('type', 'text');
		change_colon.setAttribute('name', 'ColonD');
		change_colon.setAttribute('class', 'GradeItems GradeChange');
		change_colon.setAttribute('id', 'ColonD' + questions[question]['gradesID']);
		change_colon.setAttribute('placeholder', 'Deduction');
		change_colon.setAttribute('value', questions[question]['deductedPointsMissingColon']);

		gtd4_colon.appendChild(change_colon);
		gtr_colon.appendChild(gtd1_colon);
		gtr_colon.appendChild(gtd2_colon);
		gtr_colon.appendChild(gtd3_colon);
		gtr_colon.appendChild(gtd4_colon);
		gtable.appendChild(gtr_colon);
		
		let gtr_constraint = document.createElement("tr");
		gtr_constraint.setAttribute('id', 'gtrconstraint');
		gtr_constraint.setAttribute('class', 'GradeItems GradeTR');

		let gtd1_constraint = document.createElement("td");
		gtd1_constraint.setAttribute('id', 'gtd1constraint');
		gtd1_constraint.setAttribute('class', 'GradeItems GradeTD');
		gtd1_constraint.innerHTML = "<strong><em>Constraint</em></strong>";

		let gtd2_constraint = document.createElement("td");
		gtd2_constraint.setAttribute('id', 'gtd2constraint');
		gtd2_constraint.setAttribute('class', 'GradeItems GradeTD');
		gtd2_constraint.innerHTML = "<em>(see question)</em>";

		let gtd3_constraint = document.createElement("td");
		gtd3_constraint.setAttribute('id', 'gtd3constraint');
		gtd3_constraint.setAttribute('class', 'GradeItems GradeTD');
		gtd3_constraint.innerHTML = "<em>(see answer)</em>";

		let gtd4_constraint = document.createElement("td");
		gtd4_constraint.setAttribute('id', 'gtd4constraint');
		gtd4_constraint.setAttribute('class', 'GradeItems GradeTD');
		
		let change_constraint = document.createElement("input");
		change_constraint.setAttribute('type', 'text');
		change_constraint.setAttribute('name', 'ConstraintD');
		change_constraint.setAttribute('class', 'GradeItems GradeChange');
		change_constraint.setAttribute('id', 'ConstraintD' + questions[question]['gradesID']);
		change_constraint.setAttribute('placeholder', 'Deduction');
		change_constraint.setAttribute('value', questions[question]['deductedPointsConstrain']);

		gtd4_constraint.appendChild(change_constraint);
		gtr_constraint.appendChild(gtd1_constraint);
		gtr_constraint.appendChild(gtd2_constraint);
		gtr_constraint.appendChild(gtd3_constraint);
		gtr_constraint.appendChild(gtd4_constraint);
		gtable.appendChild(gtr_constraint);
		
		
		for(let tc = 0; tc < deductions.length; ++tc){

			let gtr = document.createElement("tr");
			gtr.setAttribute('id', 'gtr' + String(tc + 1));
			gtr.setAttribute('class', 'GradeItems GradeTR');

			let gtdName = document.createElement("td");
			gtdName.setAttribute('id', 'gtd' + String(tc + 1) + 'Name');
			gtdName.setAttribute('class', 'GradeItems GradeTD');
			gtdName.innerHTML = '<strong><em>Test Case ' + String(tc + 1) + '</em></strong>';

			let gtdExp = document.createElement("td");
			gtdExp.setAttribute('id', 'gtd' + String(tc + 1) + 'Expected');
			gtdExp.setAttribute('class', 'GradeItems GradeTD');
			gtdExp.innerHTML = expected[tc];
			
			let gtdAct = document.createElement("td");
			gtdAct.setAttribute('id', 'gtd' + String(tc + 1) + 'Actual');
			gtdAct.setAttribute('class', 'GradeItems GradeTD');
			gtdAct.innerHTML = actual[tc];

			let gtdChange = document.createElement("td");
			gtdAct.setAttribute('id', 'gtd' + String(tc + 1) + 'Change');
			gtdAct.setAttribute('class', 'GradeItems GradeTD');
			
			let change = document.createElement("input");

			change.setAttribute('type', 'text');
			change.setAttribute('class', 'GradeItems GradeChange');
			change.setAttribute('name', 'tcD' + tc);
			change.setAttribute('id', 'tcD' + tc + 'q' + questions[question]['gradesID']);
			change.setAttribute('placeholder', 'points');
			change.setAttribute('value', deductions[tc]);
			
			gtdChange.appendChild(change);
			gtr.appendChild(gtdName);
			gtr.appendChild(gtdExp);
			gtr.appendChild(gtdAct);
			gtr.appendChild(gtdChange);
			gtable.appendChild(gtr);
		}

		li.appendChild(gtable);

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
