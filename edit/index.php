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
          <?php
          require_once("../controllers/jwtController.php");

          $jwt = JWTController::getPayload($_COOKIE["jwt"]);
          $path = "../temp/" . $jwt["id"] . "/image.png";

          if(isset($_GET["image"]))
          {
            if(filter_var($_GET["image"], FILTER_VALIDATE_URL))
            {
              $headers = get_headers($_GET["image"], 1);
              if(isset($headers["Content-Type"]) && substr($headers["Content-Type"], 0, 5) == "image")
                echo '<img crossorigin="anonymous" id="chosen-image" src="' . $_GET["image"] . '" alt="The chosen image.">';
            }
            else if($_GET["image"] == "new_image" && file_exists($path))
              echo '<img id="chosen-image" src="' . $path . '" alt="The chosen image.">';
            else
              echo '<img id="chosen-image" src="../util/default_image.png" alt="Default image.">';
          }
          else
            echo '<img id="chosen-image" src="../util/default_image.png" alt="Default image.">';
          ?>
        </figure>
      </div>

      <div class="editor">
        <!-- blur -->
        <div class="filter">
          <label for="blur">Blur</label>
          <input id="blur" type="range" min="0" max="5" value="0" step="0.1"/>
        </div>

        <!-- brightness -->
        <div class="filter">
          <label for="brightness">Brightness</label>
          <input id="brightness" type="range" min="0" max="200" value="100"/>
        </div>

        <!-- contrast -->
        <div class="filter">
          <label for="contrast">Contrast</label>
          <input id="contrast" type="range" min="0" max="200" value="100"/>
        </div>

        <!-- grayscale -->
        <div class="filter">
          <label for="grayscale">Grayscale</label>
          <input id="grayscale" type="range" min="0" max="100" value="0"/>
        </div>

        <!-- hue-rotate -->
        <div class="filter">
          <label for="hue-rotate">Hue-Rotate</label>
          <input id="hue-rotate" type="range" min="0" max="180" value="0"/>
        </div>

        <!-- saturation -->
        <div class="filter">
          <label for="saturation">Saturation</label>
          <input id="saturation" type="range" min="0" max="200" value="100"/>
        </div>

        <!-- sepia -->
        <div class="filter">
          <label for="sepia">Sepia</label>
          <input id="sepia" type="range" min="0" max="100" value="0"/>
        </div>

        <!-- flip options -->
        <div class="flip-buttons">
          <div class="flip-option">
            <input id="flip-horizontal" type="checkbox"/>
            <label for="flip-horizontal">Flip Horizontally</label>
          </div>

          <div class="flip-option">
            <input id="flip-vertical" type="checkbox"/>
            <label for="flip-vertical">Flip Vertically</label>
          </div>
        </div>

        <button id="reset-button" onclick="resetFilters()">Reset Filters</button>
      </div>
    </div>

    <canvas id="canvas" style="display: none;"></canvas>
    <button class="save-button" onclick="saveImage()"><i class="fa-solid fa-desktop fa-fw"></i> Save Image</button>
    <button id="fb" class="save-button"><i class="fa-brands fa-facebook-f fa-fw"></i> Post to Facebook</button>

    <!-- script -->
    <script src="script.js"></script>
    <script src="../script.js"></script>
    <!-- fontawesome icons -->
    <script src="https://kit.fontawesome.com/a4f543b8bc.js" crossorigin="anonymous"></script>
  </body>

</html>
