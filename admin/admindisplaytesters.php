<?php

/* Displays user information and some useful messages */
require '../common/db.php';
session_start();
?>

<html>
<head>
	<title>Display Candidates</title>
    <?php include '../common/header.html';?>
</head>
<body>
    <div class="container">   
        <div class="jumbotron">
            <h1>Display Candidates - Database name:<?php echo DB_NAME; ?></h1>
            <div>
                <?php
                // Display any persistent messages only once.
                if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                // Don't annoy the user with more messages upon page refresh
                unset($_SESSION['message']);
                }
                ?>
            </div>
        </div>
    </div>
    <div class="container-fluid table-responsive">
        <?php
        // Check if user is logged in using the session variable
        if ( $_SESSION['logged_in'] != 1 )
        {
            $_SESSION['message'] = "You must log in before using this tool!";
            header("location: adminerror.php");    
        }
        else
        {
            //ok we are logged in.. proceed
            //This part extracts the data from the database
            $result = $mysqli->query("SELECT * FROM candidate");

            if ( $result->num_rows == 0 )
            { // Nothing exists 
                echo "<p>No Users Found</p>";
            }
            else
            {
                // Users exists (num_rows != 0)
                // output data of each row
                while($user = $result->fetch_assoc())
                {
                    echo "<table class='table table-striped table-condensed table-bordered'>";
                    echo "  <thead>";
                    echo "    <tr>";
                    echo "      <th>ID</th>";
                    echo "      <th>Email</th>";
                    echo "      <th>First Name</th>";
                    echo "      <th>Last Name</th>";
                    echo "      <th>Password</th>";
                    echo "      <th>Hash</th>";
                    echo "      <th>Created Date</th>";
                    echo "      <th>Active</th>";
                    echo "      <th>Question Type</th>";
                    echo "    </tr>";
                    echo "  </thead>";
                    echo "  <tbody>";

                    echo "    <tr>";
                    $userid = $user['id'];
                    echo "      <td>" . $userid . "</td>";
                    echo "      <td>" . $user['email'] . "</td>";
                    echo "      <td>" . $user['first_name'] . "</td>";
                    echo "      <td>" . $user['last_name'] . "</td>";
                    echo "      <td>" . $user['password'] . "</td>";
                    echo "      <td>" . $user['hash'] . "</td>";
                    echo "      <td>" . $user['created_at'] . "</td>";
                    echo "      <td>" . $user['active'] . "</td>";
                    echo "      <td>" . $user['questiontype'] . "</td>";
                    echo "      </tr>";

                    //Now get all answers for that particular candidate
                    $answers = $mysqli->query("SELECT * FROM answers where candidateid='$userid'");
                    if ( $answers->num_rows == 0 )
                    {
                        // Nothing exists  - Do nothing
                    }
                    else
                    {
                        echo "<table class='table table-dark table-striped'>";
                        echo "  <thead>";
                        echo "    <tr>";
                        echo "      <th>question Type</th>";
                        echo "      <th>Question</th>";
                        echo "      <th>Answer</th>";
                        echo "    </tr>";
                        echo "  </thead>";
                        echo "  <tbody>";
                        while($answer = $answers->fetch_assoc())
                        {
                            echo "<tr>";
                            $questionid = $answer['questionid']; //we need the id to get the actual question
                            $tmp = $mysqli->query("SELECT questiontype FROM questions where id='$questionid'");
                            $questiontype = $tmp->fetch_row();
                            $tmp = $mysqli->query("SELECT question FROM questions where id='$questionid'");
                            $question = $tmp->fetch_row();
                            echo "<td>".$questiontype[0]."</td>";
                            echo "<td>".$question[0]."</td>";
                            echo "<td>".$answer['answer']."</td>";
                            echo "</tr>";
                        }
                        echo "  </tbody>";
                        echo "</table>";
                    }

                }    
                echo "  </tbody>";
                echo "</table>";
            }
        } ?> 
    </div>
</body>
</html>



