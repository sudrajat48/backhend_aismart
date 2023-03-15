<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    //code...
    $user_id               = isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : "";

    $query_cek_user      = $connection->query("SELECT * FROM users WHERE id='$user_id'");
    $result_cek_user     = $query_cek_user->fetch_array();
    if (!$result_cek_user) {
      echo json_encode(responseAPI('error', 'Oops, account not found! please register first.'));
    } else {
      $result          = [
        'message' => 'User found',
        'data' => [
          'id' => $result_cek_user['id'],
          'name' => $result_cek_user['name'],
          'email' => $result_cek_user['email'],
          'image' => $result_cek_user['image'],
          'role' => getRoleName($connection, $result_cek_user['role_id'])
        ]
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
