<?php
	define('MAGICNUMBER', true);
	include 'restrict.php';
?>
<div id="ExamMain" class="ExamItems ExamMain">
	<h2 class="ExamHeader">New Exam</h2>
	<div id="QuestionList" class="ExamItems ExamQuestions">
	</div>
	<form id="SubmitExamForm" class="ExamItems ExamForm">
		<label for="Exam Name" class="ExamLabel ExamItems">Exam Name: </label>
		<input type="text" name="Exam Name" id="examname" class="ExamItems ExamInput"/>
		<input type="submit" value="Create Exam" class="ExamSubmit ExamItems"/>
	</form>
	<h3 id="response" class="ExamCreateResponse"></h3>
</div>
