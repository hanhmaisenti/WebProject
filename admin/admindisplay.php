<?php

/* Displays user information and some useful messages */
require 'admindb.php';
session_start();
?>

<html>
<head>
	<title>Display Admins</title>
    <?php include '../css/css.html';?>
</head>
<body>
	<h1>Display Admins - Database name:<?php echo DB_NAME; ?></h1>
	<table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>EMail</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>

        <?php
        // Check if user is logged in using the session variable
        if ( $_SESSION['logged_in'] != 1 ) {
            $_SESSION['message'] = "You must log in before using this tool!";
            header("location: adminerror.php");    
        }
        else {
            //ok we are logged in.. proceed

            //This part extracts the data from the database
            $result = $mysqli->query("SELECT * FROM admin");

            if ( $result->num_rows == 0 ) { // Nothing exists 
                echo "<p>No Users Found</p>";
            }
            else {
                // Users exists (num_rows != 0)
                // output data of each row
                while($user = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $user['id'] . "</td>";
                    echo "<td>" . $user['email'] . "</td>";
                    echo "<td>" . $user['password'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }?>

        </tbody>
	</table>
</body>
</html>

