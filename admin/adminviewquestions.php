<?php

/* Displays user information and some useful messages */
require '../common/db.php';
session_start();
?>

<html>
<head>
	<title>View Questions</title>
    <?php include '../common/header.html';?>
</head>
<body>
    <div class="container">   
        <div class="jumbotron">
            <h1>View Questions - Database name:<?php echo DB_NAME; ?></h1>
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
            $result = $mysqli->query("SELECT * FROM questions");

            if ( $result->num_rows == 0 )
            { // Nothing exists 
                echo "<p>No Users Found</p>";
            }
            else
            {
                echo "<table class='table table-striped table-condensed table-bordered'>";
                echo "  <thead>";
                echo "    <tr>";
                echo "      <th>ID</th>";
                echo "      <th>Question Type</th>";
                echo "      <th>Question</th>";
                echo "    </tr>";
                echo "  </thead>";
                echo "  <tbody>";
                // Users exists (num_rows != 0)
                // output data of each row
                while($user = $result->fetch_assoc())
                {
                    echo "    <tr>";
                    $userid = $user['id'];
                    echo "      <td>" . $userid . "</td>";
                    echo "      <td>" . $user['questiontype'] . "</td>";
                    echo "      <td>" . $user['question'] . "</td>";
                    echo "      </tr>";
                }    
                echo "  </tbody>";
                echo "</table>";
            }
        } ?> 
    </div>
</body>
</html>