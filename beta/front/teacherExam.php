<?php
	define('MAGICNUMBER', true);
	include 'restrict.php';
?>
<div id="ExamMain" class="ExamItems ExamMain">
	<form id="SubmitExamForm" class="ExamItems ExamForm">
		<label for="Exam Name" class="ExamLabel ExamItems"><strong>Exam Name </strong></label>
		<input type="text" name="Exam Name" placeholder="Exam Name" id="examname" class="ExamItems ExamInput"/>
		<input type="submit" value="Create Exam" class="ExamSubmit ExamItems"/>
	</form>
	<h3 id="response" class="ExamCreateResponse"></h3>
	<h2 id="examheader" class="ExamHeader"></h2>
	<div id="split" class="ExamSplit">
		<div id="QuestionList" class="ExamItems ExamQuestions">
		</div>
		<div id="SelectedQuestions" class="ExamItems ExamSelections">
			<p> Selected Questions .. </p>
		</div>
	</div>
</div>
