<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cookieco";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  echo "not connected";
} else {
  // echo "Connected successfully";
}
?>