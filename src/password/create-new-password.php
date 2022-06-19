<?php
  //if the user is already logged in, they will not have access to the reset password page
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

        <p class="LoginWord"> Reset your password </p>

        <?php
          if(isset($_GET["error"]))
          {
            if($_GET["error"] == "empty_input")
              echo "<p style=\"color: red; text-align: center;\">All fields are required.</p>";
            else if($_GET["error"] == "unmatched_passwords")
              echo "<p style=\"color: red; text-align: center;\">Passwords must match.</p>";
          }
        ?>

        <div class="containerLogin">

            <?php
                if(!isset($_GET["selector"]) || !isset($_GET["validator"]))
                  header("location: ../index.php");

                $selector = $_GET["selector"];
                $validator = $_GET["validator"];

                if(empty($selector) || empty($validator)){
                    echo "Could not validate your request!";
                }else{
                    if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ){
                        ?>

                        <form action="../includes/reset-password.php" method="post">
                            <input type = "hidden" name="selector" value="<?php echo $selector?>">
                            <input type = "hidden" name="validator" value="<?php echo $validator?>">

                            <div class="enterpwd">
                                <input class="enterpwdtxt" type = "password" name="pwd" placeholder="Enter a new password...">

                            </div>

                            <div class="enterpwd">
                                <input class="enterpwdtxt" type = "password" name="pwd-repeat" placeholder="Repeat new password...">
                            </div>

                            <button class="ResetButton" type="submit" name="reset-password-submit">Reset password</button>

                        </form>

                        <?php
                    }
                }
            ?>

        </div>
    </body>
</html>
