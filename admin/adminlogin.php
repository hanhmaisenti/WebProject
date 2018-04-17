<?php
/* User login process, checks if user exists and password is correct */

// Check if email is empty
if(empty(trim($_POST["email"])))
{
    $email_err = 'Please enter email.';
} 
else
{
    $email = trim($_POST["email"]);
}

// Check if password is empty
if(empty(trim($_POST['password'])))
{
    $password_err = 'Please enter your password.';
} 
else
{
    $password = trim($_POST['password']);
}

// Validate credentials
if(empty($email_err) && empty($password_err))
{
    // Escape email to protect against SQL injections
    $email = $mysqli->escape_string($_POST['email']);
    $result = $mysqli->query("SELECT * FROM admin WHERE email='$email'");

    if ( $result->num_rows == 0 )
    { // User doesn't exist
        //set a session message for the error screen
        $_SESSION['message'] = "User with that email doesn't exist!";
        header("location: adminerror.php");
    }
    else
    {
        // User exists
        $user = $result->fetch_assoc();

        if ( password_verify($_POST['password'], $user['password']) ) {

            //remember this value. It will be used in the next sessions
            $_SESSION['email'] = $user['email'];

            // This is how we'll know the user is logged in
            $_SESSION['logged_in'] = true;

            header("location: adminfunctions.php");

        }
        else
        {
            $_SESSION['message'] = "You have entered wrong password, try again!";
            header("location: adminerror.php");
        }
    }
}
