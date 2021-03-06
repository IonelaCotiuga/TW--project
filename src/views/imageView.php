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
    require_once("../util/config.php");

    $path = "../temp/" . $this->jwt["id"] . "/crops/";
    $fullPath = $baseUrlSecure . substr($path, 3, strlen($path)-3);

    if(file_exists($path))
    {
      $files = scandir($path, 1);

      echo "<div id='scrollable'>\r\n";
      for($i=0; $i<count($files)-2; $i+=1)
      {
        if($files[$i] == "index.php")
          continue;

        echo "<img src='" . $fullPath . $files[$i] . "' onclick='addImage(this)' alt='Cropped image.'>\r\n";
      }
      echo "</div>";
    }
    else
    {
      echo "You don't have any cropped images yet.";
    }
  }

  public function viewImages($array)
  {
    require("../util/config.php");

    if(count($array) == 0)
    {
      echo "You don't have any images.";
      return;
    }

    for($i=0; $i<count($array); $i+=1)
    {
      $editLink = $baseUrl . "edit?image=" . rawurlencode($array[$i]["source"]);
      $cropLink = $baseUrl . "crop?image=" . rawurlencode($array[$i]["source"]);

      echo "<div class='box'>\r\n";
        echo "<img src='" . $array[$i]["source"] . "' alt='An image.'>\r\n";
        echo "<div class='icons'>\r\n";
          echo "<div class='left-icons'>\r\n";
            echo "<i class='fa-solid fa-heart'> " . $array[$i]["likes"] . "</i>\r\n";
          echo "</div>\r\n"; //left-icons
          echo "<div class='right-icons'>\r\n";
            echo "<a href='" . $editLink . "'><i class='fa-solid fa-pen-to-square'></i></a>\r\n";
            echo "<a href='" . $cropLink . "'><i class='fa-solid fa-crop'></i></a>\r\n";
          echo "</div>\r\n"; //right-icons
        echo "</div>\r\n"; //icons
        echo "<p>" . $array[$i]["description"] . "</p>\r\n";
      echo "</div>\r\n";
    }
  }

  public function viewAuthButton($platform, $link)
  {
    if($platform == "facebook")
    {
      $color = "#4267B2";
      $icon = "fa-brands fa-facebook-f fa-fw";
    }
    else if($platform == "imgur")
    {
      $color = "#21bd79";
      $icon = "fa-solid fa-camera";
    }
    else if($platform == "instagram")
    {
      $color = "rgb(245,133,41); background: linear-gradient(90deg, rgba(245,133,41,1) 0%, rgba(221,42,123,1) 48%, rgba(81,91,212,1) 100%)";
      $icon = "fa-brands fa-instagram";
    }
    else if($platform == "unsplash")
    {
      $color = "black";
      $icon = "fa-brands fa-unsplash";
    }

    echo "<div class='center-button'>\r\n";
    echo "<button class='auth-button' onclick='urlRedirect(\"" . $link . "\")' style='background: " . $color . ";'><i class='" . $icon . "'></i>\tImport Photos</button>\r\n";
    echo "</div>\r\n";
  }
}
?>
