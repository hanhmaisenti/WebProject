<?php
/* Log out process, unsets and destroys session variables */

session_start();
session_unset();
session_destroy();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Error</title>
  <?php include ('../css/css.html');?>
</head>

<body>
<h1>Thanks for stopping by</h1>    
<div class="formfunctions">
    <p><?= 'You have been logged out!'; ?></p>
    <a href="index.php">Home</button></a>
</div>
</body>
</html>
