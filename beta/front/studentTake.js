ajaxShowExam(getExamNameParam(window.location.href), acknowledge);

function getExamNameParam(currentURL){
	
	let sp = "exam=";
	let pInd = currentURL.search(sp);
	let exam = currentURL.substr(pInd + sp.length);
	
	return exam;
}

function ajaxShowExam(ename, callback){
	
	const SERVER = 'ajaxHandler.php';

	let post_params = 'RequestType=showExam&examname=' + ename;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", SERVER, true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	xhr.onload = function(){
		if (xhr.status == 200){
			let elem = document.getElementById("TakeDiv");
			let resp = JSON.parse(this.responseText);

			elem.innerHTML = this.responseText;
		}
	}

	xhr.send(post_params);

}

function acknowledge(){
	console.log("Getting exam...");
}
