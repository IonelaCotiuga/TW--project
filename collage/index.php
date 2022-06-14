<?php
  //if the user is not logged in, they will not have access to the edit page
  if(!isset($_COOKIE["jwt"]))
  {
    header("location: ../login");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <title>M-Pic</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

  <body>
    <!-- header -->
    <nav class="topnav" id="myTopnav">
      <a class="logo">M-PIC</a>
      <a href="../">Home</a>
      <a href="../about">About</a>
      <a href="../contact">Contact us</a>
      <a href="../profile">Profile</a>

      <a href="javascript:void(0);" class="icon" onclick="expand()">
          <i class="fa fa-bars"></i>
      </a>
    </nav>

    <div class="wrapper">
      <!-- the image -->
      <div class="result">
        <figure class="image-container">
          <canvas id="canvas" width=300 height=300>Your browser does not support canvases.</canvas>
        </figure>
      </div>

      <div class="editor">
        <?php
        require_once("../views/imageView.php");
        $imageView = new ImageView();
        $imageView->viewCrops();
        ?>

        <div>
          <label for="size">Image size</label>
          <input id="size" name="size" type="range" min="10" max="300" value="150"/>
        </div>

        <div>
          <button id="delete-button" onclick="removeImage()">Delete Image</button>
          <button id="delete-button" onclick="removeAll()">Clear Canvas</button>
        </div>
      </div>
    </div>

    <button class="save-button" onclick="saveImage()"><i class="fa-solid fa-desktop fa-fw"></i> Save Image</button>
    <button id="fb" class="save-button"><i class="fa-brands fa-facebook-f fa-fw"></i> Post to Facebook</button>

    <!-- script -->
    <script src="script.js"></script>
    <script src="../script.js"></script>
    <!-- fontawesome icons -->
    <script src="https://kit.fontawesome.com/a4f543b8bc.js" crossorigin="anonymous"></script>
  </body>

</html>
