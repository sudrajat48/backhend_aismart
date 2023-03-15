<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    //code...
    $id               = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : "";
    $connection->query("UPDATE notifications SET is_read = 1 WHERE id = '$id'");
    $result          =  'Notification readed';
    echo json_encode(responseAPI('success', $result));
  } catch (\Throwable $th) {
    //throw $th;
    echo json_encode(responseAPI('error', $th->getMessage()));
  }
} else {
  echo 'Access denied';
}
