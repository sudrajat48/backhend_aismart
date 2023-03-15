<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user_id                 = isset($_POST['user_id']) ? $_POST['user_id'] : "";
  $old_password            = isset($_POST['old_password']) ? $_POST['old_password'] : "";
  $new_password            = isset($_POST['new_password']) ? password_hash($_POST['new_password'], PASSWORD_BCRYPT) : "";

  $query_select_user       = $connection->query("SELECT * FROM users WHERE id = '$user_id'");
  $result_select_user      = $query_select_user->fetch_array();

  if (password_verify($old_password, $result_select_user['password'])) {
    $connection->begin_transaction();
    $connection->query("UPDATE users SET password = '$new_password' WHERE id = '$user_id'");
    createInbox($connection, 'Change new Password', 'You have changed the account password with a new one. Please do not give your password to anyone', '$user_id');
    $connection->commit();
    $result          = [
      'message' => 'Update password successfully',
      'data' => [
        'id' => $result_select_user['id'],
        'name' => $result_select_user['name'],
        'email' => $result_select_user['email'],
        'role' => getRoleName($connection)
      ]
    ];
    echo json_encode(responseAPI('success', $result));
  } else {
    $connection->rollback();
    echo json_encode(responseAPI('error', 'Oops, old password is not correct'));
  }
} else {
  echo 'Access denied';
}
