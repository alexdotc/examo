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
	<p>Write a function named <input type="text" placeholder="Name" class="QuestionItems QuestionInput" id="fname" />.<br />Given <input type="text" placeholder="Arguments" class="QuestionItems QuestionInput" id="fargs" />, the function should <input type="text" placeholder="Do Something" class="QuestionItems QuestionInput" id="fbody" /><br /> and <select required name="Output Type" id="fotype" class="QuestionSelect QuestionItems"><option value="return">return</option><option value="print">print</option></select> <input type="text" placeholder="Output" class="QuestionItems QuestionInput" id="foutput" />.</p><br />
	<label for="Test Cases" class="QuestionLabel QuestionItems"><strong>Test Cases </strong></label><br /><br />
	<input type="text" placeholder="Inputs" class="QuestionItems QuestinInput" id="testinput1" name="TestIn" /><input type="text" placeholder="Expected Output" class="QuestionItems QuestionInput" id="testoutput1" name="TestOut" /><br />
	<input type="text" placeholder="Inputs" class="QuestionItems QuestinInput" id="testinput2" name="TestIn"/><input type="text" placeholder="Expected Output" class="QuestionItems QuestionInput" id="testoutput2" name="TestOut" /><br />
        <br />
        <input type="submit" value="Create Question" class="QuestionSubmit QuestionItems" />
    </form>
    <h3 id="response" class="QuestionSubmitResponse"></h3>
</div>
