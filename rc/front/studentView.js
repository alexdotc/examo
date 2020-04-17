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

        const TC_DELIMITER = "BORDERLINEN";
        const TC_RDELIMITER = "DRAGONLORD";
        const PLUS_CHARACTER = "LITERALPLUSCHARACTER";
        const TC_REGEX = new RegExp(TC_DELIMITER, "g");
        const TCR_REGEX = new RegExp(TC_RDELIMITER, "g");
        const PLUS_REGEX = new RegExp(PLUS_CHARACTER, "g");

	divName.innerHTML = "Currently viewing " + decodeURI(ename);

	let friendlyctr = 1;
	for (let question in questions){
		let li = document.createElement("div");
		let expected = (questions[question]['expectedAnswers']).split("HACKMAGICK");
		let actual = (questions[question]['resultingAnswers']).split("HACKMAGICK");

		let deductions = (questions[question]['deductedPointsPerEachTest']).split(",");
		let tcreals = (questions[question]['questTest']).replace(PLUS_REGEX, "+").split(TC_REGEX);

		li.setAttribute('class', 'ViewItems ViewQuestions');
		li.setAttribute('id', 'examquestion');
		li.innerHTML += '<strong>Question ' + friendlyctr + '</strong><br />';
		li.innerHTML += '<strong>Score: ' + questions[question]['scores'] + ' out of ' + questions[question]['maxScores'] + ' Points</strong><br /><br />';
		li.innerHTML += questions[question]['questions'];

		li.innerHTML += '<br /><br /><strong>Your Answer:</strong><br />';
		li.innerHTML += '<pre>' + questions[question]['answers'] + '</pre><br />';

		let gtable = document.createElement("table");
		
		gtable.setAttribute('id','gtable' + questions[question]['gradesId']);
		gtable.setAttribute('class', 'ViewItems ViewTable');

		let gti = document.createElement("tr");
		gti.innerHTML = "<td><strong>Grader Item</strong></td><td><strong>Expected Answer</strong></td><td><strong>Actual Answer</td><td><strong>Deducted Points</strong></td>"
		gtable.appendChild(gti);

		let gtr_fname = document.createElement("tr");
		gtr_fname.setAttribute('id', 'gtrfname');
		gtr_fname.setAttribute('class', 'ViewItems ViewTR');

		let gtd1_fname = document.createElement("td");
		gtd1_fname.setAttribute('id', 'gtd1fname');
		gtd1_fname.setAttribute('class', 'ViewItems ViewTD');
		gtd1_fname.innerHTML = "<strong><em>Function Name</em></strong>";

		let gtd2_fname = document.createElement("td");
		gtd2_fname.setAttribute('id', 'gtd2fname');
		gtd2_fname.setAttribute('class', 'ViewItems ViewTD');
		gtd2_fname.innerHTML =  tcreals[0].substr(0,tcreals[0].indexOf("("));

		let gtd3_fname = document.createElement("td");
		gtd3_fname.setAttribute('id', 'gtd3fname');
		gtd3_fname.setAttribute('class', 'ViewItems ViewTD');
		gtd3_fname.innerHTML = "<em>(see answer)</em>";

		let gtd4_fname = document.createElement("td");
		gtd4_fname.setAttribute('id', 'gtd4fname');
		gtd4_fname.setAttribute('class', 'ViewItems ViewTD');
		gtd4_fname.innerHTML = questions[question]['deductedPointscorrectName'];

		gtr_fname.appendChild(gtd1_fname);
		gtr_fname.appendChild(gtd2_fname);
		gtr_fname.appendChild(gtd3_fname);
		gtr_fname.appendChild(gtd4_fname);
		gtable.appendChild(gtr_fname);

                let gtr_colon = document.createElement("tr");
		gtr_colon.setAttribute('id', 'gtrcolon');
		gtr_colon.setAttribute('class', 'ViewItems ViewTR');

		let gtd1_colon = document.createElement("td");
		gtd1_colon.setAttribute('id', 'gtd1colon');
		gtd1_colon.setAttribute('class', 'ViewItems ViewTD');
		gtd1_colon.innerHTML = "<strong><em>Missing Colon</em></strong>";

		let gtd2_colon = document.createElement("td");
		gtd2_colon.setAttribute('id', 'gtd2colon');
		gtd2_colon.setAttribute('class', 'ViewItems ViewTD');
		gtd2_colon.innerHTML = "<em>(not missing)</em>";

		let gtd3_colon = document.createElement("td");
		gtd3_colon.setAttribute('id', 'gtd3colon');
		gtd3_colon.setAttribute('class', 'ViewItems ViewTD');
		gtd3_colon.innerHTML = "<em>(see answer)</em>";

		let gtd4_colon = document.createElement("td");
		gtd4_colon.setAttribute('id', 'gtd4colon');
		gtd4_colon.setAttribute('class', 'ViewItems ViewTD');
		gtd4_colon.innerHTML = questions[question]['deductedPointsMissingColon'];

		gtr_colon.appendChild(gtd1_colon);
		gtr_colon.appendChild(gtd2_colon);
		gtr_colon.appendChild(gtd3_colon);
		gtr_colon.appendChild(gtd4_colon);
		gtable.appendChild(gtr_colon);

		let gtr_constraint = document.createElement("tr");
		gtr_constraint.setAttribute('id', 'gtrconstraint');
		gtr_constraint.setAttribute('class', 'ViewItems ViewTR');

		let gtd1_constraint = document.createElement("td");
		gtd1_constraint.setAttribute('id', 'gtd1constraint');
		gtd1_constraint.setAttribute('class', 'ViewItems ViewTD');
		gtd1_constraint.innerHTML = "<strong><em>Constraint</em></strong>";

		let gtd2_constraint = document.createElement("td");
		gtd2_constraint.setAttribute('id', 'gtd2constraint');
		gtd2_constraint.setAttribute('class', 'ViewItems ViewTD');
		if (/.*[A-Z][a-z].*/i.test(questions[question]['constrain']) && questions[question]['constrain'] != 'None')
			gtd2_constraint.innerHTML = "<em>(" + questions[question]['constrain'] + " constraint)</em>";
		else
			gtd2_constraint.innerHTML = "<em>(none)</em>";

		let gtd3_constraint = document.createElement("td");
		gtd3_constraint.setAttribute('id', 'gtd3constraint');
		gtd3_constraint.setAttribute('class', 'ViewItems ViewTD');
		gtd3_constraint.innerHTML = "<em>(see answer)</em>";

		let gtd4_constraint = document.createElement("td");
		gtd4_constraint.setAttribute('id', 'gtd4constraint');
		gtd4_constraint.setAttribute('class', 'ViewItems ViewTD');
		gtd4_constraint.innerHTML = questions[question]['deductedPointsConstrain'];

                gtr_constraint.appendChild(gtd1_constraint);
		gtr_constraint.appendChild(gtd2_constraint);
		gtr_constraint.appendChild(gtd3_constraint);
		gtr_constraint.appendChild(gtd4_constraint);
		gtable.appendChild(gtr_constraint);

		for (let tc = 0; tc < deductions.length; ++tc){
			let gtr = document.createElement("tr");
			gtr.setAttribute('id', 'gtr_tc' + String(tc + 1));
			gtr.setAttribute('class', 'ViewItems ViewTR');

			let gtdName = document.createElement("td");
			gtdName.setAttribute('id', 'gtd' + String(tc + 1) + 'Name');
			gtdName.setAttribute('class', 'ViewItems ViewTD');
			gtdName.innerHTML = '<strong><em>Test Case ' + tcreals[tc].substr(0,tcreals[tc].indexOf(TC_RDELIMITER)) + '</em></strong>';

			let gtdExp = document.createElement("td");
			gtdExp.setAttribute('id', 'gtd' + String(tc + 1) + 'Expected');
			gtdExp.setAttribute('class', 'ViewItems ViewTD');
			gtdExp.innerHTML = expected[tc];

			let gtdAct = document.createElement("td");
			gtdAct.setAttribute('id', 'gtd' + String(tc + 1) + 'Actual');
			gtdAct.setAttribute('class', 'ViewItems ViewTD');
			gtdAct.innerHTML = actual[tc];

			let gtdPrev = document.createElement("td");
			gtdPrev.setAttribute('id', 'gtd' + String(tc + 1) + 'Prev');
			gtdPrev.setAttribute('class', 'ViewItems ViewTD');
			gtdPrev.innerHTML = deductions[tc];

			gtr.appendChild(gtdName);
			gtr.appendChild(gtdExp);
			gtr.appendChild(gtdAct);
			gtr.appendChild(gtdPrev);
			gtable.appendChild(gtr);
		}
		
		li.appendChild(gtable);

		if (questions[question]['comments'] != ''){
			li.innerHTML += '<br /><strong>Instructor Comments:</srong><br />';
			li.innerHTML += questions[question]['comments'];
		}
		
		divExam.appendChild(li);

		divExam.innerHTML += '<hr />';

		++friendlyctr;
	}
}

