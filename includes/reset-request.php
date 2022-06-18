<?php
    if(isset($_POST["reset-request-submit"])){
        $selector = bin2hex(random_bytes(8)); //generates 8 bytes; 
        $token = random_bytes(32);

        $url = "https://localhost/MPic/password/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
        
        $expires = date("U") + 1800;

        require 'database.php';
        require 'config.php';

        $userEmail = $_POST["email"];

        $sql = "DELETE FROM pwdreset WHERE pwdResetEmail=?";
        $stmt = mysqli_stmt_init($dbh);
        if(!$mysqli_stmt_prepare($stmt, $sql)){
            echo "There was an error!";
            exit();
        }else{
            mysql_stmt_bind_param($stmt, "s", $userEmail);
            mysqli_stmt_execute($stmt);
        }

        $sql = "INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";

        $stmt = mysqli_stmt_init($dbh);
        if(!$mysqli_stmt_prepare($stmt, $sql)){
            echo "There was an error!";
            exit();
        }else{
            $hashedToken = password_hash($token, PASSWORD_DEFAULT);
            mysql_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
            mysqli_stmt_execute($stmt);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($dbh);

        $to = $userEmail;
        $subject = 'Reset your password for MPic';
        $message = '<p> We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email. </p>';
        $message .= '<p> Here is your password reset link: </br>';
        $message .= '<a = href="' . $url . '">' . $url . '</a><p>';

        $headers = "From: mpic <avarvareib@gmail.com>\r\n";
        $headers .= "Reply-To: avarvareib@gmail.com\r\n";
        $headers .= "Content-type: text/html\r\n";

        mail($to, $subject, $message, $headers);

        header("Location: ../index.php?reset=success");

    }else{
        header("location: ../login");
    }
?>