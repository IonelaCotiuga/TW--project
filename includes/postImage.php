<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

require_once("../controllers/imgurController.php");

$image = $_POST["image"];

if(!empty($image))
{
  if(!isset($_COOKIE["imgur"]))
  {
    http_response_code(403);
    exit();
  }

  $imgur = new ImgurController();
  echo $imgur->uploadImage($image, $_COOKIE["imgur"]);

  http_response_code(200);
}
else
{
  http_response_code(400);
}
?>
