<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../controllers/jwtController.php");
require_once("../controllers/imageController.php");

$headers = apache_request_headers();
if(!isset($headers["Authorization"]))
{
  http_response_code(400);
  echo json_encode(array("message" => "Bearer token is required."));
}
else
{
  $token = explode(" ", trim($headers["Authorization"]))[1];
  if(JWTController::validateToken($token) == false)
  {
    http_response_code(401);
    echo json_encode(array("message" => "You don't have access to this resource."));
  }
  else
  {
    $jwt = JWTController::getPayload($token);

    http_response_code(200);
    echo ImageController::getAllImages($jwt["id"]);
  }
}
