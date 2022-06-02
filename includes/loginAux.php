<?php
if(isset($_POST["submit"]))
{
  include_once("../api/login.php");

  $body = array(
    "username" => $_POST["username"],
    "password" => $_POST["password"]
  );
  $url = "http://localhost/TW-Project/api/login.php";
  $ch = curl_init($url);
  $options = array(
    CURLOPT_POST => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json"
    ),
    CURLOPT_POSTFIELDS => json_encode($body)
  );

  curl_setopt_array($ch, $options);
  $response = curl_exec($ch);
  $message = json_decode($response, true)["message"];

  if($message == "Signed in successfully.")
  {
    setcookie("jwt", json_decode($response, true)["jwt"], time() + (60 * 60), "/");
    header("location: ../profile");
    exit();
  }
  else if($message == "Something went wrong. Try again later.")
  {
    header("location: ../login?error=sql_statement_failed");
    exit();
  }
  else if($message == "All fields are required.")
  {
    header("location: ../login?error=empty_input");
    exit();
  }
  else if($message == "User does not exist.")
  {
    header("location: ../login?error=wrong_user");
    exit();
  }
  else if($message == "Incorrect password.")
  {
    header("location: ../login?error=wrong_password");
    exit();
  }
}
else
{
  header("location: ../index.php");
  exit();
}
?>
