<?php

/* Displays user information and some useful messages */
require '../common/db.php';
session_start();
?>

<html>
<head>
	<title>View Questions</title>
    <?php include '../css/css.html';?>
</head>
<body>
	<h1>View Questions - Database name:<?php echo DB_NAME; ?></h1>
        <?php
        // Check if user is logged in using the session variable
        if ( $_SESSION['logged_in'] != 1 ) {
        $_SESSION['message'] = "You must log in before using this tool!";
        header("location: adminerror.php");    
        }
        else {
            //ok we are logged in.. proceed
            //This part extracts the data from the database
            $result = $mysqli->query("SELECT * FROM questions");

            if ( $result->num_rows == 0 ) { // Nothing exists 
                echo "<p>No Questions Found</p>";
            }
            else {
                echo "<table class='data-table'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Question Type</th>";
                echo "<th>Question</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                // Users exists (num_rows != 0)
                // output data of each row
                while($user = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $user['id'] . "</td>";
                    echo "<td>" . $user['questiontype'] . "</td>";
                    echo "<td>" . $user['question'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</tbody>";
            }
        }?>
</body>
</html>