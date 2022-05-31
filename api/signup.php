<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../models/database.php");
include_once("../models/signupModel.php");
include_once("../controllers/signupController.php");

$data = json_decode(file_get_contents("php://input"));
$username = trim($data->username);
$email = strtolower(trim($data->email));
$password = $data->password;

$signup = new SignupController($username, $email, $password);
$signupResponse = $signup->signupUser();
if($signupResponse == 1)
{
  http_response_code(201);
  echo json_encode(array("message" => "Successfully signed up."));
}
else if($signupResponse == 0)
{
  http_response_code(500);
  echo json_encode(array("message" => "Something went wrong. Try again later."));
}
else if($signupResponse == -1)
{
  http_response_code(400);
  echo json_encode(array("message" => "All fields are required."));
}
else if($signupResponse == -2)
{
  http_response_code(400);
  echo json_encode(array("message" => "Username can only contain letters and numbers."));
}
else if($signupResponse == -3)
{
  http_response_code(422);
  echo json_encode(array("message" => "User already exists."));
}
