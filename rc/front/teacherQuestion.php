<?php
	define('MAGICNUMBER', true);
	include 'restrict.php';
?>
<div id="QuestionMain" class="QuestionItems QuestionMain">
    <h2 class="QuestionHeader">New Question</h2>
    <label for="Filters" class="QuestionLabel QuestionItems"><strong>Question Filters </strong></label>
        <select name="FilterTopic" id="ftopic" class="QuestionItems QuestionFilter">
                <option value="All">All</option>
                <option value="Math">Math</option>
                <option value="Loops">Loops</option>
                <option value="Recursion">Recursion</option>
                <option value="Lists">Lists</option>
                <option value="Strings">Strings</option>
                <option value="Conditionals">Conditionals</option>
	</select>
        <select name="FilterDifficulty" id="fdifficulty" class="QuestionItems QuestionFilter">
                <option value="All">All</option>
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                <option value="Hard">Hard</option>
	</select>
	<input type="text" placeholder="Keyword" id="fkeyword" name="KFilter" class="QuestionItems QuestionInput QuestionFilter" />
	<input type="button" id="fkeywordbutton" class="QuestionItems QuestionButton" value="Filter Keyword" />
    <div id="qsplit" class="QuestionSplit">
    <div id="AddQuestion" class="QuestionItems QuestionAdd">
    <form id="QuestionForm">
	<label for="Topic" class="QuestionLabel QuestionItems"><strong>Topic </strong></label>
        <select required name="Topic" id="topic" class="QuestionSelect QuestionItems">
	    <option value="Lists">Lists</option>
            <option value="Loops">Loops</option>
	    <option value="Math">Math</option>
	    <option value="Strings">Strings</option>
	    <option value="Recursion">Recursion</option>
	    <option value="Conditionals">Conditionals</option>
        </select><br />
        <label for="Difficulty" class="QuestionLabel QuestionItems"><strong>Difficulty </strong></label>
        <select required name="Difficulty" id="difficulty" class="QuestionSelect QuestionItems">
            <option value="Easy">Easy</option>
            <option value="Medium">Medium</option>
            <option value="Hard">Hard</option>
	</select><br /><br />
	<label for="VQuestion" class="QuestionLabel QuestionItems"><br><strong>Question </strong></label><br />
	<p><strong>Function Name </strong><input type="text" placeholder="Name" class="QuestionItems QuestionInput" id="fname" /></p>
	<textarea id="qbody" class="QuestionItems QuestionBody" cols="100" rows="8" wrap="soft" placeholder="Enter question body here"></textarea><br /><br />
	<label for="Constraint" class="QuestionLabel QuestionItems"><strong>Constraint </strong></label>
	<select required name="Constraint" id="constraint" class="QuestionSelect QuestionItems">
	    <option value="None">None</option>
	    <option value="Print">Print</option>
	    <option value="For">For</option>
	    <option value="While">While</option>
	</select><br /><br />
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
    <div id="QuestionBank" class="QuestionItems QuestionBank">
	<h2> Question Bank </h2>
    </div>
    </div>
</div>
