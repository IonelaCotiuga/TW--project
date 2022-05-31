<?php
session_start();

class ImageModel extends DBHandler
{
  protected function saveCropToDB($image)
  {
    $stmt = $this->connect()->prepare("INSERT INTO crops VALUES (?, ?);");

    if(!$stmt->execute(array($_SESSION["userid"], $image)))
    {
      $stmt = null;
      exit();
    }
  }
}
?>
