<?php

/* Displays user information and some useful messages */
session_start();

// Check if user is logged in using the session variable (variable set from the login page)
if ($_SESSION['logged_in'] != 1) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: candidateerror.php");
} else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ( !$active ){
        $_SESSION['message'] = "Sorry, your account has not been Activated. Please check your email first";
        header("location: candidateerror.php");
      } else {
        //ITS ALL GOOD. ALLOW the Test to Start
        //do all your stuff here
        echo "<p>Do all your important stuff here!!</p>";
      }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <?php include 'css/css.html';?>
</head>
<body>
    <h1>Welcome! This is the Hanh Maisenti Interview Candidate Portal</h1>
    <div><?php
      // Display any persistent messages only once.
      if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        // Don't annoy the user with more messages upon page refresh
        unset($_SESSION['message']);
      }
    ?></div>
    <?php
          // Keep reminding the user this account is not active, until they activate
          if ( !$active ){
              echo
              '<div class="login">
              Account is unverified, please confirm your email by clicking
              on the email link!
              </div>';
          }
    ?>
    <div class="login">
        <h1><?php echo "Name:".$first_name.'<br>Familyname:'.$last_name."<br>Email:".$email?></h1>
        <div>
            <h1>Hi,
                <b>
                    <?php echo htmlspecialchars($_SESSION['email']); ?>
                </b>. Welcome to the candidate portal</h1>
        </div>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]); ?>" method="post">
        <p>
            <a href="candidatelogout.php">Sign Out of Your Account</a>
        </p>
    </form>
</body>

</html>