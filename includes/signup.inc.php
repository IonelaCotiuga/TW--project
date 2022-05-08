<?php
if(isset($_POST["submit"]))
{
  //collecting the data
  $username = trim($_POST["username"]);
  $email = strtolower(trim($_POST["email"]));
  $password = $_POST["password"];
  $passwordr = $_POST["passwordr"];

  //instatiating the controller object
  include('../models/database.php');
  include('../models/signupModel.php');
  include('../controllers/signupController.php');
  $signup = new SignupController($username, $email, $password, $passwordr);

  //signing up the user
  $signup->signupUser();

  //return
  header("location: ../signup?error=none");
}
else
{
  header("location: ../index.php");
  exit();
}
?>
