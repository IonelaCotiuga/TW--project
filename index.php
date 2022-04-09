<!DOCTYPE html>
<html lang="en">

  <?php
  require_once('instagram/instagram_basic_display_api.php');

  $params = array(
    'get_code' => isset($_GET['code']) ? $_GET['code'] : '',
  );
  $ig = new instagram_basic_display_api($params);
   ?>

  <head>
    <title>My Photo App</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <script>
      //get authorization link
      function instagramAuth() {
        window.location = "<?php echo $ig->authorizationUrl; ?>";
      }
    </script>
    <!-- fontawesome icons -->
    <script src="https://kit.fontawesome.com/a4f543b8bc.js" crossorigin="anonymous"></script>
  </head>

  <body>
    <h1>My Photo App</h1>
    <div id="buttons">
      <button id="ibutton" onclick="instagramAuth()"><i class="fa-brands fa-instagram"></i> Login with Instagram</button>
      <button id="tbutton"><i class="fa-brands fa-twitter"></i> Login with Twitter</button>
    </div>
  </body>
  
</html>
