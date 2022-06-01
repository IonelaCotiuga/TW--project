<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$image = $_POST["image"];

if(!empty($image))
{
  require_once("../controllers/imageController.php");
  
  $contr = new ImageController($image);
  $contr->saveCrop();

  http_response_code(200);
}
else
{
  http_response_code(400);
}
?>
