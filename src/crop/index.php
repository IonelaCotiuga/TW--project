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
        <canvas id="canvas"></canvas>
      </div>

      <div class="editor">
        <button class="button" onclick="reset()">Reset Selection</button>
        <button class="button" onclick="crop()">Crop Selection</button>
        <button class="button" onclick="save()">Save Crop</button>
      </div>
      <div id="text" class="styleText">Crop saved successfully!</div>
    </div>

    <canvas id="canvas2" style="display: none;"></canvas>

    <!-- script -->
    <script src="script.js"></script>
    <script src="../script.js"></script>
    <!-- fontawesome icons -->
    <script src="https://kit.fontawesome.com/a4f543b8bc.js" crossorigin="anonymous"></script>
  </body>

</html>
