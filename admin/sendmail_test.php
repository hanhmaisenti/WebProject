<?php
    $to      = "hanh.maisenti@outlook.com";
    $subject = "Password Reset Link ( Interview Portal )";
    $message_body = "blah blah";
    $headers = "from: hanh.maisenti@outlook.com";
    if (mail($to, $subject, $message_body,$headers)) {
        echo "WORKED!";
    } else {
        echo "DIDNT WORK";
    }
?>
