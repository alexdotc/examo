ajaxList(listExams);

function ajaxList(callback){

        const SERVER = 'ajaxHandler.php';
        const post_params = "RequestType=listGradedExams";

        let xhr = new XMLHttpRequest();
        xhr.open("POST", SERVER, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function(){
                if (xhr.status == 200){
                	if (this.responseText == "No exams found, try again later..."){
                        	document.getElementById("CompletedList").innerHTML = "No exams found...";
                        	return;
                }

                        let resp = JSON.parse(this.responseText);
                        callback(resp);
                }
        }
        
        xhr.send(post_params);
}

function listExams(exams){
	const divList = document.getElementById("CompletedList");

	for(let exam in exams){
		let li = document.createElement("li");
		let a = document.createElement("a");

		a.setAttribute('class', 'ExamLinks');
		a.setAttribute('href', '#grade?exam=' + exams[exam]['exaName'] + '?user=' + exams[exam]['ucid']);
		a.innerHTML = exams[exam]['exaName'] + ' (STUDENT: <strong>' + exams[exam]['ucid'] + '</strong>)';
		
		li.setAttribute('class', 'ExamItems ExamNames');
		li.setAttribute('id', 'examname');
		li.appendChild(a);
		li.innerHTML += '<br />';
		
		divList.appendChild(li);
	}
}
