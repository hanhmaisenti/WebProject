<?php

/* Displays user information and some useful messages */
require '../common/db.php';
session_start();

// Processing form data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    // Define variables and initialize with empty values
    $email = $password = $confirm_password ="";
    $email_err = $password_err = $confirm_password_err = "";

    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        //this displays directly into the HTML
        $email_err = 'Please enter email.';
    } else {

        //attempt to discover if the email address is already taken
        //must protect against sql injection
        $email = $mysqli->escape_string($_POST['email']); 
        $result = $mysqli->query("SELECT * FROM admin WHERE email='$email'") or die($mysqli->error());
        
        if ( $result->num_rows == 0 ) {
            //this is good. Email address not take

            // Validate password
            if(empty(trim($_POST['password']))){
                $password_err = "Please enter a password.";     
            } elseif(strlen(trim($_POST['password'])) < 6){
                $password_err = "Password must have at least 6 characters.";
            } else {
                $password = trim($_POST['password']); //Valid Password
            }

            // Validate confirm password
            if(empty(trim($_POST["confirm_password"]))){
                $confirm_password_err = 'Please confirm password.';     
            } else {
                $confirm_password = trim($_POST['confirm_password']); //Valid ConfirmPassword
                if($password != $confirm_password){
                    $confirm_password_err = 'Password did not match.';
                }
            }

            //Now Validate credentials
            if(empty($email_err) && empty($password_err)  && empty($confirm_password_err))
            {
                //Its really all good. Proceed to add the person
                //must protect against sql injection
                $email = $mysqli->escape_string($_POST['email']);
                $password = $mysqli->escape_string(password_hash(trim($_POST['password']), PASSWORD_BCRYPT));
                
                $sql = "INSERT INTO admin (email, password) VALUES ('$email','$password')";
                if ( $mysqli->query($sql) ){
                    echo "<p>Success</p>";
                    header("location: admindisplay.php");
                } else {
                    $_SESSION['message'] = 'Registration failed!';
                    header("location: adminerror.php");
                }
            }

        } else {
            //This is not good. Email address already taken
            $_SESSION['message'] = "The Email address is already registered!";
            header("location: adminerror.php");
        }

    }
}
?>

<html>
<head>
	<title>Add Admin</title>
    <?php include '../css/css.html';?>
</head>
<body>
	<h1>Add Admin - To Database name:<?php echo DB_NAME; ?></h1>

    <?php
    // Check if user is logged in using the session variable
    if ( $_SESSION['logged_in'] != 1 ) {
        $_SESSION['message'] = "You must log in before using this tool!";
        header("location: adminerror.php");    
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    }?>    

    <h1>Add Admin</h1>
    <!--this posts back to itself at correct server location -->
    <form class="login" action="adminadd.php" method="post">
        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
            <span><?php echo $email_err; ?></span> <!--we get the error message displayed after the box if its empty -->
        </div>    
        <div>
            <label>Password</label>
            <input type="password" name="password" class="form-control">
            <span><?php echo $password_err; ?></span> <!--we get the error message displayed after the box if its empty -->
        </div>
        <div>
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
            <span><?php echo $confirm_password_err; ?></span> <!--we get the error message displayed after the box if its empty -->
        </div>            
        <div class="actions"><input type="submit" value="Submit"></div>
    </form>
    <div class="footer"><a href="adminfunctions.php">Go Back</a></div>
</body>
</body>
</html>