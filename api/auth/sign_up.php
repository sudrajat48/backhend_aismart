<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $fullname            = isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : "";
  $email               = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : "";
  $password            = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : "";

  $query_cek_user      = $connection->query("SELECT * FROM users WHERE email='$email'");
  $result_cek_user     = $query_cek_user->fetch_array();
  if ($result_cek_user) {
    echo json_encode(responseAPI('error', 'Oops, account has been registered'));
  } else {
    try {
      //code...
      $connection->begin_transaction();
      $insert_query    = $connection->query("INSERT INTO users (id, name, email, password, role_id, created_at) VALUES (null, '$fullname', '$email', '$password', 1, NOW())");
      $last_id         = $connection->insert_id;
      $connection->query("INSERT INTO points (user_id, point) VALUES ('$last_id', 0)");
      createInbox($connection, 'WELCOME TO AISMART', 'Thank you for joining AISmart, find the best places in Tangerang. Collect points and exchange shopping discount vouchers', $last_id);
      $connection->commit();
      $result          = [
        'message' => 'Registration successfully',
        'data' => [
          'id'    => $last_id ?? 0,
          'fullname' => $fullname,
          'email' => $email,
          'role' => getRoleName($connection, 1)
        ]
      ];
      echo json_encode(responseAPI('success', $result));
    } catch (\Throwable $th) {
      //throw $th;
      $connection->rollback();
      echo json_encode(responseAPI('error', $th->getMessage()));
    }
  }
} else {
  echo 'Access denied';
}
