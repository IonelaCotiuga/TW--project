<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

require_once("../controllers/facebookController.php");
require_once("../controllers/imgurController.php");

$image = $_POST["image"];
$platform = $_POST["platform"];

if(!empty($image) && $platform == "facebook")
{
  $facebook = new FacebookController();

  http_response_code(200);
}
else if(!empty($image) && $platform == "imgur")
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
