<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';


try {
  //code...
  $voucher_id   = $_GET['voucher_id'] ?? '';
  if ($voucher_id == '') {
    echo json_encode(responseAPI('error', 'Voucher ID not found.'));
    return;
  }
  $query_select_detail = $connection->query("SELECT SUM(voucher_claim.total_purchase-voucher_claim.total_after_discount) as total_discount, vouchers.* FROM vouchers LEFT JOIN voucher_claim ON vouchers.id = voucher_claim.voucher_id WHERE vouchers.id = '$voucher_id' GROUP BY vouchers.id");
  $result_select_detail = $query_select_detail->fetch_array();
  if (!$result_select_detail) {
    # code...
    echo json_encode(responseAPI('error', 'Voucher ID not found.'));
    return;
  } else {
    $query_total_claim_voucher = $connection->query("SELECT COUNT(is_claim) as is_claim FROM voucher_claim WHERE is_claim = 1 AND voucher_id = " . $result_select_detail['id'] . "");
    $result_total_claim_voucher = $query_total_claim_voucher->fetch_array();
    $query_total_use_voucher = $connection->query("SELECT COUNT(is_use) as is_use FROM voucher_claim WHERE is_use = 1 AND voucher_id = " . $result_select_detail['id'] . "");
    $result_total_use_voucher = $query_total_use_voucher->fetch_array();
    $response       = [
      'message'     => 'Response successfully',
      'id' => $result_select_detail['id'],
      'name_voucher' => $result_select_detail['name_voucher'],
      'point' => $result_select_detail['point'],
      'image' => $result_select_detail['image'],
      'description' => $result_select_detail['description'],
      'is_discount' => $result_select_detail['is_discount'],
      'discount_percent' => $result_select_detail['discount_percent'],
      'discount_price' => $result_select_detail['discount_price'],
      'active_at' => $result_select_detail['active_at'],
      'expired_at' => $result_select_detail['expired_at'],
      'created_at' => $result_select_detail['created_at'],
      'total_discount' => $result_select_detail['total_discount'],
      'total_claim' => $result_total_claim_voucher['is_claim'],
      'total_use' => $result_total_use_voucher['is_use'],
    ];

    echo json_encode(responseAPI('success', $response));
  }
} catch (\Throwable $th) {
  //throw $th;
  echo json_encode(responseAPI('error', $th->getMessage() . ' line ' . $th->getLine()));
}
