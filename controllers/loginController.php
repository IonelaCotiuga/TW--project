<?php
require_once("../models/loginModel.php");

class LoginController extends LoginModel
{
  private $username;
  private $password;

  public function __construct($username, $password)
  {
    $this->username = $username;
    $this->password = $password;
  }

  public function loginUser()
  {
    if($this->emptyInput() == true)
      return -1;

    return $this->getUser($this->username, $this->password);
  }

  private function emptyInput()
  {
    if(empty($this->username) || empty($this->password))
      return true;
    return false;
  }
}
?>
