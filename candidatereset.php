<?php
/* The password reset form, the link to this page is included
   from the forgot.php email message
*/
require 'candidatedb.php';
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
    <?php include 'css/css.html'; ?>
</head>

<body>
    <h1>Choose Your New Password</h1>
    <div class="login">
        <form action="candidateresetpassword.php" method="post">
            <div>
                <label>New Password<span>*</span></label>
                <input type="password" required name="newpassword" autocomplete="off" />
            </div>

            <div>
                <label>Confirm New Password<span>*</span></label>
                <input type="password" required name="confirmpassword" autocomplete="off" />
            </div>

            <!-- This input field is needed, to get the email of the user -->
            <input type="hidden" name="email" value="<?= $email ?>">
            <input type="hidden" name="hash" value="<?= $hash ?>">
            <div class="actions">
              <input type="submit" name="apply" value="Apply"></input>
            </div>
        </form>
    </div>
</body>
</html>
