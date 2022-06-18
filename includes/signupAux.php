 <?php
if(isset($_POST["submit"]))
{
  if($_POST["password"] != $_POST["passwordr"])
  {
    header("location: ../signup?error=unmatched_passwords");
    exit();
  }

  include_once("../api/signup.php");
  include_once("../util/config.php");

  $body = array(
    "username" => $_POST["username"],
    "email" => $_POST["email"],
    "password" => $_POST["password"]
  );
  $url = $apiUrl . "signup.php";
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

  if($message == "Successfully signed up.")
  {
    header("location: ../signup?error=none");
    exit();
  }
  else if($message == "Something went wrong. Try again later.")
  {
    header("location: ../signup?error=sql_statement_failed");
    exit();
  }
  else if($message == "All fields are required.")
  {
    header("location: ../signup?error=empty_input");
    exit();
  }
  else if($message == "Username can only contain letters and numbers.")
  {
    header("location: ../signup?error=invalid_username");
    exit();
  }
  else if($message == "User already exists.")
  {
    header("location: ../signup?error=username_taken");
    exit();
  }
}
else
{
  header("location: ../index.php");
  exit();
}
?>
