<?php

/* Displays user information and some useful messages */
require 'common/db.php';

session_start();
// Processing form data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_SESSION['userid'];
    $answers= $_POST['answers']; //multiple instances of this may arrive

    //cycle through each answer
    foreach($answers as $key => $answer){
        //echo "key:".$key." : ".$answer."<br>";
        //push results to database
        $mysqli->query("INSERT INTO answers (candidateid, questionid, answer) VALUES ('$userid','$key','$answer')");
    }
    //immediately log out to stop resubmission
    header("location: candidatelogout.php");
}
?>

<html>
<head>
	<title>Display Candidate Questions</title>
    <?php include 'css/css.html';?>
</head>
<body>
	<h1>Candidate Questions</h1>
    <?php
        // Check if user is logged in using the session variable
        if ( $_SESSION['logged_in'] != 1 ) {
        $_SESSION['message'] = "You must log in before using this tool!";
        header("location: candidateerror.php");    
        }
        else {
            //ok we are logged in.. proceed
            //first, get the question group associated with the user.
            $questiontype = $_SESSION['questiontype'];
            $result = $mysqli->query("SELECT * FROM questions WHERE questiontype='$questiontype'");

            if ( $result->num_rows == 0 ) { // Nothing exists 
                echo "<p>No Questions Found</p>";
            }
            else {
                echo "<form class='questions' action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>";
                while($question = $result->fetch_assoc()) {
                    echo "<div>";
                    echo "<label>" . $question['question'] . "</label>";
                    echo "<input type='text' name='answers[".$question['id']."]'>"; 
                    echo "</div>";
                }
                echo "<div class='actions'>";
                echo "<input type='submit' value='Submit Answers'>";
                echo "</div>";
                echo "</form>";
            }
        }?>
</body>
</html>