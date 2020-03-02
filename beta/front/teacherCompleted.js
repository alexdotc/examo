ajaxList(listExams);

function ajaxList(callback){

        const SERVER = 'ajaxHandler.php';
        const post_params = "RequestType=listGradedExams";

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

function listExams(exams){
	const divList = document.getElementById("CompletedList");

	for(let exam in exams){
		let li = document.createElement("li");
		
		li.setAttribute('class', 'ExamItems ExamNames');
		li.setAttribute('id', 'examname');
                li.innerHTML += '<a href="#grade?exam=' + exams[exam]['exaName'] + '">' + exams[exam]['exaName'] + '</a>';
		li.innerHTML += ' STUDENT: <strong>' + exams[exam]['ucid'] + '</strong><br />';
		
		divList.appendChild(li);
	}
}
