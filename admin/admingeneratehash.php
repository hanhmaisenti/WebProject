<?php
/* Displays all error messages */

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HASH Generator</title>
    <?php include ('../css/css.html'); ?>
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
    <h1>Hash Generator<br>Please enter the password you want to hash</h1>

    <form class="login" method="post">
        <div>
            <label>Password</label>
            <input type="text" name="password" class="form-control">
        </div>
        <div>
            <button type="submit" name="hashsubmit">Submit</button>
        </div>

        <textarea id='myText' rows="10" cols="120"><?php echo $y; ?></textarea>
    </form>
    <a href="./index.php">Go Back</a>
   
</body>
</html>