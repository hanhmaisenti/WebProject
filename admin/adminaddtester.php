<?php

/* Displays user information and some useful messages */
require '../candidatedb.php'; //Note we are using the Interview->candidate table now
session_start();

// Processing form data when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    // Define variables and initialize with empty values
    $email = $fname = $lname = $qtype = $password = $confirm_password ="";
    $email_err = $fname_err = $lname_err = $qtype_err = $password_err = $confirm_password_err = "";

    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        //this displays directly into the HTML
        $email_err = 'Please enter email';
    } else {

        //attempt to discover if the email has already been taken
        //must protect against sql injection
        $email = $mysqli->escape_string($_POST['email']); 
        $result = $mysqli->query("SELECT * FROM candidate WHERE email='$email'") or die($mysqli->error());
        
        if ( $result->num_rows == 0 ) {
            //this is good. email not take

            // Validate first name
            if(empty(trim($_POST['fname']))){
                $fname_err = "Please enter a First Name";     
            } else {
                $fname = trim($_POST['fname']); //Valid First Name
            }

            // Validate Last name
            if(empty(trim($_POST['lname']))){
                $lname_err = "Please enter a Last Name";     
            } else {
                $lname = trim($_POST['lname']); //Valid Last Name
            }

            // Validate Question Group
            if(empty(trim($_POST['questiontype']))){
                $qtype_err = "Please enter a Question Type";     
            } else {
                $qtype = trim($_POST['questiontype']); //Valid Question Type
            }
            
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
            if(empty($email_err) && empty($fname_err) && empty($lname_err) && empty($qtype_err) && empty($password_err)  && empty($confirm_password_err))
            {
                //Its really all good. Proceed to add the person
                //must protect against sql injection
                $email = $mysqli->escape_string($_POST['email']);
                $fname = $mysqli->escape_string($_POST['fname']);
                $lname = $mysqli->escape_string($_POST['lname']);
                $qtype = $mysqli->escape_string($_POST['questiontype']);
                $password = $mysqli->escape_string(password_hash(trim($_POST['password']), PASSWORD_BCRYPT));
                //hash is there just incase we need to validate email addresses later
                $hash = $mysqli->escape_string( md5( rand(0,1000) ) );
                
                $sql = "INSERT INTO candidate (email, first_name, last_name, questiontype, password, hash) VALUES ('$email','$fname','$lname','$qtype','$password','$hash')";
                if ( $mysqli->query($sql) ){
                    
                    //Ask if we need to generate an email or not
                    
                    //Now proceed to send the activation email to the candidate
                    $_SESSION['message'] =
                             "Confirmation link has been sent to $email, please verify
                             your account by clicking on the link in the message!";
            
                    // Send registration confirmation link (verify.php)
                    $to      = $email;
                    $subject = 'Account Verification ( Interview Assesment Portal )';
                    $headers = "from: francismiles1@gmail.com";
                    $message_body = '
                    Hello '.$fname.',
            
                    Thank you for signing up!
            
                    Please click this link to activate your account:
            
                    http://localhost/WebProject/verify.php?email='.$email.'&hash='.$hash;  
            
                    mail( $to, $subject, $message_body );
                    
                    if (mail($to, $subject, $message_body, $headers)) {
                        echo "<p>Success</p>";
                        header("location: admindisplaytesters.php");
                    } else {
                        $_SESSION['message'] = 'Sending Mail failed!';
                        header("location: adminerror.php");
                    }               
                } else {
                    //SQL INSERT didnt work
                    $_SESSION['message'] = 'Candidate Registration failed!';
                    header("location: adminerror.php");
                }
            }
        } else {
            //This is not good. Email address already taken
            $_SESSION['message'] = "The email is already registered!";
            header("location: adminerror.php");
        }
    }
}
?>

<html>
<head>
	<title>Add Candidate</title>
    <?php include '../css/css.html';?>
</head>
<body>
	<h1>Add Candidate - To Database name:<?php echo DB_NAME; ?></h1>

    <?php
    // Check if user is logged in using the session variable
    if ( $_SESSION['logged_in'] != 1 ) {
        $_SESSION['message'] = "You must log in before using this tool!";
        header("location: adminerror.php");    
    }
    ?>    

    <h1>Add Admin</h1>
    <!--this posts back to itself at correct server location -->
    <form class="login" action="adminaddtester.php" method="post">
        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
            <span><?php echo $email_err; ?></span> <!--we get the error message displayed after the box if its empty -->
        </div> 
        <div>
            <label>First Name</label>
            <input type="text" name="fname" value="<?php echo $fname; ?>">
            <span><?php echo $confirm_password_err; ?></span> <!--we get the error message displayed after the box if its empty -->
        </div>   
        <div>
            <label>Last Name</label>
            <input type="text" name="lname" value="<?php echo $lname; ?>">
            <span><?php echo $lname_err; ?></span> <!--we get the error message displayed after the box if its empty -->
        </div>  
        <div>
            <label>Please select the type of question</label>
            <select name="questiontype">
                <option value="easy">Easy Question</option>
                <option value="medium">Medium Question</option>
                <option value="difficult">Difficult Question</option>
            </select>
            <span><?php echo $qgroup_err; ?></span> <!--we get the error message displayed after the box if its empty -->
        </div>                     
        <div>
            <label>Password</label>
            <input type="password" name="password" value="<?php echo $password; ?>">
            <span><?php echo $password_err; ?></span> <!--we get the error message displayed after the box if its empty -->
        </div>
        <div>
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
            <span><?php echo $confirm_password_err; ?></span> <!--we get the error message displayed after the box if its empty -->
        </div>            
        <div class="actions">
            <input type="submit" value="Submit">
        </div>
        <p><a href="adminfunctions.php">Go Back</a></p>
    </form>
</body>
</body>
</html>