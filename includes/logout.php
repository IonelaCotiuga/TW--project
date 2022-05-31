<?php
setcookie("jwt", "", time()-7200, "/");

header("location: ../index.php");
?>
