<?php
// Include adminconfig file. This effectively takes the code and sticks it here!

require 'common/db.php';
 session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>candidate Login</title>
    <?php include 'common/header.html';?>
    
    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">
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
    <div class="container">   
        <div class="jumbotron">
            <h1>Hanh Maisentis Interview Portal<br>Candidate Login Page</h1>
            <h4>Please fill in your credentials to login</h4>
            <div><?php
            // Display any persistent messages only once.
            if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            // Don't annoy the user with more messages upon page refresh
            unset($_SESSION['message']);
            }
            ?></div>
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
            <a href="candidateforgot.php">I forgot my password</a>
        </form>
    </div>
</body>
</html>