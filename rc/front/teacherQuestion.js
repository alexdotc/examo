ajaxList(listQuestions);

document.getElementById("ftopic").addEventListener("change", function(e){
	        let t = e.target.value;
	        filterTopic(t, false);
});

document.getElementById("fdifficulty").addEventListener("change", function(e){
	        let t = e.target.value;
	        filterDifficulty(t, false);
});

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

function filterTopic(topic, chain){
	let ql = document.getElementById("QuestionBank").childNodes;
        
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
                }
                return;
        }

        for(let n in ql){
                if (ql[n].tagName != "DIV")
                        continue;
                if (ql[n].classList.contains('Topic-' + topic) === false)
                        ql[n].style.display = 'none';
        }

        if (chain === false) // do not remove or you will blow up the stack in your browser until this bad implementation is refactored
                filterDifficulty(document.getElementById("fdifficulty").value, true);
}

function filterDifficulty(difficulty, chain){
       let ql = document.getElementById("QuestionBank").childNodes;

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
                }
                return;
        }

        for(let n in ql){
                if (ql[n].tagName != "DIV")
                        continue;
                if (ql[n].classList.contains('Difficulty-' + difficulty) === false)
                        ql[n].style.display = 'none';
        }

        if (chain === false) // do not remove or you will blow up the stack in your browser until this bad implementation is refactored
                filterTopic(document.getElementById("ftopic").value, true);
}
function removeTC(cb){
	cb.parentNode.removeChild(cb);
}

function ajaxList(callback){
	
	const SERVER = 'ajaxHandler.php';
	const post_params = 'RequestType=GetQuestions';

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
        const divList = document.getElementById("QuestionBank");
        const TC_DELIMITER = "\\\?"; // really fuckin confusing, we basically need to escape the question mark AND the backslash so that this is interpolated correctly at multiple stages
        const TC_REGEX = new RegExp(TC_DELIMITER,"g");

        let index = 0;
        for(let question in questions){
                let li = document.createElement("div");
                let hr = document.createElement("hr");

                li.setAttribute('class', 'QuestionItems QuestionListItems' + ' Topic-' + questions[question]['topic'] + ' Difficulty-' + questions[question]['difficulty']);
                li.setAttribute('id', 'question' + questions[question]['questID']);
                li.innerHTML += '<strong>Topic:</strong> ' + questions[question]['topic'] + '<br />';
                li.innerHTML += '<strong>Difficulty:</strong> ' + questions[question]['difficulty'] + '<br /><br />';
                li.innerHTML += questions[question]['questiontext'] + '<br /><br />';
                li.innerHTML += '<strong>Constraint:</strong> ' + questions[question]['constrain'] + '<br /><br />';
                li.innerHTML += '<strong>Test Cases:</strong><br />' + questions[question]['testcases'].replace(TC_REGEX, "<br />") + '<br /><br />';

                hr.setAttribute('id', 'hr' + index);
                hr.setAttribute('class', "ExamItems ExamHR");

                divList.appendChild(li);
                li.appendChild(hr);

                ++index;
        }
}


function ajaxSubmit(e){
	
	e.preventDefault();

	const SERVER = 'ajaxHandler.php';

	let difficulty = document.getElementById("difficulty").value;
	let topic = document.getElementById("topic").value;
	let constraint = document.getElementById("constraint").value;
	let fname = document.getElementById("fname").value;
	let vquestion = document.getElementById("qbody").value;
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
 
        let post_params = "RequestType=CreateQuestion" + "&topic=" + topic + "&difficulty=" + difficulty + "&questiontext=" + vquestion + "&constraint=" + constraint + "&testcases=" + tcs;

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

