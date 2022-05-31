<?php
class SignupModel extends DBHandler
{
  protected function checkUser($username, $email)
  {
    $stmt = $this->connect()->prepare("SELECT username FROM users WHERE lower(username) = ? OR email = ?;");

    if(!$stmt->execute(array(strtolower($username), $email)))
    {
      $stmt = null;
      return 0;
    }

    if($stmt->rowCount() > 0)
      return -1;
    return 1;
  }

  protected function setUser($username, $email, $password)
  {
    $stmt = $this->connect()->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?);");

    $encodedPassword = password_hash($password, PASSWORD_DEFAULT);

    if(!$stmt->execute(array($username, $email, $encodedPassword)))
    {
      $stmt = null;
      return 0;
    }

    $stmt = null;
    return 1;
  }
}
?>
