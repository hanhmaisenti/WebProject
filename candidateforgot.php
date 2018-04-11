<?php 
/* Reset your password form, sends reset.php password link */
require 'common/db.php';
session_start();

// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) 
{   
    $email = $mysqli->escape_string($_POST['email']);
    $result = $mysqli->query("SELECT * FROM candidate WHERE email='$email'");

    if ( $result->num_rows == 0 ) // User doesn't exist
    { 
        $_SESSION['message'] = "User with that email doesn't exist!";
        header("location: candidateerror.php");
    }
    else { // User exists (num_rows != 0)

        $user = $result->fetch_assoc(); // $user becomes array with user data
        
        $email = $user['email'];
        $hash = $user['hash'];
        $first_name = $user['first_name'];

        // Session message to display on success.php
        $_SESSION['message'] = "<p>Please check your email <span>$email</span>"
        . " for a confirmation link to complete your password reset!</p>";

        // Send registration confirmation link (reset.php)
        $to      = $email;
        $subject = 'Password Reset Link ( Interview Portal )';
        $headers = "from: francismiles1@gmail.com";
        $message_body = '
        Hello '.$first_name.',

        You have requested password reset!

        Please click this link to reset your password:

        http://localhost/WebProject/candidatereset.php?email='.$email.'&hash='.$hash;  

        mail($to, $subject, $message_body, $headers);

        header("location: index.php");
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Reset Your Password</title>
  <?php include 'css/css.html'; ?>
</head>

<body>
    
  <h1>Reset Your Password</h1>
  <form class="login" action="candidateforgot.php" method="post">
    <div>
      <label>Email Address<span>*</span></label>
      <input type="email" required autocomplete="off" name="email"/>
    </div>
    <div class="actions">
      <input type="submit" name="reset" value="Reset Password"></input>
    </div>
  </form>
</body>

</html>
