<?php
require_once("../models/database.php");
require_once("../models/passwordModel.php");

$pwdModel = new PasswordModel();

if(isset($_POST["reset-password-submit"])){
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-repeat"];

    if(empty($password) || empty($passwordRepeat)){
        header("location: ../password/create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&error=empty_input");
        exit();
    }else if($password != $passwordRepeat){
        header("location: ../password/create-new-password.php?selector=" . $selector . "&validator=" . $validator . "&error=unmatched_passwords");
        exit();
    }

    $currentDate = date("U"); //standard date time

    $row = $pwdModel->checkRequest($selector);
    if($row == 0)
    {
      echo "There was an error!";
      exit();
    }
    elseif($row == -1)
    {
      echo "You need to re-submit your reset request.";
      exit();
    }

    $tokenBin = hex2bin($validator);
    $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

    if($tokenCheck === false)
    {
      echo "You need to re-submit your reset request.";
      exit();
    }
    elseif($tokenCheck === true)
    {
      $tokenEmail = $row["pwdResetEmail"];

      $result = $pwdModel->resetPassword($tokenEmail, $password);
      if($result == 0)
      {
        echo "There was an error!";
        exit();
      }

      header("location: ../login?newpwd=passwordupdated");
    }
}
else
{
  header("location: ../index.php");
}
?>
