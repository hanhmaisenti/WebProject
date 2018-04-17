<?php

/* Displays user information and some useful messages */
require '../common/db.php';
session_start();

// Processing form data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{ 
    // Define variables and initialize with empty values
    $email = $password = $confirm_password ="";
    $email_err = $password_err = $confirm_password_err = "";

    // Check if email is empty
    if(empty(trim($_POST["email"])))
    {
        //this displays directly into the HTML
        $email_err = 'Please enter email.';
    } 
    else 
    {
        //attempt to discover if the email address is already taken
        //must protect against sql injection
        $email = $mysqli->escape_string($_POST['email']); 
        $result = $mysqli->query("SELECT * FROM admin WHERE email='$email'") or die($mysqli->error());
        
        if ( $result->num_rows == 0 )
        {
            //this is good. Email address not take

            // Validate password
            if(empty(trim($_POST['password'])))
            {
                $password_err = "Please enter a password.";     
            } elseif(strlen(trim($_POST['password'])) < 6)
            {
                $password_err = "Password must have at least 6 characters.";
            } 
            else
            {
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
    <?php include '../common/header.html';?>

    <!-- Custom styles for this template -->
    <link href="../css/custom.css" rel="stylesheet">
</head>

<body>
    <div class="container">   
        <div class="jumbotron">
            <h1>Add Admin - To Database name:<?php echo DB_NAME; ?></h1>
        </div>
        <div>
            <?php
            // Check if user is logged in using the session variable
            if ( $_SESSION['logged_in'] != 1 )
            {
                $_SESSION['message'] = "You must log in before using this tool!";
                header("location: adminerror.php");    
            }
            ?>    
        </div>
        <!--this posts back to itself at correct server location -->
        <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">  
            <div class="form-label-group">
                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                <label for="inputEmail">Email address</label>
                <span><?php echo $email_err; ?></span> <!--we get the error message displayed after the box if its empty -->
            </div>

            <div class="form-label-group">
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
                <span><?php echo $password_err; ?></span> <!--we get the error message displayed after the box if its empty -->
            </div>

            <div class="form-label-group">
                <input type="password" name="confirm_password" id="confirmPassword" class="form-control" placeholder="Password" required>
                <label for="confirmPassword">Confirm Password</label>
                <span><?php echo $confirm_password_err; ?></span> <!--we get the error message displayed after the box if its empty -->
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Submit</button>
        </form>
        <p><a href="adminfunctions.php">Go Back</a></p>
    </div>
</body>
</body>
</html>