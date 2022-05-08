<?php
class LoginModel extends DBHandler
{
  protected function getUser($username, $password)
  {
    $stmt = $this->connect()->prepare("SELECT password FROM users WHERE lower(username) = ? OR email = ?;");

    if(!$stmt->execute(array($username, $username)))
    {
      $stmt = null;
      header("location: ../login?error=sql_statement_failed");
      exit();
    }

    if($stmt->rowCount() == 0)
    {
      $stmt = null;
      header("location: ../login?error=wrong_user");
      exit();
    }

    $encodedPassword = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $checkPassword = password_verify($password, $encodedPassword[0]["password"]);

    if(!$checkPassword)
    {
      $stmt = null;
      header("location: ../login?error=wrong_password");
      exit();
    }
    else
    {
      $stmt = $this->connect()->prepare("SELECT * FROM users WHERE lower(username) = ? OR email = ? AND password = ?;");

      if(!$stmt->execute(array($username, $username, $encodedPassword[0]["password"])))
      {
        $stmt = null;
        header("location: ../login?error=sql_statement_failed");
        exit();
      }

      if($stmt->rowCount() == 0)
      {
        $stmt = null;
        header("location: ../login?error=wrong_user");
        exit();
      }

      $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

      session_start();
      $_SESSION["userid"] = $user[0]["id"];
      $_SESSION["username"] = $user[0]["username"];
      $_SESSION["email"] = $user[0]["email"];
    }

    $stmt = null;
  }
}
?>
