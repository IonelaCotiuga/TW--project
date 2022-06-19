<?php

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';

  

  $mail = new PHPMailer(true);

if(isset($_POST["reset-request-submit"])){
    $selector = substr(md5(rand()), 0, 8);
    $token = substr(md5(rand()), 0, 32);

    $url = "https://localhost/MPic/password/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 1800;

    $userEmail = $_POST["email"];

    require "../models/database.php";

    $db = new DBHandler();
    $dbh = $db->connect();

    $sql = "DELETE FROM pwdreset WHERE pwdResetEmail=?";
    $stmt = $dbh->prepare($sql);
    if(!$stmt->execute(array($userEmail)))
    {
      echo "There was an error!";
      exit();
    }

    $sql = "INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
    $stmt = $dbh->prepare($sql);
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    if(!$stmt->execute(array($userEmail, $selector, $hashedToken, $expires)))
    {
      echo "There was an error!";
      exit();
    }

    $stmt = null;

    try{
        //Server settings
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'proiecttw9@gmail.com';
      $mail->Password = 'vtremeyfhfgeboph';
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
      // $mail->SMTPAutoTLS = true;

      //Recipients
      $mail->setFrom('proiecttw9@gmail.com', 'MPic');
      $mail->addAddress($userEmail);
      // $mail->addReplayTo('no-reply@gmail.com', 'No reply');

      //Content
      $mail->isHTML(true);
      $mail->Subject = 'Reset your password for MPic';
      $mail->Body = '<p> We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email. </p>';
      $mail->Body .= '<p> Here is your password reset link: </br>';
      $mail->Body .= '<a = href="' . $url . '">' . $url . '</a><p>';
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      $mail->send();
      echo 'Message has been sent';
    } catch(Exception $e){
      echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
    

    // $to = $userEmail;
    // $subject = 'Reset your password for MPic';
    // $message = '<p> We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email. </p>';
    // $message .= '<p> Here is your password reset link: </br>';
    // $message .= '<a = href="' . $url . '">' . $url . '</a><p>';
    //
    // $headers = "From: mpic <avarvareib@gmail.com>\r\n";
    // $headers .= "Reply-To: avarvareib@gmail.com\r\n";
    // $headers .= "Content-type: text/html\r\n";
    //
    // mail($to, $subject, $message, $headers);

    //echo $url;

    header("Location: ../index.php?reset=success");

}else{
    header("location: ../login");
}
?>
