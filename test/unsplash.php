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

      #search {
        background-image: url("https://www.w3schools.com/css/searchicon.png");
        background-position: 10px 12px;
        background-repeat: no-repeat;
        min-width: 40vw;
        max-width: 80vw;
        font-size: 16px;
        padding: 12px 20px 12px 40px;
        border: 1px solid #ddd;
        margin-bottom: 12px;
      }

      #searchbar {
        text-align: center;
        margin-bottom: 20px;
      }
    </style>
  </head>

  <body>
    <div id="searchbar">
      <input id="search" type="text" onkeyup="searchImages()"  placeholder="Search images"/>
    </div>

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
      $array = $unsplash->getPhotos($_COOKIE["unsplash"]);

      echo "<div id='wrapper'>\r\n";
      $view->viewImages($array);
      echo "</div>";
    }
    ?>

    <!-- fontawesome icons -->
    <script src="https://kit.fontawesome.com/a4f543b8bc.js" crossorigin="anonymous"></script>
    <script>
      function searchImages()
      {
        const input = document.getElementById("search").value.toLowerCase();
        const boxes = document.getElementsByClassName("box");

        for(let i=0; i<boxes.length; i++)
        {
          let description = boxes[i].getElementsByTagName("p")[0].textContent.toLowerCase();
          let likes = boxes[i].getElementsByClassName("left-icons")[0].getElementsByTagName("i")[0].textContent;
          //remove space
          likes = likes.substring(1);

          if(input =="" || description.indexOf(input) > -1 || likes.indexOf(input) > -1)
            boxes[i].style.display = "";
          else
            boxes[i].style.display = "none";
        }
      }
    </script>
  </body>
</html>
