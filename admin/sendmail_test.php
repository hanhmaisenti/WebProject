<?php
    $to      = "tinytilly@gmail.com";
    $subject = "Password Reset Link ( Interview Portal )";
    $message_body = "blah blah";
    $headers = "from: tinytilly@gmail.com";
    if (mail($to, $subject, $message_body,$headers)) {
        echo "WORKED!";
    } else {
        echo "DIDNT WORK";
    }
?>
