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
	<table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Password</th>
                <th>Hash</th>
                <th>Created Date</th>
                <th>Active</th>
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
            $result = $mysqli->query("SELECT * FROM candidate");

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
                    echo "<td>" . $user['first_name'] . "</td>";
                    echo "<td>" . $user['last_name'] . "</td>";
                    echo "<td>" . $user['password'] . "</td>";
                    echo "<td>" . $user['hash'] . "</td>";
                    echo "<td>" . $user['created_at'] . "</td>";
                    echo "<td>" . $user['active'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }?>
        </tbody>
	</table>
</body>
</html>