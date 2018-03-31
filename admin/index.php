<?php
// Include adminconfig file. This effectively takes the code and sticks it here!

require 'admindb.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>   
    <?php include ('../css/css.html');?>
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) { //user logging in
        //we use require as its essentially adds the php to this part
        require './adminlogin.php';
        
    } elseif (isset($_POST['hashtool'])) {
        header("location: admingeneratehash.php");
    } elseif (isset($_POST['emailtest'])) {
        header("location: sendmail_test.php");
    }
}
?>

<body>
    <h1>Interview Candidate Administration portal<br>Admin Login</h1>


    <!--this posts back to itself at correct server location -->
    <form class="login" action="index.php" method="post">
        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
            <span><?php echo $email_err; ?></span> <!--we get the error message displayed after the box if its empty -->
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password">
            <span><?php echo $password_err; ?></span> <!--we get the error message displayed after the box if its empty -->
        </div>
        <div class="actions">
            <input type="submit" name="login" value="Login"></input>
        </div>
    </form>
    <div class="footer">Please fill in your credentials to login to the Admin Portal</div>

    <!--Separate tool for generating the Hash for first time Admins!-->
    <form class="login" action="index.php" method="post" accept-charset="utf-8">
        <div class="actions">
            <input type="submit" name="hashtool">Generate Hash Tool</input>
            <input type="submit" name="emailtest">Send Test Email</input>
        </div>
    </form>
    <div class="footer"></div><a href="../index.php">link to candidate site</a></div>

</body>
</html>
