<?php
require_once("../controllers/jwtController.php");

class ImageController
{
  private $image;
  private $jwt;

  public function __construct($image)
  {
    $this->image = $image;
    $this->jwt = JWTController::getPayload($_COOKIE["jwt"]);
  }

  public function saveImage($type)
  {
    if($type == "crop"){
      $folder = "crops";
    }
    else {
      $folder = "images";
    }

    $saveLocation = "../temp/" . $this->jwt["id"];
    if(!file_exists($saveLocation))
    {
      mkdir($saveLocation, 0777);

      $indexFile = fopen($saveLocation . "/index.php", "w");
      $content = "<?php header(\"location: ../../index.php\"); ?>";

      fwrite($indexFile, $content);
      fclose($indexFile);
    }

    $saveLocation .= "/" .$folder . "/";
    if(!file_exists($saveLocation))
    {
      mkdir($saveLocation, 0777);

      $indexFile = fopen($saveLocation . "index.php", "w");
      $content = "<?php header(\"location: ../../../index.php\"); ?>";

      fwrite($indexFile, $content);
      fclose($indexFile);
    }

    $data = explode(",", $this->image);
    $data = base64_decode($data[1]);

    $filename = $saveLocation . md5(microtime()) . ".png";
    file_put_contents($filename, $data);
  }
}
?>
