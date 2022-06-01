<?php
class DBHandler
{
  protected function connect()
  {
    include("../util/config.php");
    try
    {
      $dbh = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpass);
      return $dbh;
    }
    catch(PDOException $e)
    {
      echo "Error: " . $e.getMessage();
      die();
    }
  }
}
?>
