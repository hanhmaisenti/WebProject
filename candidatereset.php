<?php
/* The password reset form, the link to this page is included
   from the forgot.php email message
*/
require 'common/db.php';
session_start();

// Make sure email and hash variables aren't empty
if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
{
    $email = $mysqli->escape_string($_GET['email']); 
    $hash = $mysqli->escape_string($_GET['hash']); 

    // Make sure user email with matching hash exist
    $result = $mysqli->query("SELECT * FROM candidate WHERE email='$email' AND hash='$hash'");

    if ( $result->num_rows == 0 )
    { 
        $_SESSION['message'] = "You have entered invalid URL for password reset!";
        header("location: candidateerror.php");
    }
}
else {
    $_SESSION['message'] = "Sorry, verification failed, try again!";
    header("location: candidateerror.php");  
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
    <?php include 'common/header.html';?>
    
    <!-- Custom styles for this template -->
    <link href="css/floating-labels.css" rel="stylesheet">
</head>

<body>
    <div class="container">   
        <div class="jumbotron">
            <h1>Choose your new Password</h1>
        </div>    
        <!--this posts back to itself at correct server location -->
        <form class="form-signin" action="candidateresetpassword.php" method="post">  
            <div class="form-label-group">
                <input type="password" name="newpassword" id="NewPassword" class="form-control" placeholder="Password" required>
                <label for="NewPassword">New Password</label>
            </div>
            <div class="form-label-group">
                <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Password" required>
                <label for="confirmpassword">Confirm New Password</label>
            </div>

            <!-- This input field is needed, to get the email of the user -->
            <input type="hidden" name="email" value="<?= $email ?>">
            <input type="hidden" name="hash" value="<?= $hash ?>">

            <button class="btn btn-lg btn-primary btn-block" type="submit" name="apply">Apply</button>
        </form>
    </div>
</body>
</html>
