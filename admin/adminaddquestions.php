<?php

/* Displays user information and some useful messages */
require '../common/db.php'; //Note we are using the Interview->candidate table now
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
    <?php include '../common/header.html';?>
</head>
<body>
    <div class="container">   
        <div class="jumbotron">
            <h1>Add Question - To Database name:<?php echo DB_NAME; ?></h1>
        </div>
        <div>
            <?php
            // Check if user is logged in using the session variable
            if ( $_SESSION['logged_in'] != 1 )
            {
                $_SESSION['message'] = "You must log in before using this tool!";
                header("location: adminerror.php");    
            }
            ?>    
        </div>
        <!--this posts back to itself at correct server location -->
        <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">  
            <!--QUESTION TYPE-->
            <div class="form-label-group">
                <select class="selectpicker form-control" name="questiontype" id="questiontype" data-style="btn-info">
                    <option value="easy">Easy Question</option>
                    <option value="medium">Medium Question</option>
                    <option value="difficult">Difficult Question</option>
                </select>
                <span><?php echo $qgroup_err; ?></span> <!--we get the error message displayed after the box if its empty -->
            </div>    

            <!--QUESTION-->
            <div class="form-label-group">
                <input type="text" name="question" id="question" class="form-control" placeholder="Question" required>
                <label for="question">Question</label>
                <span><?php echo $question_err; ?></span> <!--we get the error message displayed after the box if its empty -->
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Submit</button>
            <p><a href="adminfunctions.php">Go Back</a></p>
        </form>
    </div>
</body>
</html>