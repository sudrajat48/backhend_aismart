<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    //code...
    $user_id               = isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : "";
    $id_voucher_claim      = isset($_POST['id_voucher_claim']) ? htmlspecialchars($_POST['id_voucher_claim']) : "";
    $total_purchase        = isset($_POST['total_purchase']) ? htmlspecialchars($_POST['total_purchase']) : "";
    $total_after_discount  = isset($_POST['total_after_discount']) ? htmlspecialchars($_POST['total_after_discount']) : "";
    $total_potongan        = (int)$total_purchase - (int)$total_after_discount;
    $connection->begin_transaction();
    $connection->query("UPDATE voucher_claim SET total_purchase = '$total_purchase', total_after_discount = '$total_after_discount', is_use = 1, use_at = NOW() WHERE user_claim = '$user_id' AND id = '$id_voucher_claim'");
    createInbox($connection, 'VOUCHER SUCCESSFULLY USED', 'You have saved Rp ' . $total_potongan . ' on your purchase for using the voucher you have', '$user_id');
    $connection->commit();
    echo json_encode(responseAPI('success', 'Voucher successfully used'));
  } catch (\Throwable $th) {
    //throw $th;
    $connection->rollback();
    echo json_encode(responseAPI('error', $th->getMessage() . ' at line ' . $th->getLine()));
  }
} else {
  echo 'Access denied';
}
