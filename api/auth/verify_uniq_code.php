<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    //code...
    $uniqcode            = isset($_POST['uniqcode']) ? htmlspecialchars($_POST['uniqcode']) : "";
    $query_cek_code      = $connection->query("SELECT code FROM uniqcode WHERE code='$uniqcode'");
    $result_cek_code     = $query_cek_code->fetch_array();

    if (!$result_cek_code) {
      echo json_encode(responseAPI('error', 'Oops, code verification not found!'));
    } else {
      $code              = $result_cek_code['code'];
      $connection->query("DELETE FROM uniqcode WHERE code = '$code'");
      $result          = 'Verification success';
      echo json_encode(responseAPI('success', $result));
    }
  } catch (\Throwable $th) {
    //throw $th;
    echo json_encode(responseAPI('error', $th->getMessage()));
  }
} else {
  echo 'Access denied';
}
