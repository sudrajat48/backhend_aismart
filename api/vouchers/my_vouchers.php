<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';


try {
  //code...
  $user_id        = $_GET['user_id'] ?? '';
  $date           = date('Y-m-d H:i:s');
  $my_vouchers    = [];
  if ($user_id == '') {
    echo json_encode(responseAPI('error', 'User ID not found.'));
    return;
  }
  $check_voucher  = $connection->query("SELECT id, name_voucher, description, image_voucher FROM voucher_claim WHERE user_claim = '$user_id' AND '$date' > active_at && '$date' < expired_at ORDER BY claim_at DESC");
  while ($row = $check_voucher->fetch_array()) {
    # code...
    $key['id'] = $row['id'];
    $key['name_voucher'] = $row['name_voucher'];
    $key['description'] = $row['description'];
    $key['image_voucher'] = $row['image_voucher'];

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
