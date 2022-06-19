<?php
class PasswordModel extends DBHandler
{
  public function checkRequest($selector)
  {
    $stmt = $this->connect()->prepare("SELECT * FROM pwdreset WHERE pwdResetSelector=?;");
    if(!$stmt->execute(array($selector)))
    {
      $stmt = null;
      return 0;
    }

    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$row[0])
      return -1;

    return $row[0];
  }

  public function resetPassword($tokenEmail, $password)
  {
    //check if user exists
    $stmt = $this->connect()->prepare("SELECT * FROM users WHERE email=?;");
    if(!$stmt->execute(array($tokenEmail)))
    {
      $stmt = null;
      return 0;
    }

    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$row[0])
      return -1;

    //update password
    $stmt = $this->connect()->prepare("UPDATE users SET password=? WHERE email=?;");
    $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
    if(!$stmt->execute(array($newPwdHash, $tokenEmail)))
    {
      $stmt = null;
      return 0;
    }

    //delete reset token after use
    $stmt = $this->connect()->prepare("DELETE FROM pwdreset WHERE pwdResetEmail=?;");
    if(!$stmt->execute(array($tokenEmail)))
    {
      $stmt = null;
      return 0;
    }

    return 1;
  }

  public function createToken($userEmail, $selector, $token, $expires)
  {
    $stmt = $this->connect()->prepare("DELETE FROM pwdreset WHERE pwdResetEmail=?;");
    if(!$stmt->execute(array($userEmail)))
    {
      $stmt = null;
      return 0;
    }

    $stmt = $this->connect()->prepare("INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);");
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    if(!$stmt->execute(array($userEmail, $selector, $hashedToken, $expires)))
    {
      $stmt = null;
      return 0;
    }

    return 1;
  }
}
?>
