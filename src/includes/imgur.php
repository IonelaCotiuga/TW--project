<?php
if(!isset($_GET["state"]))
{
  header("location: ../profile#imgur");
}
?>

<!-- for extracting the access token -->
<script>
  if(window.location.hash)
  {
    const data = window.location.hash.split("#access_token=")[1];
    const accessToken = data.split("&")[0];

    const date = new Date();
    date.setTime(date.getTime() + (60*60*1000));
    const expires = date.toUTCString();

    document.cookie = "imgur=" + accessToken + "; expires=" + expires + "; path=/";

    window.location = "https://localhost/MPic/profile#imgur";
  }
</script>
