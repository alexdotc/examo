ajaxList(handle);

document.getElementById("main").addEventListener("click", function(e){
	let clickedButton = document.getElementById(e.target.id);

	if (clickedButton && clickedButton.id.substr(0,9) == 'addButton')
		addQuestion(clickedButton);

	else if (clickedButton && clickedButton.id.substr(0,12) == 'removeButton')
		removeQuestion(clickedButton);
});

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

function handle(questions){
	const divList = document.getElementById("QuestionList");

	for(let question in questions){
		let li = document.createElement("div");
		let button = document.createElement("input");
		
		button.setAttribute('type', 'button');
		button.setAttribute('class', 'QuestionItems QuestionAddButton');
		button.setAttribute('id', 'addButton' + questions[question]['questID']);
		button.setAttribute('name', questions[question]['questID']);
		button.setAttribute('value', 'Add Question');

		li.setAttribute('class', 'QuestionItems QuestionListItems');
		li.setAttribute('id', 'question');
		li.innerHTML += '<strong>Topic:</strong> ' + questions[question]['topic'] + '<br />';
		li.innerHTML += '<strong>Difficulty:</strong> ' + questions[question]['difficulty'] + '<br /><br />';
		li.innerHTML += questions[question]['questiontext'] + '<br /><br />';
		li.innerHTML += '<strong>Test Cases:</strong> ' + questions[question]['testcases'] + '<br /><br />';
		
		divList.appendChild(li);
		divList.appendChild(button);
		
		divList.innerHTML += '<hr />';
	}
}

let selections = new Set();

function addQuestion(clickedButton){

	selections.add(clickedButton.name);
	clickedButton.setAttribute("value", "Remove Question");
	clickedButton.setAttribute("id", 'removeButton' + clickedButton.name);
	console.log("Added " + clickedButton.name);
}

function removeQuestion(clickedButton){

	selections.delete(clickedButton.name);
	clickedButton.setAttribute("value", "Add Question");
	clickedButton.setAttribute("id", 'addButton' + clickedButton.name);
	console.log("Removed " + clickedButton.name);
}
