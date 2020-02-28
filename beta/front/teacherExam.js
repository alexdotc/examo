ajaxList(listQuestions);

document.getElementById("QuestionList").addEventListener("click", function(e){
	let clickedButton = document.getElementById(e.target.id);

	if (clickedButton && clickedButton.id.substr(0,9) == 'addButton')
		addQuestion(clickedButton);

	else if (clickedButton && clickedButton.id.substr(0,12) == 'removeButton')
		removeQuestion(clickedButton);
});

document.getElementById("SubmitExamForm").addEventListener("submit", ajaxCreateExam);

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

	for(let question in questions){
		let li = document.createElement("div");
		let button = document.createElement("input");
                let pointsBox = document.createElement("input");
		
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

		li.setAttribute('class', 'QuestionItems QuestionListItems');
		li.setAttribute('id', 'question');
		li.innerHTML += '<strong>Topic:</strong> ' + questions[question]['topic'] + '<br />';
		li.innerHTML += '<strong>Difficulty:</strong> ' + questions[question]['difficulty'] + '<br /><br />';
		li.innerHTML += questions[question]['questiontext'] + '<br /><br />';
		li.innerHTML += '<strong>Test Cases:</strong> ' + questions[question]['testcases'] + '<br /><br />';
		
		divList.appendChild(li);
		divList.appendChild(button);
		divList.appendChild(pointsBox);
		
		divList.innerHTML += '<hr />';
	}
}

selections = new Map();

function addQuestion(clickedButton){

        const points = document.getElementById('pointsBox' + clickedButton.name);
        
        if (points.value == '')
            points.value = '0';

	selections.set(clickedButton.name, points.value);
	
        clickedButton.setAttribute("value", "Remove Question");
	clickedButton.setAttribute("id", 'removeButton' + clickedButton.name);

        points.style.visibility = "hidden";
        
	console.log("Added " + clickedButton.name + " with points value " + points.value);
}

function removeQuestion(clickedButton){

        const points = document.getElementById('pointsBox' + clickedButton.name);

	selections.delete(clickedButton.name);

	clickedButton.setAttribute("value", "Add Question");
	clickedButton.setAttribute("id", 'addButton' + clickedButton.name);

        points.style.visibility = "initial";

	console.log("Removed " + clickedButton.name);
}

function ajaxCreateExam(e){
	e.preventDefault();

	const SERVER = 'ajaxHandler.php';

	let examname = document.getElementById("examname").value;

	let ids = [];
	let points = [];
	
	for(let question of selections){
		ids.push(question[0]);
		points.push(question[1]);
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
