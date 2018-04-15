<?php
/* Displays all error messages */

session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Error</title>
<?php include '../common/header.html';?>
</head>
<body>
<div>
    <h1>Error</h1>
    <div class="error">
        <?php 
        if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ): 
            echo $_SESSION['message'];    
        else:
            header( "location: index.php" );
        endif;
        ?>
    </div>     
    <div class="footer"><a href="index.php">Home</a></div>
</div>
</body>
</html>
