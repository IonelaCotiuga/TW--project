<!DOCTYPE html>
<html lang="en">

    <head>
        <title> About </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="AboutPageStyle.css" />
    </head>


    <body>
        <nav class="topnav" id="myTopnav">
            <a class="logo">M-PIC</a>
            <a href="..">Home</a>
            <a href="#" class="active">About</a>
            <a href="../contact">Contact us</a>
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
            <h1>M-PIC - an online photo editing web application</h1>
            <p>M-Pic is created to help users easily edit their photos.</p>

            <p>First, you have to create an account. After that, you just need to log in, in order to keep, search, edit and post your photos anytime you want.
            You can import your photos from Facebook and Twitter, also you can post on both applications. Once you have a picture you want to edit, you should
            get on the specific page.</p>


            <p>Here you can adjust your preferences as you want:</p>
            <img class="editphoto" src="editphoto.png" alt="editphoto">


            <p>In your profile you can see your information, set a profile photo, add photos or even search them by tags and other information. Here you will find all you need:</p>
            <img class="infophoto" src="profilInfo.png" alt="infophoto">

            <p>You can also choose the platform from which you want to import your photos.</p>
            <img class="content" src="content.png" alt="content">
        </div>
    </body>

</html>
