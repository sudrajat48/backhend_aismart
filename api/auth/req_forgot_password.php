<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    //code...
    $email               = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : "";
    $query_cek_user      = $connection->query("SELECT * FROM users WHERE email='$email'");
    $result_cek_user     = $query_cek_user->fetch_array();
    if (!$result_cek_user) {
      echo json_encode(responseAPI('error', 'Oops, account not found!'));
    } else {
      $uniqcode = str_pad(mt_rand(1, 999999), 6, 0, STR_PAD_LEFT);
      $connection->query("INSERT INTO uniqcode (id, code, created_at) VALUES (null, '$uniqcode', NOW())");
      $result          = [
        'message' => 'Code verification successful send',
        'data' => $uniqcode
      ];
      echo json_encode(responseAPI('success', $result));
    }
  } catch (\Throwable $th) {
    //throw $th;
    echo json_encode(responseAPI('error', $th->getMessage()));
  }
} else {
  echo 'Access denied';
}
