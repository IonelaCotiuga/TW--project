<?php
require_once("../models/imageModel.php");

class ImageController extends ImageModel
{
  private $image;

  public function __construct($image)
  {
    $this->image = $image;
  }

  public function saveCrop()
  {
    $this->saveCropToDB($this->image);
  }
}
?>
