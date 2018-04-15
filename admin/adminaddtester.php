<?php

/* Displays user information and some useful messages */
require '../common/db.php'; //Note we are using the Interview->candidate table now
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
    <?php include '../common/header.html';?>
    
    <!-- Custom styles for this template -->
    <link href="../css/custom.css" rel="stylesheet">    
</head>

<body>
    <div class="container">   
        <div class="jumbotron">
            <h1>Add Candidate - To Database name:<?php echo DB_NAME; ?></h1>
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
            <!--EMAIL ADDRESS-->
            <div class="form-label-group">
                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                <label for="inputEmail">Email address</label>
                <span><?php echo $email_err; ?></span> <!--we get the error message displayed after the box if its empty -->
            </div>

            <!--FIRST NAME-->
            <div class="form-label-group">
                <input type="text" name="fname" id="firstname" class="form-control" placeholder="First Name" required>
                <label for="firstname">First Name</label>
                <span><?php echo $fname_err; ?></span> <!--we get the error message displayed after the box if its empty -->
            </div>

            <!--LAST NAME-->
            <div class="form-label-group">
                <input type="text" name="lname" id="lastname" class="form-control" placeholder="Last Name" required>
                <label for="lastname">Last Name</label>
                <span><?php echo $lname_err; ?></span> <!--we get the error message displayed after the box if its empty -->
            </div>

            <!--QUESTION TYPE-->
            <div class="form-label-group">

                <select class="selectpicker form-control" name="questiontype" id="questiontype" data-style="btn-info">
                    <option value="easy">Easy Questions</option>
                    <option value="medium">Medium Questions</option>
                    <option value="difficult">Difficult Questions</option>
                </select>
                <!--label for="questiontype">Please select the type of question group</label-->
                <span><?php echo $qgroup_err; ?></span> <!--we get the error message displayed after the box if its empty -->
            </div>                        

            <!--PASSWORD-->
            <div class="form-label-group">
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
                <span><?php echo $password_err; ?></span> <!--we get the error message displayed after the box if its empty -->
            </div>

            <!--CONFIRM PASSWORD-->
            <div class="form-label-group">
                <input type="password" name="confirm_password" id="ConfirmPassword" class="form-control" placeholder="Password" required>
                <label for="ConfirmPassword">Confirm Password</label>
                <span><?php echo $confirm_password_err; ?></span> <!--we get the error message displayed after the box if its empty -->
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Submit</button>
        </form>
    </div>
</body>
</html>