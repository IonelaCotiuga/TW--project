<?php
require_once("../controllers/unsplashController.php");

$unsplash = new UnsplashController();
$bearerToken = $unsplash->getBearerToken($_GET["code"]);

setcookie("unsplash", $bearerToken, time() + (60 * 60), "/");

header("location: ../test/unsplash.php");
?>
