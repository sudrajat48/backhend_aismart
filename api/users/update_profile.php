<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    //code...
    $user_id             = isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : "";
    $fullname            = isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : "";
    $email               = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : "";
    $pathAsset           = '../../assets/images/';

    $query_check_email_registered = $connection->query("SELECT email FROM users WHERE email = '$email' AND NOT id = '$user_id'");
    $result_check_email_registered = $query_check_email_registered->fetch_array();

    if ($result_check_email_registered) {
      # code...
      echo json_encode(responseAPI('error', 'Email already registered with another user'));
    } else {
      $cek_user_query      = $connection->query("SELECT * FROM users WHERE id = '$user_id'");
      $result_cek_user     = $cek_user_query->fetch_array();
      if (isset($_FILES['image'])) {
        if (!file_exists($pathAsset)) {
          mkdir($pathAsset, 0777, true);
        }
        $image = date('dmYHis') . str_replace(" ", "",  basename($_FILES['image']['name']));
        $imagePath = $pathAsset . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        if ($result_cek_user['image'] != null) {
          # code...
          unlink($pathAsset . $result_cek_user['image']);
        }
      }
      $connection->begin_transaction();
      $imageUpdate         = isset($image) ? $image : $result_cek_user['image'];
      $update              = $connection->query("UPDATE users SET image = '$imageUpdate', name ='$fullname', email='$email' WHERE id = '$user_id'");
      createInbox($connection, 'Update Profile', 'You have changed the data profile, Thank you for using the AISmart application', $user_id);
      $connection->commit();

      $result              = [
        'message' => 'Update profile successfully',
        'data' => [
          'id' => $result_cek_user['id'],
          'name' => $result_cek_user['name'],
          'email' => $result_cek_user['email'],
          'role' => getRoleName($connection, $result_cek_user['role_id'])
        ]
      ];
      echo json_encode(responseAPI('success', $result));
    }
  } catch (\Throwable $th) {
    //throw $th;
    $connection->rollback();
    echo json_encode(responseAPI('error', $th->getMessage()));
  }
} else {
  echo 'Access denied';
}
