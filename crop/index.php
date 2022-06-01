<?php
  //if the user is not logged in, they will not have access to the crop page
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
        <img id="chosen-image" src="cat.png" alt="The chosen image.">
        <canvas id="canvas"></canvas>
      </div>

      <div class="editor">
        <button class="button" onclick="reset()">Reset Selection</button>
        <button class="button" onclick="crop()">Crop Selection</button>
        <button class="button" onclick="save()">Save Crop</button>
      </div>
    </div>

    <canvas id="canvas2" style="display: none;"></canvas>

    <!-- script -->
    <script src="script.js"></script>
    <script src="../script.js"></script>
    <!-- fontawesome icons -->
    <script src="https://kit.fontawesome.com/a4f543b8bc.js" crossorigin="anonymous"></script>
  </body>

</html>
