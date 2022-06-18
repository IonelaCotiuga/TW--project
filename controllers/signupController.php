<?php
require_once("../models/signupModel.php");

class SignupController extends SignupModel
{
  private $username;
  private $email;
  private $password;

  public function __construct($username, $email, $password)
  {
    $this->username = $username;
    $this->email = $email;
    $this->password = $password;
  }

  public function signupUser()
  {
    if($this->emptyInput() == true)
      return -1;
    if($this->invalidUser() == true)
      return -2;
    if($this->userExists() == true)
      return -3;

    return $this->setUser($this->username, $this->email, $this->password);
  }

  private function emptyInput()
  {
    if(empty($this->username) || empty($this->email) || empty($this->password))
      return true;
    return false;
  }

  private function invalidUser()
  {
    if(!preg_match("/^[a-zA-Z0-9]*$/", $this->username))
      return true;
    if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
      return true;
    return false;
  }

  private function userExists()
  {
    if($this->checkUser($this->username, $this->email) == -1)
      return true;
    return false;
  }
}
?>
