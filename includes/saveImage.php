<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$image = $_POST["image"];
$type = $_POST["type"];

if(!empty($image))
{
  require_once("../controllers/imageController.php");

  $contr = new ImageController($image);
  $contr->saveImage($type);

  http_response_code(200);
}
else
{
  http_response_code(400);
}
?>
