ajaxList(listQuestions);

window.onscroll = function() { offsetSelected(); }

pkeyword = ""; // reset on page load

document.getElementById("split").addEventListener("click", function(e){
	let clickedButton = document.getElementById(e.target.id);

	if (clickedButton && clickedButton.id.substr(0,9) == 'addButton')
		addQuestion(clickedButton);

	else if (clickedButton && clickedButton.id.substr(0,12) == 'removeButton')
		removeQuestion(clickedButton);
});


document.getElementById('examname').addEventListener('keypress', function(e){ dynamicHeader(e); });

// for some reason it doesn't work for backspace...
document.getElementById('examname').addEventListener('keyup', function(e) {
	if (e.keyCode === 8)
		dynamicHeaderBackspace(e);
});

document.getElementById("SubmitExamForm").addEventListener("submit", ajaxCreateExam);

document.getElementById("ftopic").addEventListener("change", function(e){
	let t = e.target.value;
	filterTopic(t, false);
});

document.getElementById("fdifficulty").addEventListener("change", function(e){
	let t = e.target.value;
	filterDifficulty(t, false);
});

document.getElementById("fkeywordbutton").addEventListener('click', function(e){
	let t = document.getElementById("fkeyword").value;
	filterKeyword(t, false);
});

function filterKeyword(keyword, chain){
        pkeyword = keyword;
        let ql = document.getElementById("QuestionList").childNodes;

        if(chain === false){
                for(let n in ql){
	                if (ql[n].tagName != "DIV")
                                continue;
                        ql[n].style.display = 'block';
                }
        }

        if(keyword == ""){
                if (chain === false){
                        for(let n in ql){
                                if (ql[n].tagName != "DIV")
                                        continue;
                                ql[n].style.display = 'block';
                        }
                        filterDifficulty(document.getElementById("fdifficulty").value, true);
                        filterTopic(document.getElementById("ftopic").value, true);
                }
                return;
        }

        for(let n in ql){
                if (ql[n].tagName != "DIV")
                        continue;
                let s = ql[n].innerHTML.search('<p>') + 3;
                let e = ql[n].innerHTML.search('</p>');
                let desc = ql[n].innerHTML.substr(s, e - s);
                if (desc.search(keyword) == -1)
	                ql[n].style.display = 'none';
        }

        if (chain === false){ // do not remove or you will blow up the stack in your browser until this bad implementation is refactored
                filterDifficulty(document.getElementById("fdifficulty").value, true);
                filterTopic(document.getElementById("ftopic").value, true);
        }
}


function filterTopic(topic, chain){
	let ql = document.getElementById("QuestionList").childNodes;

	if(chain === false){
		for(let n in ql){
			if (ql[n].tagName != "DIV")
				continue;
			ql[n].style.display = 'block';
		}
	}

	if(topic == "All"){
		if (chain === false){
			for(let n in ql){
				if (ql[n].tagName != "DIV")
					continue;
				ql[n].style.display = 'block';
			}
			filterDifficulty(document.getElementById("fdifficulty").value, true);
			filterKeyword(pkeyword, true);
		}
		return;
	}

	for(let n in ql){
		if (ql[n].tagName != "DIV")
			continue;
		if (ql[n].classList.contains('Topic-' + topic) === false)
			ql[n].style.display = 'none';
	}
	
	if (chain === false){ // do not remove or you will blow up the stack in your browser until this bad implementation is refactored
		filterDifficulty(document.getElementById("fdifficulty").value, true);
		filterKeyword(pkeyword, true);
	}
}


function filterDifficulty(difficulty, chain){
	let ql = document.getElementById("QuestionList").childNodes;

	if(chain === false){
		for(let n in ql){
			if (ql[n].tagName != "DIV")
				continue;
			ql[n].style.display = 'block';
		}
	}

	if(difficulty == "All"){
		if (chain === false){
			for(let n in ql){
				if (ql[n].tagName != "DIV")
					continue;
				ql[n].style.display = 'block';
			}
			filterTopic(document.getElementById("ftopic").value, true);
			filterKeyword(pkeyword, true);
		}
		return;
	}

	for(let n in ql){
		if (ql[n].tagName != "DIV")
			continue;
		if (ql[n].classList.contains('Difficulty-' + difficulty) === false)
			ql[n].style.display = 'none';
	}

	if (chain === false){ // do not remove or you will blow up the stack in your browser until this bad implementation is refactored
		filterTopic(document.getElementById("ftopic").value, true);
		filterKeyword(pkeyword, true);
	}
}

	

function dynamicHeader(e){

	let start = e.target.selectionStart;
	let end = e.target.selectionEnd;

	let h = document.getElementById("examheader");
	h.innerHTML = e.target.value.substr(0, start) + String.fromCharCode(e.keyCode) + e.target.value.substr(end);

}

function dynamicHeaderBackspace(e){

	let h = document.getElementById("examheader");

	h.innerHTML = e.target.value;

}

function offsetSelected(){
	
	const divSelected = document.getElementById('SelectedQuestions');

	if (window.pageYOffset > divSelected.offsetTop)
		divSelected.classList.add('fix');
	else
		divSelected.classList.remove('fix');
}

function ajaxList(callback){

        const SERVER = 'ajaxHandler.php';
        const post_params = "RequestType=GetQuestions";

        let xhr = new XMLHttpRequest();
        xhr.open("POST", SERVER, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function(){
                if (xhr.status == 200){
                        let resp = JSON.parse(this.responseText);
                        callback(resp);
                }
        }
        
        xhr.send(post_params);
}

function listQuestions(questions){
	const divList = document.getElementById("QuestionList");
	const TC_DELIMITER = "BORDERLINEN";
	const TC_RDELIMITER = "DRAGONLORD";
	const PLUS_CHARACTER = "LITERALPLUSCHARACTER";
	const TC_REGEX = new RegExp(TC_DELIMITER,"g");
	const TCR_REGEX = new RegExp(TC_RDELIMITER,"g");
	const PLUS_REGEX = new RegExp(PLUS_CHARACTER,"g");

	let index = 0;
	for(let question in questions){
		let li = document.createElement("div");
		let button = document.createElement("input");
                let pointsBox = document.createElement("input");
		let hr = document.createElement("hr");
		
		button.setAttribute('type', 'button');
		button.setAttribute('class', 'QuestionItems QuestionAddButton');
		button.setAttribute('id', 'addButton' + questions[question]['questID']);
		button.setAttribute('name', questions[question]['questID']);
		button.setAttribute('value', "Add Question");

                pointsBox.setAttribute('type', 'text');
                pointsBox.setAttribute('class', 'QuestionItems QuestionPointsBox');
                pointsBox.setAttribute('id', 'pointsBox' + questions[question]['questID']);
                pointsBox.setAttribute('name', questions[question]['questID']);
                pointsBox.setAttribute('placeholder', "Points");
		pointsBox.style.visibility = "hidden";

		li.setAttribute('class', 'QuestionItems QuestionListItems' + ' Topic-' + questions[question]['topic'] + ' Difficulty-' + questions[question]['difficulty']);
		li.setAttribute('id', 'question' + questions[question]['questID']);
		li.innerHTML += '<strong>Topic:</strong> ' + questions[question]['topic'] + '<br />';
		li.innerHTML += '<strong>Difficulty:</strong> ' + questions[question]['difficulty'] + '<br /><br />';
		li.innerHTML += '<p>' + questions[question]['questiontext'] + '</p><br />';
		li.innerHTML += '<strong>Constraint:</strong> ' + questions[question]['constrain'] + '<br /><br />';
		li.innerHTML += '<strong>Test Cases:</strong><br />' + questions[question]['testcases'].replace(PLUS_REGEX, "+").replace(TC_REGEX, "<br />").replace(TCR_REGEX, " : ") + '<br /><br />';

		hr.setAttribute('id', 'hr' + index);
		hr.setAttribute('class', "ExamItems ExamHR");
		
		divList.appendChild(li);
		li.appendChild(button);
		li.appendChild(pointsBox);
		li.appendChild(hr);

		++index;
	}
}

selections = new Map();

function addQuestion(clickedButton){

        const points = document.getElementById('pointsBox' + clickedButton.name);
	const divParent = document.getElementById('SelectedQuestions');
	
	let divChild = document.getElementById("question" + clickedButton.name);

	divChild.setAttribute('id', 'selected' + clickedButton.name);
        
	selections.set(clickedButton.name, '0');
	
        clickedButton.setAttribute("value", "Remove Question");
	clickedButton.setAttribute("id", 'removeButton' + clickedButton.name);
	
	if (points.value == '')
		points.value = '0';
        points.style.visibility = "visible";

	divParent.appendChild(divChild);
}

function removeQuestion(clickedButton){

	let divChild = document.getElementById('selected' + clickedButton.name);
        
	const points = document.getElementById('pointsBox' + clickedButton.name);
	const divParent = document.getElementById('QuestionList');
	const qIndex = parseInt((divChild.getElementsByTagName("hr")[0]).id.substr(2));
	const il = divParent.getElementsByTagName("hr");

	let nIndex = 0;

	for(let q in il){

		if (il[q].tagName != "HR")
			continue;

		let hrid = parseInt(il[q]['id'].substr(2));
		if (hrid > qIndex){
			nIndex = il[q].parentNode;
			break;
		}
	}

	divChild.setAttribute('id', 'question' + clickedButton.name);

	selections.delete(clickedButton.name);

	clickedButton.setAttribute("value", "Add Question");
	clickedButton.setAttribute("id", 'addButton' + clickedButton.name);

        points.style.visibility = "hidden";

	if (nIndex == 0){
		divParent.appendChild(divChild);
		filterTopic(document.getElementById("ftopic").value, false);
		filterDifficulty(document.getElementById("fdifficulty").value, false);
		return;
	}

	divParent.insertBefore(divChild, nIndex);

	filterTopic(document.getElementById("ftopic").value, false);
	filterDifficulty(document.getElementById("fdifficulty").value, false);
	filterKeyword(pkeyword, false);
}

function ajaxCreateExam(e){
	e.preventDefault();

	const SERVER = 'ajaxHandler.php';

	let examname = document.getElementById("examname").value;

	let ids = [];
	let points = [];
	
	for(let question of selections){
		
		let pv = document.getElementById('pointsBox' + question[0]);

		ids.push(question[0]);
		points.push(pv.value);
	}
		
	
	let post_params = 'RequestType=createExam&examname=' + examname + '&ids=' + ids + '&points=' + points;

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
