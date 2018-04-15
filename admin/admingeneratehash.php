<?php
/* Displays all error messages */

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HASH Generator</title>
    <?php include '../common/header.html';?>
</head>

<?php
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //print_r($_POST); die;
    if (isset($_POST['hashsubmit'])) { //
        // Check if password is empty
        $password = trim($_POST['password']);
        $HashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $y="Your supplied password\n".$password."\n\nHash to add the the SQL database:\n".$HashedPassword."\n\nPassword_Verify:".password_verify($password,$HashedPassword);
    }
}
?>

<body>

    <div class="container">   
        <div class="jumbotron">
            <h1>Hash Generator<br>Please enter the password you want to hash</h1>
        </div>    
    
        <form class="form-signin" method="post">  
            <div class="form-label-group">
                <input type="text" name="password" id="password" class="form-control" placeholder="Password" required autofocus>
                <label for="password">Password</label>
            </div>

            <div>
                <button class="btn btn-lg btn-primary" type="submit" name="hashsubmit">Submit</button>
            </div>
        </form>
        <div class="container">      
            <textarea id='myText' rows="10" class="form-control" style="min-width: 100%"><?php echo $y; ?></textarea>
            <label>Results</label>
        </div>
        <div>
            <p><a href="../index.php">Go Back</a></p>
        </div>
    </div>
</body>
</html>

