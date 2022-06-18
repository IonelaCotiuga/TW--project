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
        <!-- <p class="LoginWord"> nasol </p> -->

        <div class="containerLogin">

            <?php
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
                            <input type = "password" name="pwd" placeholder="Enter a new password...">
                            <input type = "password" name="pwd-repeat" placeholder="Repeat new password...">
                            <button type="submit" name="reset-password-submit">Reset password</button>
                        </form>

                        <?php
                    }
                }
            ?>





        </div>





    </body>


</html>
