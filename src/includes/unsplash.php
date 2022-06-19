<?php
require_once("../controllers/unsplashController.php");

$unsplash = new UnsplashController();
if(isset($_GET["code"]))
{
  $bearerToken = $unsplash->getBearerToken($_GET["code"]);

  setcookie("unsplash", $bearerToken, time() + (60 * 60), "/");
}

header("location: ../profile#unsplash");
?>
