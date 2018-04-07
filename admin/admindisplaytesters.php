<?php

/* Displays user information and some useful messages */
require '../candidatedb.php';
session_start();
?>

<html>
<head>
	<title>Display Candidates</title>
    <?php include '../css/css.html';?>
</head>
<body>
	<h1>Display Candidates - Database name:<?php echo DB_NAME; ?></h1>
        <?php
        // Check if user is logged in using the session variable
        if ( $_SESSION['logged_in'] != 1 ) {
        $_SESSION['message'] = "You must log in before using this tool!";
        header("location: adminerror.php");    
        }
        else {
            //ok we are logged in.. proceed
            //This part extracts the data from the database
            $result = $mysqli->query("SELECT * FROM candidate");

            if ( $result->num_rows == 0 ) { // Nothing exists 
                echo "<p>No Users Found</p>";
            }
            else {
                echo "<table class='data-table'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Email</th>";
                echo "<th>First Name</th>";
                echo "<th>Last Name</th>";
                echo "<th>Password</th>";
                echo "<th>Hash</th>";
                echo "<th>Created Date</th>";
                echo "<th>Active</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                // Users exists (num_rows != 0)
                // output data of each row
                while($user = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $user['id'] . "</td>";
                    echo "<td>" . $user['email'] . "</td>";
                    echo "<td>" . $user['first_name'] . "</td>";
                    echo "<td>" . $user['last_name'] . "</td>";
                    echo "<td>" . $user['password'] . "</td>";
                    echo "<td>" . $user['hash'] . "</td>";
                    echo "<td>" . $user['created_at'] . "</td>";
                    echo "<td>" . $user['active'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</tbody>";
            }
        }?>
	</table>
</body>
</html>