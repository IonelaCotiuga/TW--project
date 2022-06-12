<!DOCTYPE html>
<html lang="en">
  <head>
    <style>
      #wrapper {
        display: flex;
        flex-direction: row;
        align-items: self-start;
        justify-content: center;
        flex-wrap: wrap;
        gap: 15px;
        max-width: 80vw;
        margin: 0 auto;
      }

      .box {
        border: 1px solid black;
        max-width: 20vmax;
      }

      .box img {
        max-width: 20vmax;
      }

      .box div, .box p {
        padding: 0 5px;
      }

      .icons {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
      }

      a {
        color: black;
      }
    </style>
  </head>

  <body>
    <?php
    require_once("../controllers/unsplashController.php");
    require_once("../views/imageView.php");

    $unsplash = new UnsplashController();
    if(!isset($_COOKIE["unsplash"]))
    {
      echo "<a href='" . $unsplash->getAuthUrl() . "'>Autenticate Unsplash</a>";
    }
    else
    {
      $view = new ImageView();
      echo "<div id='wrapper'>\r\n";
      $view->viewImages($unsplash->getPhotos($_COOKIE["unsplash"]));
      echo "</div>";
    }
    ?>

    <!-- fontawesome icons -->
    <script src="https://kit.fontawesome.com/a4f543b8bc.js" crossorigin="anonymous"></script>
  </body>
</html>
