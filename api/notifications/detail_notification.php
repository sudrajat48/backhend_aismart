<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';


try {
  //code...
  $id = $_GET['id'] ?? '';
  $query_select_notification = $connection->query("SELECT * FROM notifications WHERE id = '$id' LIMIT 1");
  $result = $query_select_notification->fetch_array();

  $response       = [
    'message'     => 'Response successfully',
    'id' => $result['id'],
    'user_id' => $result['user_id'],
    'title' => $result['title'],
    'description' => $result['description'],
    'is_read' => $result['is_read'],
    'created_at' => $result['created_at']
  ];

  echo json_encode(responseAPI('success', $response));
} catch (\Throwable $th) {
  //throw $th;
  echo json_encode(responseAPI('error', $th->getMessage() . ' line ' . $th->getLine()));
}
