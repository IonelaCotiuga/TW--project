<?php
require_once("../controllers/instagramController.php");

$instagram = new InstagramController();
if(isset($_GET["code"]))
{
  $accessToken = $instagram->getAccessToken($_GET["code"]);

  setcookie("instagram", $accessToken, time() + (60 * 60), "/");
}

header("location: ../profile/#instagram");
?>
