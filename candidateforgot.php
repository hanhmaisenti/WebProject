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
  <?php include 'common/header.html';?>

  <!-- Custom styles for this template -->
  <link href="css/custom.css" rel="stylesheet">
</head>

<body>
  <div class="container">   
      <div class="jumbotron">
          <h1>Reset your Password</h1>
      </div>    
      <!--this posts back to itself at correct server location -->
      <form class="form-signin" action="candidateforgot.php" method="post">  

          <div class="form-label-group">
              <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
              <label for="inputEmail">Email address</label>
              <span><?php echo $email_err; ?></span> <!--we get the error message displayed after the box if its empty -->
          </div>

          <button class="btn btn-lg btn-primary btn-block" type="submit" name="reset">Reset Password</button>
      </form>
  </div>
</body>
</html>
