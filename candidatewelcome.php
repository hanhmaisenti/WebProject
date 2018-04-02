<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: candidatelogin.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Welcome/title>
  <?php include 'css/css.html'; ?>
</head>
<body>
    <div>
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION['fname']); ?></b>. Welcome to our site.</h1>
    </div>
    <p><a href="candidatelogout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
</body>
</html>