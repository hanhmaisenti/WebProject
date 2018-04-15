<?php
// Include adminconfig file. This effectively takes the code and sticks it here!

require '../common/db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <title>Admin Login</title>   
    <?php include '../common/header.html';?>

    <!-- Custom styles for this template -->
    <link href="../css/custom.css" rel="stylesheet">
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['login']))
    { //user logging in
        //we use require as its essentially adds the php to this part
        require './adminlogin.php';
    } elseif (isset($_POST['hashtool']))
    {
        header("location: admingeneratehash.php");
    } elseif (isset($_POST['emailtest']))
    {
        header("location: sendmail_test.php");
    }
}
?>

<body>
    <div class="container">   
        <div class="jumbotron">
            <h1>Interview Candidate Administration portal<br>Admin Login</h1>
            <h4>Please sign in for Admin Functions</h4> 
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
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Sign in</button>
        </form>

        <!--Separate tool for generating the Hash for first time Admins!-->
        <form class="form-signin outline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1 class="h3 mb-3 font-weight-normal">Other Tools</h1> 
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="hashtool">Generate Hash ToolSign in</button>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="emailtest">Send Test Email</button>
            <p><a href="../index.php">link to candidate site</a></p>
        </form>  
    </div>
</body>
</html>
