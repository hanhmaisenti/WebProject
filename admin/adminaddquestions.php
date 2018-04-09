<?php

/* Displays user information and some useful messages */
require '../candidatedb.php'; //Note we are using the Interview->candidate table now
session_start();

// Processing form data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    // Define variables and initialize with empty values
    $qtype = $question ="";
    $qtype_err = $question_err = "";

    // Validate Question Group
    if(empty(trim($_POST['questiontype']))){
        $qtype_err = "Please enter a question Type";     
    } else {
        $qtype = $_POST['questiontype']; //Valid Question Type
    }

    // Validate Question
    if(empty(trim($_POST['question']))){
        $question_err = "Please enter a Question";     
    } else {
        $question = trim($_POST['question']); //Valid Question
    }

    //Now Validate Entries
    if(empty($qgroup_err) && empty($question_err))
    {
        //Its really all good. Proceed to add the question
        //must protect against sql injection
        $question = $mysqli->escape_string($_POST['question']);
        
        $sql = "INSERT INTO questions (questiontype, question) VALUES ('$qtype','$question')";
        if ( $mysqli->query($sql) ){
            //its ok.
            echo "<p>Success</p>";
            header("location: adminviewquestions.php");
        } else {
            //SQL INSERT didnt work
            $_SESSION['message'] = 'Add question failed!';
            header("location: adminerror.php");
        }
    }
}
?>

<html>
<head>
	<title>Add Question</title>
    <?php include '../css/css.html';?>
</head>
<body>
	<h1>Add Question - To Database name:<?php echo DB_NAME; ?></h1>

    <?php
    // Check if user is logged in using the session variable
    if ( $_SESSION['logged_in'] != 1 ) {
        $_SESSION['message'] = "You must log in before using this tool!";
        header("location: adminerror.php");    
    }
    ?>    

    <h1>Add Question</h1>
    <!--this posts back to itself at correct server location -->
    <form class="login" action="adminaddquestions.php" method="post">
        <div>
            <label>Please select the type of question</label>
            <select name="questiontype">
                <option value="easy">Easy Question</option>
                <option value="medium">Medium Question</option>
                <option value="difficult">Difficult Question</option>
            </select>
            <span><?php echo $qgroup_err; ?></span> <!--we get the error message displayed after the box if its empty -->
        </div> 
        <div>
            <label>Question</label>
            <input type="text" name="question" value="<?php echo $question; ?>">
            <span><?php echo $question_err; ?></span> <!--we get the error message displayed after the box if its empty -->
        </div>   
        <div class="actions">
            <input type="submit" value="Submit">
        </div>
        <p><a href="adminfunctions.php">Go Back</a></p>
    </form>
</body>
</body>
</html>