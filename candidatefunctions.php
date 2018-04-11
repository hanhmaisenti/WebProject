<?php

/* Displays user information and some useful messages */
session_start();

// Check if user is logged in using the session variable (variable set from the login page)
if ($_SESSION['logged_in'] != 1) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: candidateerror.php");
} else {
    // Makes it easier to read
    //$first_name = $_SESSION['first_name'];
    //$last_name = $_SESSION['last_name'];
    //$email = $_SESSION['email'];
    $active = $_SESSION['active'];
    //$questiontype = $_SESSION['questiontype'];

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ( !$active ){
        $_SESSION['message'] = "Sorry, your account has not been Activated. Please check your email first";
        header("location: candidateerror.php");
      } else {
        //ITS ALL GOOD. ALLOW the Test to Start
        //do all your stuff here
        header("location: candidatequestions.php");
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

    <div class="formfunctions">
        <?php
        // Display any persistent messages only once.
        if (isset($_SESSION['message'])) {
            echo "<p>".$_SESSION['message']."</p>";
            // Don't annoy the user with more messages upon page refresh
            unset($_SESSION['message']);
        }
        ?>
    </div>
    <?php
        // Keep reminding the user this account is not active, until they activate
        if ( !$active ){
            echo
            '<div class="formfunctions">
            Account is unverified, please confirm your email by clicking
            on the email link!
            </div>';
        }
    ?>

    <h1>Hi, <?php echo htmlspecialchars($_SESSION['first_name']); ?>. Welcome to the candidate portal</h1>
    <form class="formfunctions" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="actions">
            <input type="submit" name="starttest" value="Start Test">
        </div>
   </form>

    <div class="footer"><a href="candidatelogout.php">Sign Out of Your Account</a></div>
</body>

</html>