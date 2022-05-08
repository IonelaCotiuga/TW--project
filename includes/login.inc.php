<?php
if(isset($_POST["submit"]))
{
  //collecting the data
  $username = strtolower(trim($_POST["username"]));
  $password = $_POST["password"];

  //instatiating the controller object
  include('../models/database.php');
  include('../models/loginModel.php');
  include('../controllers/loginController.php');
  $login = new LoginController($username, $password);

  //log the user in
  $login->loginUser();

  //return
  header("location: ../login?error=none");
}
else
{
  header("location: ../index.php");
  exit();
}
?>
