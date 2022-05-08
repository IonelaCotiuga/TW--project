<?php
//start the session to be able to terminate it
session_start();
//unset all session variables
session_unset();
//end session
session_destroy();

//return
header("location: ../index.php");
?>
