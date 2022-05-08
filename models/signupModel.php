<?php
class SignupModel extends DBHandler
{
  protected function checkUser($username, $email)
  {
    $stmt = $this->connect()->prepare("SELECT username FROM users WHERE lower(username) = ? OR email = ?;");

    if(!$stmt->execute(array(strtolower($username), $email)))
    {
      $stmt = null;
      header("location: ../signup?error=sql_statement_failed");
      exit();
    }

    if($stmt->rowCount() > 0)
      return false;
    return true;
  }

  protected function setUser($username, $email, $password)
  {
    $stmt = $this->connect()->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?);");

    $encodedPassword = password_hash($password, PASSWORD_DEFAULT);

    if(!$stmt->execute(array($username, $email, $encodedPassword)))
    {
      $stmt = null;
      header("location: ../signup?error=sql_statement_failed");
      exit();
    }

    $stmt = null;
  }
}
?>
