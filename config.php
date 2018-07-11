<?php
  $server = 'localhost';
  $dbUsername = 'root';
  $dbPassword = 'root';
  $db = 'eventwebsite';
  $conn = new mysqli($server, $dbUsername, $dbPassword, $db);
  if($conn->connect_error) die("Connection error: " . $conn->connect_error);

?>
