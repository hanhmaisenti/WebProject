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
    <?php include 'common/header.html';?>
    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">
</head>
<body>

    <div class="container">   
        <div class="jumbotron">
            <h1>Candidate Questions</h1>
        </div>
        <div>
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
                    echo "<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>";
                    while($question = $result->fetch_assoc()) {
                        echo "<div class='form-label-group'>";

                        echo "<input type='text' name='answers[".$question['id']."]' id='answers' class='form-control' placeholder='Answer' autofocus>";
                        echo "<label for='answers'>"  . $question['question'] .  "</label>";

                        echo "</div>";
                    }
                    echo "<div>";
                    echo "<button class='btn btn-lg btn-primary btn-block' type='submit' name='login'>Submit Answers</button>";
                    echo "</div>";
                    echo "</form>";
                }
            }?>
        </div>
    </div>
</body>
</html>