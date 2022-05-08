<?php
require_once('../models/signupModel.php');

class SignupController extends SignupModel
{
  private $username;
  private $email;
  private $password;
  private $passwordr;

  public function __construct($username, $email, $password, $passwordr)
  {
    $this->username = $username;
    $this->email = $email;
    $this->password = $password;
    $this->passwordr = $passwordr;
  }

  public function signupUser()
  {
    if($this->emptyInput() == false)
    {
      header("location: ../signup?error=empty_input");
      exit();
    }
    if($this->invalidUser() == false)
    {
      header("location: ../signup?error=invalid_username");
      exit();
    }
    if($this->passwordMatch() == false)
    {
      header("location: ../signup?error=unmatched_passwords");
      exit();
    }
    if($this->userExists() == false)
    {
      header("location: ../signup?error=username_taken");
      exit();
    }

    $this->setUser($this->username, $this->email, $this->password);
  }

  private function emptyInput()
  {
    if(empty($this->username) || empty($this->email) || empty($this->password) || empty($this->passwordr))
      return false;
    return true;
  }

  private function invalidUser()
  {
    if(!preg_match("/^[a-zA-Z0-9]*$/", $this->username))
      return false;
    if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
      return false;
    return true;
  }

  private function passwordMatch()
  {
    if($this->password === $this->passwordr)
      return true;
    return false;
  }

  private function userExists()
  {
    if(!$this->checkUser($this->username, $this->email))
      return false;
    return true;
  }
}
?>
