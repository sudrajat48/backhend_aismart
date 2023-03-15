<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';


try {
  //code...
  $user_id        = $_GET['user_id'] ?? '';
  $my_vouchers    = [];
  if ($user_id == '') {
    echo json_encode(responseAPI('error', 'User ID not found.'));
    return;
  }
  $check_voucher  = $connection->query("SELECT * FROM vouchers WHERE user_id = '$user_id' ORDER BY created_at DESC");
  while ($result = $check_voucher->fetch_array()) {
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

    array_push($my_vouchers, $key);
  }

  $response       = [
    'message'     => 'Response successfully',
    'data'        => $my_vouchers
  ];

  echo json_encode(responseAPI('success', $response));
} catch (\Throwable $th) {
  //throw $th;
  echo json_encode(responseAPI('error', $th->getMessage() . ' line ' . $th->getLine()));
}
