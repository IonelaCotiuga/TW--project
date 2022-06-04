<?php
  //if the user is already logged in, they will not have access to the register/login pages
  if(isset($_COOKIE["jwt"]))
  {
    header("location: ../profile");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title> Login </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="loginPage.css" />
    </head>


    <body>
        <nav class="topnav" id="myTopnav">
            <a class="logo">M-PIC</a>
            <a href="..">Home</a>
            <a href="../about">About</a>
            <a href="../contact">Contact us</a>
            <a href="#" class="active">Log in</a>
            <a href="../signup">Sign up</a>
            <a href="javascript:void(0);" class="icon" onclick="expand()">
                <i class="fa fa-bars"></i>
            </a>
        </nav>
        <script src="../script.js"></script>

        <p class="LoginWord"> Login </p>

        <?php
          if(isset($_GET["error"]))
          {
            if($_GET["error"] == "empty_input")
              echo "<p style=\"color: red; text-align: center;\">All fields are required.</p>";
            else if($_GET["error"] == "wrong_user")
              echo "<p style=\"color: red; text-align: center;\">User does not exist.</p>";
            else if($_GET["error"] == "wrong_password")
              echo "<p style=\"color: red; text-align: center;\">Incorrect password.</p>";
            else if($_GET["error"] == "sql_statement_failed")
              echo "<p style=\"color: red; text-align: center;\">Something went wrong. Try again later.</p>";
            else if($_GET["error"] == "none")
              header("location: ../profile");
          }
        ?>

        <div class="containerLogin">
            <form action="..\includes\loginAux.php"  method="post">
                <label for="username" >Username or e-mail:</label>
                <input type="text" id="username" name="username" class="input">

                <label for="password" >Password:</label>
                <input type="password" id="password" name="password" class="input">

                <button onclick = "test(document.getElementById('username').value,document.getElementById('password').value )" class="LoginButton" name="submit">Log in</button>
            </form>

            <a href="../signup">or create an account</a>
        </div>
        <script src = "script.js"></script>
    </body>


</html>
