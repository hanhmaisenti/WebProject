<?php
/* Displays all error messages */

session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Error</title>
<?php include 'common/header.html';?>
</head>
<body>
    <div class="container">   
        <div class="jumbotron">
            <h1>Error</h1>
            <div>
                <?php 
                if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ): 
                    echo $_SESSION['message'];    
                else:
                    header( "location: index.php" );
                endif;
                ?>    
            </div>
        </div>
        <div>
            <a href="index.php">Home</a>
        </div>
    </div>
</body>
</html>
