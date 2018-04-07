<?php
// Include adminconfig file. This effectively takes the code and sticks it here!

require 'candidatedb.php';
 session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>candidate Login</title>
    <?php include 'css/css.html';?>
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) { //user logging in
        //we use require as its essentially adds the php to this part
        require 'candidatelogin.php';   
    }
}
?>

<body>
    <h1>Hanh Maisentis Interview Portal<br>Candidate Login Page</h1>
    <div><?php
      // Display any persistent messages only once.
      if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        // Don't annoy the user with more messages upon page refresh
        unset($_SESSION['message']);
      }
    ?></div>
    <!--this posts back to itself at correct server location -->
    <form class="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>"> <!--PreFills email if already done -->
            <span><?php echo $email_err; ?></span> <!--we get the error message displayed after the box if its empty -->
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password">
            <span><?php echo $password_err; ?></span> <!--we get the error message displayed after the box if its empty -->
        </div>
        
        <div class="actions">
            <input type="submit" name="login" value="Login"> <a href="candidateforgot.php">I forgot my password</a>
        </div>
    </form>
    <div class="footer">Please fill in your credentials to login to the Candidate Portal</div>
</body>
</html>