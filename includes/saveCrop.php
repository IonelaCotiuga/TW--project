<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$image = $_POST["image"];

if(!empty($image))
{
  include("../models/database.php");
  include("../models/imageModel.php");
  include("../controllers/imageController.php");

  $contr = new ImageController($image);
  $contr->saveCrop();

  echo $image;
  http_response_code(200);
}
else
{
  http_response_code(400);
}
?>
