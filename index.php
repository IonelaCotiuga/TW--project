<!DOCTYPE html>
<html lang="en">

    <head>
        <title> M-Pic </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="MainPageStyle.css" />
    </head>

    <body>
        <nav class="topnav" id="myTopnav">
            <a class="logo">M-PIC</a>
            <a href="#" class="active">Home</a>
            <a href="about">About</a>
            <a href="contact">Contact us</a>
            <?php
            if(!isset($_COOKIE["jwt"])): ?>
              <a href="login">Log in</a>
              <a href="signup">Sign up</a>
            <?php else: ?>
              <a href="profile">Profile</a>
            <?php endif; ?>
            <a href="javascript:void(0);" class="icon" onclick="expand()">
                <i class="fa fa-bars"></i>
            </a>
        </nav>

        <object class="photo" data="util/photo3.svg"> </object>
        <div class="descriptionText">
        <h1>M-PIC - an online photo editing web application</h1>
        <p>The application’s primary goal is to help users easily apply photo editing filters,
            save them to the personal computer or be posted directly to a social media platform.</p>
        <button onclick="location.href = 'signup';" class="signUp" >Sign up</button>

        </div>

        <script src="script.js"></script>


    </body>

</html>
