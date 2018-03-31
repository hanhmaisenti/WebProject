<?php
/* Displays all error messages */

session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Error</title>
<?php include '../css/css.html';?>
</head>
<body>
<div>
    <h1>Error</h1>
    <p>
    <?php 
    if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ): 
        echo $_SESSION['message'];    
    else:
        header( "location: index.php" );
    endif;
    ?>
    </p>     
    <p><a href="index.php">Home</a></p>
</div>
</body>
</html>
