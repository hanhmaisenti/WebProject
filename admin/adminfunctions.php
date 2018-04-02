<?php

/* Displays user information and some useful messages */
session_start();

// Check if user is logged in using the session variable (variable set from the login page)
if ($_SESSION['logged_in'] != 1) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: adminerror.php");
} else {
    // Makes it easier to read
    $email = $_SESSION['email'];

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST["showadmins"]) {
            header("location: admindisplay.php");
        } else if ($_POST["addadmin"]) {
            header("location: adminadd.php");
        } else if ($_POST["addtesters"]) {
            header("location: adminaddtester.php");
        } else if ($_POST["readtesters"]) {
            header("location: admindisplaytesters.php");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Functions Welcome</title>
  <?php include '../css/css.html';?>
</head>
<body>
<h1>Interview Candidate Administration portal</h1>  
<div class="login">
    <p><?php
      // Display any persistent messages only once.
      if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        // Don't annoy the user with more messages upon page refresh
        unset($_SESSION['message']);
      }
    ?>

    <div>
      <h1>Hi, <b><?php echo htmlspecialchars($_SESSION['email']); ?></b>. Welcome to the Admin portal</h1>
    </div>

    <form action="adminfunctions.php" method="post">
      <div>
        <input type="submit" name="showadmins" value="Display Admins">
      </div>
      <div>
        <input type="submit" name="addadmin" value="Add Admins">
      </div>
      <div>
        <input type="submit" name="addtesters" value="Add Testers">
      </div>
      <div>
        <input type="submit" name="readtesters" value="Display Testers">
      </div>

      <p><a href="adminlogout.php">Sign Out of Your Account</a></p>
    </form>

  </div>
</body>
</html>
