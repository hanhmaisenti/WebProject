<?php
    $to      = "francismiles1@gmail.com";
    $subject = "Password Reset Link ( Interview Portal )";
    $message_body = "blah blah";
    $headers = "from: francismiles1@gmail.com";
    if (mail($to, $subject, $message_body,$headers)) {
        echo "WORKED!";
    } else {
        echo "DIDNT WORK";
    }
?>