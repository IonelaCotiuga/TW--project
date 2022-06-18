<?php
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

    echo $url;

    //header("Location: ../index.php?reset=success");

}else{
    header("location: ../login");
}
?>
