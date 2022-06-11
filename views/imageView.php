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
    $fullPath = "https://localhost/MPic/" . substr($path, 2, strlen($path)-2);

    if(file_exists($path))
    {
      $files = scandir($path, 1);

      echo '<div id="scrollable">';
      for($i=0; $i<count($files)-2; $i+=1)
      {
        if($files[$i] == "index.php")
          continue;
          
        echo '<img src="' . $fullPath . $files[$i] . '" onclick="addImage(this)">';
      }
      echo '</div>';
    }
    else
    {
      echo "You don't have any cropped images yet.";
    }
  }
}
?>
