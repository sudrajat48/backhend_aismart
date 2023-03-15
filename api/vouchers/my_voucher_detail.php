<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';


try {
  //code...
  $voucher_claim_id  = $_GET['voucher_claim_id'] ?? '';
  if ($voucher_claim_id == '') {
    echo json_encode(responseAPI('error', 'Voucher ID not found.'));
    return;
  }
  $check_voucher  = $connection->query("SELECT * FROM voucher_claim WHERE id = '$voucher_claim_id' LIMIT 1");
  $result = $check_voucher->fetch_array();

  if (!$result) {
    echo json_encode(responseAPI('error', 'Data not found.'));
    return;
  }
  $response       = [
    'message'     => 'Response successfully',
    'data'        => [
      'id'        => $result['id'],
      'owner_id' => $result['owner_id'],
      'user_claim' => $result['user_claim'],
      'voucher_id' => $result['voucher_id'],
      'name_voucher' => $result['name_voucher'],
      'description' => $result['description'],
      'point_voucher' => $result['point_voucher'],
      'image_voucher' => $result['image_voucher'],
      'is_discount' => $result['is_discount'],
      'discount_percent' => $result['discount_percent'],
      'discount_price' => $result['discount_price'],
      'total_purchase' => $result['total_purchase'],
      'total_after_discount' => $result['total_after_discount'],
      'is_claim' => $result['is_claim'],
      'is_use' => $result['is_use'],
      'claim_at' => $result['claim_at'],
      'expired_at' => $result['expired_at'],
      'use_at' => $result['use_at']
    ],
    'step_exchange' => howToUseVoucher($result['name_voucher'])
  ];

  echo json_encode(responseAPI('success', $response));
} catch (\Throwable $th) {
  //throw $th;
  echo json_encode(responseAPI('error', $th->getMessage() . ' line ' . $th->getLine()));
}
