<?php
	define('MAGICNUMBER', true);
	include 'restrict.php';
?>
<div id="QuestionForm" class="QuestionItems QuestionMain">
    <h2 class="QuestionHeader">New Question</h2>
    <form id="QuestionForm">
        <label for="Topic" class="QuestionLabel QuestionItems">Topic: </label>
        <select required name="Topic" id="topic" class="QuestionSelect QuestionItems">
            <option value="Arrays">Arrays</option>
            <option value="Loops">Loops</option>
            <option value="Dictionaries">Dictionaries</option>
            <option value="Generators">Generators</option>
            <option value="Recursion">Recursion</option>
            <option value="Lists">Lists</option>
            <option value="Strings">Strings</option>
        </select>
        <label for="Difficulty" class="QuestionLabel QuestionItems">Difficulty: </label>
        <select required name="Difficulty" id="difficulty" class="QuestionSelect QuestionItems">
            <option value="Easy">Easy</option>
            <option value="Medium">Medium</option>
            <option value="Hard">Hard</option>
        </select>
        <label for="VQuestion" class="QuestionLabel QuestionItems">Question: </label>
        <textarea id="VQuestion" form="Question" class="VQuestion QuestionItems" cols="100" rows="10" wrap="soft" placeholder="Enter Your Question Here"></textarea>
        <textarea id="testcase1" form="Question" class="TestCase QuestionItems" cols="100" rows="3" wrap="soft" placeholder="Enter A Test Case Here"></textarea>
        <textarea id="testcase2" form="Question" class="TestCase QuestionItems" cols="100" rows="3" wrap="soft" placeholder="Enter A Test Case Here"></textarea>
        <br />
        <input type="submit" value="Create Question" class="QuestionSubmit QuestionItems" />
    </form>
</div>
