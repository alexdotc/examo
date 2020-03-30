<?php
	define('MAGICNUMBER', true);
	include 'restrict.php';
?>
<div id="QuestionMain" class="QuestionItems QuestionMain">
    <h2 class="QuestionHeader">New Question</h2>
    <form id="QuestionForm">
        <label for="Topic" class="QuestionLabel QuestionItems"><strong>Topic </strong></label>
        <select required name="Topic" id="topic" class="QuestionSelect QuestionItems">
	    <option value="Lists">Lists</option>
            <option value="Loops">Loops</option>
	    <option value="Math">Math</option>
	    <option value="Strings">Strings</option>
	    <option value="Recursion">Recursion</option>
        </select><br />
        <label for="Difficulty" class="QuestionLabel QuestionItems"><strong>Difficulty </strong></label>
        <select required name="Difficulty" id="difficulty" class="QuestionSelect QuestionItems">
            <option value="Easy">Easy</option>
            <option value="Medium">Medium</option>
            <option value="Hard">Hard</option>
        </select><br /><br />
	<label for="VQuestion" class="QuestionLabel QuestionItems"><br><strong>Question </strong></label><br />
	<p><strong>Function Name </strong><input type="text" placeholder="Name" class="QuestionItems QuestionInput" id="fname" /></p>
	<textarea id="qbody" class="QuestionItems QuestionBody" cols="100" rows="8" wrap="soft" placeholder="Enter question body here"></textarea><br /><br /><br />
	<label for="Test Cases" class="QuestionLabel QuestionItems"><strong>Test Cases </strong></label><br /><br />
	<div id="tc">
	<div id="testcase" class="QuestionItems QuestionTestCases">
	<input type="text" placeholder="Inputs" class="QuestionItems QuestinInput" id="testinput" name="TestIn"/><input type="text" placeholder="Expected Output" class="QuestionItems QuestionInput" id="testoutput" name="TestOut" /><input type="button" class="QuestionItems QuestionInput QuestionHButton" id="tcRemove" value="Remove"><br />
	</div>
	<div id="testcase" class="QuestionItems QuestionTestCases">
	<input type="text" placeholder="Inputs" class="QuestionItems QuestinInput" id="testinput" name="TestIn"/><input type="text" placeholder="Expected Output" class="QuestionItems QuestionInput" id="testoutput" name="TestOut" /><input type="button" class="QuestionItems QuestionHButton" id="tcRemove" value="Remove" /><br />
	</div>
	</div>
	<input type="button" id="tcAdd" value="Add Another Test Case" class="QuestionItems QuestionButton"></input>
        <br /><br /><br />
        <input type="submit" value="Create Question" class="QuestionSubmit QuestionItems" />
    </form>
    <h3 id="response" class="QuestionSubmitResponse"></h3>
</div>
