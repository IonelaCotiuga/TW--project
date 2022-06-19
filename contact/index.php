<!DOCTYPE html>
<html lang="en">

    <head>
        <title> Contact us </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="contact.css" />
    </head>


    <body>
        <nav class="topnav" id="myTopnav">
            <a class="logo">M-PIC</a>
            <a href="..">Home</a>
            <a href="../about">About</a>
            <a href="#" class="active">Contact us</a>
            <?php
            if(!isset($_COOKIE["jwt"])): ?>
              <a href="../login">Log in</a>
              <a href="../signup">Sign up</a>
            <?php else: ?>
              <a href="../profile">Profile</a>
            <?php endif; ?>
            <a href="javascript:void(0);" class="icon" onclick="expand()">
                <i class="fa fa-bars"></i>
            </a>
        </nav>
        <script src="../script.js"></script>

        <div class="descriptionText">
            <h1>Have any questions?<br/>We'd love to hear from you. </h1>
            <p>Talk to us:
              <ul>
                  <li>111 111 111</li>
                  <li>222 222 222</li>
                  <li>333 333 333</li>
              </ul>
          </p>
            <p>Or send us an email:
              <ul>
                  <li>proiecttw9@gmail.com</li>
                  
              </ul>
          </p>

        </div>
    </body>

</html>
