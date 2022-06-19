<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$image = $_POST["image"];

if(!empty($image))
{
  require_once("../controllers/imageController.php");

  $contr = new ImageController($image);
  $contr->uploadImage();

  echo "new_image";
  http_response_code(200);
}
else
{
  echo "error";
  http_response_code(400);
}
?>
