<!DOCTYPE html>
<html lang="en">

    <head>
        <title> Login </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="password.css" />
    </head>


    <body>
        <nav class="topnav" id="myTopnav">
            <a class="logo">M-PIC</a>
            <a href="..">Home</a>
            <a href="../about">About</a>
            <a href="../contact">Contact us</a>
            <a href="../login">Log in</a>
            <a href="../signup">Sign up</a>
            <a href="javascript:void(0);" class="icon" onclick="expand()">
                <i class="fa fa-bars"></i>
            </a>
        </nav>
        <script src="../script.js"></script>

        <p class="LoginWord"> Forgot your password? </p>
        <!-- <p class="LoginWord"> nasol </p> -->

        <div class="containerLogin">
              <form action="../includes/reset-request.php" method="post">
                <label for="username" >E-mail:</label>
                <input type="text" id="username" name="email" class="input" placeholder="Enter your e-mail address..">

                <button class="LoginButton" type="submit" name="reset-request-submit">Receive new password by email</button>
              </form>

              <?php
                if(isset($_GET["reset"])){
                  if($_GET["reset"] == "succes"){
                    echo '<p> class = "signupsuccess"> Check your email!</p>';
                  }
                }

              ?>

            <br>
        </div>





    </body>


</html>
