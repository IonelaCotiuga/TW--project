<?php
  //if the user is not logged in, they will not have access to the profile page
  if(!isset($_COOKIE["jwt"]))
  {
    header("location: ../login");
    exit();
  }

  //user data
  require_once("../controllers/jwtController.php");
  $jwt = JWTController::getPayload($_COOKIE["jwt"]);

  //photo data
  require_once("../controllers/facebookController.php");
  require_once("../controllers/imgurController.php");
  require_once("../controllers/instagramController.php");
  require_once("../controllers/unsplashController.php");
  require_once("../views/imageView.php");

  $view = new ImageView();
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title> Profile </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css" media="screen"/>
        <link rel="stylesheet" href="style2.css" media="screen"/>
    </head>

    <body>
        <div class="container">
            <div class="split left">

                <h1 class="logo"><a href="../index.php">M-PIC</a></h1>
                <?php
                  $encodedEmail = md5($jwt["email"]);
                  $defaulturl = urlencode("https://cutewallpaper.org/24/user-icon-png/user-icon-person-free-vector-graphic-on-pixabay.png");
                  $imgurl = "https://www.gravatar.com/avatar/" . $encodedEmail . "?s=200&d=" . $defaulturl;
                ?>
                <img class="border_round" id="profile-picture" src="<?php echo $imgurl; ?>" alt="profile picture">
                <p class="info"><?php echo $jwt["username"]; ?></p>
                <p class="info"><?php echo $jwt["email"]; ?></p>
                <button id="upload-button" class="button button1">Add Photo</button>

                <button class="button button2" onclick="logout()">Log Out</button>
            </div>

            <div class="split right">
              <nav class = "topnav">
                    <div id="social-buttons">
                      <a id="facebook-button" class="button princ meniu" onclick="show(0)">Facebook</a>
                      <a id="imgur-button" class="button princ meniu" onclick="show(1);">Imgur</a>
                      <a id="instagram-button" class="button princ meniu" onclick="show(2);">Instagram</a>
                      <a id="unsplash-button" class="button princ meniu" onclick="show(3);">Unsplash</a>
                      <a id="collage-button" class="button princ meniu" onclick="urlRedirect('../collage')">Make Collage</a>
                    </div>
                </nav>

                <div id="searchbar">
                  <input id="search" type="text" onkeyup="searchImages()" placeholder="Search images"/>
                </div>

                <div id="facebook-content">
                  <?php
                  $facebook = new FacebookController();

                  if(!isset($_COOKIE["facebook"]))
                  {
                    $view->viewAuthButton("facebook", $facebook->getAuthUrl());
                  }
                  else
                  {
                    $array = $facebook->getPhotos($_COOKIE["facebook"]);

                    echo "<div id='wrapper'>\r\n";
                    $view->viewImages($array);
                    echo "</div>\r\n";
                  }
                  ?>
                </div>

                <div id="imgur-content">
                  <?php
                  $imgur = new ImgurController();

                  if(!isset($_COOKIE["imgur"]))
                  {
                    $view->viewAuthButton("imgur", $imgur->getAuthUrl());
                  }
                  else
                  {
                    $array = $imgur->getPhotos($_COOKIE["imgur"]);

                    echo "<div id='wrapper'>\r\n";
                    $view->viewImages($array);
                    echo "</div>\r\n";
                  }
                  ?>
                </div>

                <div id="instagram-content">
                  <?php
                  $instagram = new InstagramController();

                  if(!isset($_COOKIE["instagram"]))
                  {
                    $view->viewAuthButton("instagram", $instagram->getAuthUrl());
                  }
                  else
                  {
                    $array = $instagram->getPhotos($_COOKIE["instagram"]);

                    echo "<div id='wrapper'>\r\n";
                    $view->viewImages($array);
                    echo "</div>\r\n";
                  }
                  ?>
                </div>

                <div id="unsplash-content">
                  <?php
                  $unsplash = new UnsplashController();

                  if(!isset($_COOKIE["unsplash"]))
                  {
                    $view->viewAuthButton("unsplash", $unsplash->getAuthUrl());
                  }
                  else
                  {
                    $array = $unsplash->getPhotos($_COOKIE["unsplash"]);

                    echo "<div id='wrapper'>\r\n";
                    $view->viewImages($array);
                    echo "</div>\r\n";
                  }
                  ?>
                </div>
            </div>
        </div>

        <!-- upload image -->
        <div id="modal">
          <div id="modal-content">
            <span class="close">&times;</span>

            <div id="modal-wrapper">
              <input type="file" id="image-input" accept="image/jpg, image/png" style="display: none;"/>
              <input type="button" class="upload-buttons" value="Choose File" onclick="document.getElementById('image-input').click();" />

              <p id="loading-text">Uploading, please wait a moment...</p>

              <div id="display">
                <img src="#" id="chosen-image" alt="The chosen image."/>

                <div>
                  <button class="modal-button upload-buttons" onclick="redirect('edit')">Edit</button>
                  <button class="modal-button upload-buttons" onclick="redirect('crop')">Crop</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- script -->
        <script src="script.js"></script>
        <script src="../script.js"></script>
        <!-- fontawesome icons -->
        <script src="https://kit.fontawesome.com/a4f543b8bc.js" crossorigin="anonymous"></script>
    </body>

</html>
