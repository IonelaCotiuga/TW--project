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
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title> Profile </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="style.css" media="screen"/>
    </head>

    <body>
        <div class="container">
            <div class="split left">

                <h1 class="logo">M-PIC</h1>
                <?php
                  $encodedEmail = md5($jwt["email"]);
                  $defaulturl = urlencode("https://cutewallpaper.org/24/user-icon-png/user-icon-person-free-vector-graphic-on-pixabay.png");
                  $imgurl = "https://www.gravatar.com/avatar/" . $encodedEmail . "?s=200&d=" . $defaulturl;
                ?>
                <img class="border_round" id="profile-picture"  src="<?php echo $imgurl; ?>" alt="profile picture">
                <p class="info"><?php echo $jwt["username"]; ?></p>
                <p class="info"><?php echo $jwt["email"]; ?></p>
                <button class="button button1">Add photo</button>
               
                
                <button class="button button2" onclick="logout()">Logout</button>
            </div>

            <div class="split right">
                <nav class = "topnav">
                   
                    <a class="button princ meniu">All</a>
                    <a class="button princ meniu">Facebook</a>
                    <a class="button princ meniu">Twitter</a>
                    <!-- <table style="width:100%;" class="toptable">
                        <tr>
                        <th class="button princ meniu">  All </th>
                        <th class="button princ meniu">Facebook</th>
                        <th class="button princ meniu">Twitter</th>
                        </tr>
                    </table> -->
                </nav>
                <!-- <div class="split down"> -->
                    <br>
                    <br>
                    <div>
                        <input class="search" type="text" placeholder="Search photo..">
                    </div>

                    <img  class="content" src="image.png" alt="picture">
                    <img  class="content" src="image.png" alt="picture">
                    <img  class="content" src="image.png" alt="picture">
                    <img  class="content" src="image.png" alt="picture">
                    <img  class="content" src="image.png" alt="picture">
                    <img  class="content" src="image.png" alt="picture">
                    <img  class="content" src="image.png" alt="picture">
                    <img  class="content" src="image.png" alt="picture">
                    <img  class="content" src="image.png" alt="picture">
                    <img  class="content" src="image.png" alt="picture">
                    <img  class="content" src="image.png" alt="picture">
                    <img  class="content" src="image.png" alt="picture">
                <!-- </div> -->
            </div>
        </div>

        <script src="../script.js"></script>
    </body>

</html>
