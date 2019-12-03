<?php
// $mysqli = new mysqli("localhost", "tuusuario", "tucontraseña", "SUDO_TRACKER");


$mysqli = new mysqli('127.0.0.1', 'root', 'Car123()', 'pruebas');
if (mysqli_connect_errno()) 
{
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$mysqli->set_charset("utf8mb4");
?>
