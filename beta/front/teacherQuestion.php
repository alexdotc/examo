<?php
	define('MAGICNUMBER', true);
	include 'restrict.php';
?>
<div id="QuestionForm" class="QuestionItems QuestionMain">
    <h2 class="QuestionHeader">New Question</h2>
    <form id="QuestionForm">
        <label for="Topic" class="QuestionLabel QuestionItems">Topic: </label>
        <input type="text" name="Topic" id="topic" class="QuestionText QuestionItems" />
        <label for="Difficulty" class="QuestionLabel QuestionItems">Difficulty: </label>
        <input type="text" name="Difficulty" id="difficulty" class="QuestionText QuestionItems" />
        <label for="VQuestion" class="QuestionLabel QuestionItems">Question: </label>
        <textarea id="VQuestion" form="Question" class="VQuestion QuestionItems" cols="100" rows="10" wrap="soft" placeholder="Enter Your Question Here"></textarea>
        <br />
        <input type="submit" value="Create Question" class="QuestionSubmit QuestionItems" />
    </form>
</div>
