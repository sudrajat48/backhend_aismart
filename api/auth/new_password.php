<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email             = isset($_POST['email']) ? $_POST['email'] : "";
  $password            = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : "";
  try {
    //code...
    $connection->begin_transaction();
    $query_user      = $connection->query("SELECT id FROM users WHERE email = '$email' LIMIT 1");
    $result_user     = $query_user->fetch_array();
    $id              = $result_user['id'];
    $update_query    = $connection->query("UPDATE users SET password = '$password' WHERE email = '$email'");
    createInbox($connection, 'Forgot Password/Change new Password', 'You have changed the account password with a new one. Please do not give your password to anyone', $id);
    $connection->commit();
    $result          = 'Password updated successfully, please sign in again';

    echo json_encode(responseAPI('success', $result));
  } catch (\Throwable $th) {
    //throw $th;
    $connection->rollback();
    echo json_encode(responseAPI('error', $th->getMessage()));
  }
} else {
  echo 'Access denied';
}
