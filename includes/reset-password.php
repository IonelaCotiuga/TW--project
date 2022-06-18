<?php
if(isset($_POST["reset-password-submit"])){
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-repeat"];

    if(empty($password) || empty($passwordRepeat)){
        header("location: ../password/create-new-password.php?newpwd=empty");
        exit();
    }else if($password != $passwordRepeat){
        header("location: ../password/create-new-password.php?newpwd=pwdnotsame");
        exit();
    }

    $currentDate = date("U"); //standard date time

    require "../models/database.php";

    $db = new DBHandler();
    $dbh = $db->connect();

    $sql = "SELECT * FROM pwdreset WHERE pwdResetSelector=?";
    $stmt = $dbh->prepare($sql);
    if(!$stmt->execute(array($selector)))
    {
      echo "There was an error!";
      exit();
    }

    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$row[0])
    {
      echo "You need to re-submit your reset request.";
      exit();
    }

    $tokenBin = hex2bin($validator);
    $tokenCheck = password_verify($tokenBin, $row[0]["pwdResetToken"]);

    if($tokenCheck === false)
    {
      echo "You need to re-submit your reset request.";
      exit();
    }
    elseif($tokenCheck === true)
    {
      $tokenEmail = $row[0]['pwdResetEmail'];
      $sql = "SELECT * FROM users WHERE email=?;";
      $stmt = $dbh->prepare($sql);
      if(!$stmt->execute(array($tokenEmail)))
      {
        echo "There was an error!";
        exit();
      }

      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if(!$row[0])
      {
        echo "There was an error!";
        exit();
      }

      $sql = "UPDATE users SET password=? WHERE email=?";
      $stmt = $dbh->prepare($sql);
      $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
      if(!$stmt->execute(array($newPwdHash, $tokenEmail)))
      {
        echo "There was an error!";
        exit();
      }

      $sql = "DELETE FROM pwdreset WHERE pwdResetEmail=?";
      $stmt = $dbh->prepare($sql);
      if(!$stmt->execute(array($tokenEmail)))
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
