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
        if (isset($_POST['showadmins']))
        {
            header("location: admindisplay.php");
        } else if (isset($_POST["addadmin"]))
        {
            header("location: adminadd.php");
        } else if (isset($_POST["addtesters"]))
        {
            header("location: adminaddtester.php");
        } else if (isset($_POST["readtesters"]))
        {
            header("location: admindisplaytesters.php");
        } else if (isset($_POST["viewquestions"]))
        {
            header("location: adminviewquestions.php");
        } else if (isset($_POST["addquestions"]))
        {
            header("location: adminaddquestions.php");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Functions Welcome</title>
  <?php include '../common/header.html';?>
      
  <!-- Custom styles for this template -->
  <link href="../css/custom.css" rel="stylesheet">
</head>

<body>
    <div class="container">   
        <div class="jumbotron">
            <h1>Interview Candidate Administration portal</h1>
            <div>
                <?php
                // Display any persistent messages only once.
                if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                // Don't annoy the user with more messages upon page refresh
                unset($_SESSION['message']);
                }
                ?>
            </div>
            <div>
                <h1>Hi, <b><?php echo htmlspecialchars($_SESSION['email']); ?></b>. Welcome to the Admin portal</h1>
            </div>
        </div>    
        <!--this posts back to itself at correct server location -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">  
            <div class="buttonformat"><button class="btn btn-lg btn-primary btn-block" type="submit" name="showadmins">Display Admins</button></div>
            <div class="buttonformat"><button class="btn btn-lg btn-info btn-block" type="submit" name="addadmin">Add Admins</button></div>
            <div class="buttonformat"><button class="btn btn-lg btn-primary btn-block" type="submit" name="addtesters">Add Testers</button></div>
            <div class="buttonformat"><button class="btn btn-lg btn-info btn-block" type="submit" name="readtesters">Display Testers</button></div>
            <div class="buttonformat"><button class="btn btn-lg btn-primary btn-block" type="submit" name="viewquestions">View Questions</button></div>
            <div class="buttonformat"><button class="btn btn-lg btn-info btn-block" type="submit" name="addquestions">Add Questions</button></div>
        </form>
        <div><a href="adminlogout.php">Sign Out of Your Account</a></div>
    </div>
</body>
</html>
