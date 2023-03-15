<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user_id            = isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : "";
  $voucher_id         = isset($_POST['voucher_id']) ? htmlspecialchars($_POST['voucher_id']) : "";
  $data_name_voucher  = $connection->query("SELECT name_voucher FROM vouchers WHERE id ='$voucher_id' LIMIT 1");
  $result_name        = $data_name_voucher->fetch_array();
  $data               = $connection->query("SELECT is_claim FROM voucher_claim WHERE voucher_id ='$voucher_id' AND user_claim = '$user_id' LIMIT 1");
  $result             = $data->fetch_array();
  $is_claim           = -1;
  if (!$result) {
    $is_claim        = 0;
    $result          = [
      'message' => 'Check claim successfully',
      'is_claim' => (int)$is_claim,
      'step_exchange' => howToUseVoucher($result_name['name_voucher'])
    ];

    echo json_encode(responseAPI('success', $result));
  } else {
    $is_claim        = $result['is_claim'];
    $result          = [
      'message' => 'Check claim successfully',
      'is_claim' => (int)$is_claim,
      'step_exchange' => howToUseVoucher($result_name['name_voucher'])
    ];

    echo json_encode(responseAPI('success', $result));
  }
} else {
  echo 'Access denied';
}
