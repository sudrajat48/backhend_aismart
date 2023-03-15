<?php
date_default_timezone_set('Asia/Jakarta');

$host = "localhost";
$username = "root";
$password = "";
$db_name = "db_aismart";
$connection = mysqli_connect($host, $username, $password, $db_name);

if (!$connection) {
  # code...
  echo "Connection Failed";
}
