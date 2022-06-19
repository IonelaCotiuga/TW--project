<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';
  $mail = new PHPMailer(true);

  require_once("../models/database.php");
  require_once("../models/passwordModel.php");
  $pwdModel = new PasswordModel();

if(isset($_POST["reset-request-submit"])){
    require_once("../util/config.php");

    $selector = substr(md5(rand()), 0, 8);
    $token = substr(md5(rand()), 0, 32);
    $url = $baseUrlSecure . "password/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = date("U") + 1800;

    $userEmail = $_POST["email"];

    $result = $pwdModel->createToken($userEmail, $selector, $token, $expires);
    if($result == 0)
    {
      echo "There was an error!";
      exit();
    }

    try{
        //Server settings
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'proiectmpic@gmail.com';
      $mail->Password = 'quopbhajldvhjxdk';
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
      // $mail->SMTPAutoTLS = true;

      //Recipients
      $mail->setFrom('proiectmpic@gmail.com', 'MPic');
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

    header("location: ../index.php?reset=success");

}else{
    header("location: ../login");
}
?>
