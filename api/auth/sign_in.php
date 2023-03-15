<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    //code...
    $email               = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : "";
    $password            = isset($_POST['password']) ? $_POST['password'] : "";

    $query_cek_user      = $connection->query("SELECT * FROM users WHERE email='$email'");
    $result_cek_user     = $query_cek_user->fetch_array();
    if (!$result_cek_user) {
      echo json_encode(responseAPI('error', 'Oops, account not found! please register first.'));
    } else {
      if (password_verify($password, $result_cek_user['password'])) {
        $result          = [
          'message' => 'Login successfully',
          'data' => [
            'id' => $result_cek_user['id'],
            'name' => $result_cek_user['name'],
            'email' => $result_cek_user['email'],
            'role' => getRoleName($connection, $result_cek_user['role_id'])
          ]
        ];
        echo json_encode(responseAPI('success', $result));
      } else {
        echo json_encode(responseAPI('error', 'Oops, password is not correct'));
      }
    }
  } catch (\Throwable $th) {
    //throw $th;
    echo json_encode(responseAPI('error', $th->getMessage()));
  }
} else {
  echo 'Access denied';
}
