ajaxList(handle);

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

		li.setAttribute('class', 'QuestionItems QuestionListItems');
		li.setAttribute('id', 'question');
		li.innerHTML += '<strong>Topic:</strong> ' + questions[question]['topic'] + '<br />';
		li.innerHTML += '<strong>Difficulty:</strong> ' + questions[question]['difficulty'] + '<br /><br />';
		li.innerHTML += questions[question]['questiontext'] + '<br /><br />';
		li.innerHTML += '<strong>Test Cases:</strong> ' + questions[question]['testcases'] + '<br />';
		li.innerHTML += '<hr />';
		divList.appendChild(li);
	}
}
