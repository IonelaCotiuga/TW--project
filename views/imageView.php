<?php
require_once("../controllers/jwtController.php");

class ImageView
{
  private $jwt;

  public function __construct()
  {
    $this->jwt = JWTController::getPayload($_COOKIE["jwt"]);
  }

  public function viewCrops()
  {
    $path = "../temp/" . $this->jwt["id"] . "/crops/";
    $fullPath = "https://localhost/TW-Project/" . substr($path, 2, strlen($path)-2);

    if(file_exists($path))
    {
      $files = scandir($path, 1);

      for($i=0; $i<count($files)-2; $i+=1)
        echo '<img style="max-width: 10vw;" src="' . $fullPath . $files[$i] . '">' ;
    }
  }
}
?>
