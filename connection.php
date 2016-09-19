<?php

$con = mysqli_connect("localhost","root","passwort1234","formen");

// Verbindung 
if (mysqli_connect_errno())
  {
 echo "Failed to connect to MySQL: ".mysqli_connect_error();
  }

?>