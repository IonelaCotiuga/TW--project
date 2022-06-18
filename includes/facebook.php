<?php
 require_once("../controllers/facebookController.php");
 require_once("../views/imageView.php");

 $facebook = new FacebookController();

if(isset($_GET['code'])){
  $accessToken = $facebook->getAccessToken($_GET['code']);

  setcookie("facebook", $accessToken, time() + (60 * 60), "/");
  
}

header("location: ../profile/#facebook");
?>
