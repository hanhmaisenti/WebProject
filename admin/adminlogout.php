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
    <?php include '../common/header.html';?>
</head>

<body>
    <div class="container">   
        <div class="jumbotron">
            <h1>Thanks for Stopping by</h1>
            <h4>You have been logged out</h4>
        </div>    
        <div>
            <a href="index.php">Home</button></a>
        </div>
    </div>
</body>
</html>
