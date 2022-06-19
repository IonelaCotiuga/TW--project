<?php
  $error = $_SERVER["REDIRECT_STATUS"];
  $error_title = '';
  $error_message = '';

  if($error == 404){
    $error_title = '404 Page Not Found';
    $error_message = 'The document/file requested was not found on this server.';
  }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title> Login </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="https://localhost/MPic/page-not-found.css" />
    </head>


    <body>
      <nav class="topnav" id="myTopnav">
          <a class="logo">M-PIC</a>
          <a href="https://localhost/MPic">Home</a>
          <a href="https://localhost/MPic/about">About</a>
          <a href="https://localhost/MPic/contact">Contact us</a>
          <?php
          if(!isset($_COOKIE["jwt"])): ?>
            <a href="https://localhost/MPic/login">Log in</a>
            <a href="https://localhost/MPic/signup">Sign up</a>
          <?php else: ?>
            <a href="https://localhost/MPic/profile">Profile</a>
          <?php endif; ?>
          <a href="javascript:void(0);" class="icon" onclick="expand()">
              <i class="fa fa-bars"></i>
          </a>
      </nav>
        <script src="https://localhost/MPic/script.js"></script>


        <div class="containerError">
           <h1><?php echo $error_title;  ?> </h1>
           <h3><?php echo $error_message;  ?> </h3>
           <a href = "https://localhost/MPic/index.php" class="passwordText"> Click here to get back on our site ^_^ </a>

           <img class = "photo" src="https://localhost/MPic/util/errorimg.png" >
        </div>
    </body>
</html>
