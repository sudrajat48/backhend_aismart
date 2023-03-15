<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';


try {
  //code...
  $user_id        = $_GET['user_id'] ?? '';
  $point          = -1;

  if ($user_id != '') {
    $point  = getPointUser($connection, $user_id);
  }
  $data_voucher      = [];
  $date              = date('Y-m-d H:i:s');
  $voucher_query     = $connection->query("SELECT * FROM vouchers WHERE '$date' >= active_at && '$date' < expired_at ORDER BY created_at DESC ");

  // while ($row = $voucher_query->fetch_array()) {
  # code...
  // $active_at = $row['active_at'];
  // $expired_at = $row['expired_at'];
  // $voucher_query     = $connection->query("SELECT * FROM vouchers WHERE '$date' > '$active_at' && '$date' < '$expired_at' ORDER BY created_at DESC ");

  while ($result = $voucher_query->fetch_array()) {
    # code...
    $key['id'] = $result['id'];
    $key['user_id'] = $result['user_id'];
    $key['name_voucher'] = $result['name_voucher'];
    $key['description'] = $result['description'];
    $key['is_discount'] = (int)$result['is_discount'];
    $key['discount_percent'] = (int)$result['discount_percent'] ?? 0;
    $key['discount_price'] = (int)$result['discount_price'] ?? 0;
    $key['active_at'] = $result['active_at'];
    $key['expired_at'] = $result['expired_at'];
    $key['created_at'] = $result['created_at'];
    $key['image'] = $result['image'];
    $key['point'] = (int)$result['point'];

    array_push($data_voucher, $key);
  }
  // }

  $response       = [
    'message'     => 'Response successfully',
    'point_user'  => (int)$point,
    'data'        => $data_voucher,
  ];

  echo json_encode(responseAPI('success', $response));
} catch (\Throwable $th) {
  //throw $th;
  echo json_encode(responseAPI('error', $th->getMessage() . ' line ' . $th->getLine()));
}
