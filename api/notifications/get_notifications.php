<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';


try {
  //code...
  $id = $_GET['user_id'] ?? '';
  $data = [];
  $query_select_notification = $connection->query("SELECT * FROM notifications WHERE user_id = '$id' ORDER BY created_at DESC");
  while ($result = $query_select_notification->fetch_array()) {
    # code...
    $key['id'] = $result['id'];
    $key['user_id'] = $result['user_id'];
    $key['title'] = $result['title'];
    $key['description'] = $result['description'];
    $key['is_read'] = $result['is_read'];
    $key['created_at'] = $result['created_at'];

    array_push($data, $key);
  }
  $response       = [
    'message'     => 'Response successfully',
    'data'        => $data
  ];

  echo json_encode(responseAPI('success', $response));
} catch (\Throwable $th) {
  //throw $th;
  echo json_encode(responseAPI('error', $th->getMessage() . ' line ' . $th->getLine()));
}
