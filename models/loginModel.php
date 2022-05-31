<?php
require_once("../controllers/jwtController.php");

class LoginModel extends DBHandler
{
  protected function getUser($username, $password)
  {
    $stmt = $this->connect()->prepare("SELECT * FROM users WHERE lower(username) = ? OR email = ?;");

    if(!$stmt->execute(array($username, $username)))
    {
      $stmt = null;
      return 0;
    }

    if($stmt->rowCount() == 0)
    {
      $stmt = null;
      return -2;
    }

    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $checkPassword = password_verify($password, $user[0]["password"]);

    if(!$checkPassword)
    {
      $stmt = null;
      return -3;
    }

    //generate jwt
    $jwt = new JWTController($user[0]["id"], $user[0]["username"], $user[0]["email"]);
    $jwtToken = $jwt->generateToken();

    return $jwtToken;
  }
}
?>
