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
        <title> Create account </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="createAccountPage.css" />

    </head>


    <body>
        <nav class="topnav" id="myTopnav">
            <a class="logo">M-PIC</a>
            <a href="..">Home</a>
            <a href="../about">About</a>
            <a href="../contact">Contact us</a>
            <a href="../login">Log in</a>
            <a href="#" class="active">Sign up</a>
            <a href="javascript:void(0);" class="icon" onclick="expand()">
                <i class="fa fa-bars"></i>
            </a>
        </nav>

        <script src="../script.js"></script>

        <p class="CreateAccountWord"> Create account </p>

        <?php
          if(isset($_GET["error"]))
          {
            if($_GET["error"] == "empty_input")
              echo "<p style=\"color: red; text-align: center;\">All fields are required.</p>";
            else if($_GET["error"] == "invalid_username")
              echo "<p style=\"color: red; text-align: center;\">Username can only contain letters and numbers.</p>";
            else if($_GET["error"] == "username_taken")
              echo "<p style=\"color: red; text-align: center;\">User already exists.</p>";
            else if($_GET["error"] == "unmatched_passwords")
              echo "<p style=\"color: red; text-align: center;\">Passwords must match.</p>";
            else if($_GET["error"] == "sql_statement_failed")
              echo "<p style=\"color: red; text-align: center;\">Something went wrong. Try again later.</p>";
            else if($_GET["error"] == "none")
              echo "<p style=\"color: blue; text-align: center;\">Successfully signed up.</p>";
          }
        ?>

        <div class="containerLogin">
            <form action="../includes/signupAux.php" method="post">
                <label for="username" >Username:</label>
                <input type="text" id="username" name="username" class="input">

                <label for="email" >E-mail address:</label>
                <input type="text" id="email" name="email" class="input">

                <label for="password" >Password:</label>
                <input type="password" id="password" name="password" class="input">

                <label for="password" >Confirm password:</label>
                <input type="password" id="passwordr" name="passwordr" class="input">

                <button class="CreateAccountButton" type="submit" name="submit">Create account</button>
            </form>

            <div class="alreadyAnAccount">Already have an account? &nbsp;
                <a href="../login" class="SignInWord" >Sign in</a>
            </div>

        </div>

    </body>


</html>
