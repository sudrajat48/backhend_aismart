<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    //code...
    $owner_id               = isset($_POST['owner_id']) ? htmlspecialchars($_POST['owner_id']) : "";
    $user_claim             = isset($_POST['user_claim']) ? htmlspecialchars($_POST['user_claim']) : "";
    $voucher_id             = isset($_POST['voucher_id']) ? htmlspecialchars($_POST['voucher_id']) : "";
    // $name_voucher           = isset($_POST['name_voucher']) ? htmlspecialchars($_POST['name_voucher']) : "";
    // $description            = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : "";
    // $point_voucher          = isset($_POST['point_voucher']) ? htmlspecialchars($_POST['point_voucher']) : "";
    // $image_voucher          = isset($_POST['image_voucher']) ? htmlspecialchars($_POST['image_voucher']) : "";
    // $is_discount            = isset($_POST['is_discount']) ? htmlspecialchars($_POST['is_discount']) : "";
    // $discount_percent       = isset($_POST['discount_percent']) ? htmlspecialchars($_POST['discount_percent']) : "";
    // $discount_price         = isset($_POST['discount_price']) ? htmlspecialchars($_POST['discount_price']) : "";
    // $total_purchase               = isset($_POST['total_purchase']) ? htmlspecialchars($_POST['total_purchase']) : "";
    // $total_after_discount               = isset($_POST['total_after_discount']) ? htmlspecialchars($_POST['total_after_discount']) : "";

    $connection->begin_transaction();
    $vouchers_query = $connection->query("SELECT * FROM vouchers WHERE id = '$voucher_id' LIMIT 1");
    $vouchers       = $vouchers_query->fetch_array();
    $name_voucher   = $vouchers['name_voucher'];
    $description    = $vouchers['description'];
    $point_voucher  = $vouchers['point'];
    $image_voucher  = $vouchers['image'];
    $is_discount    = $vouchers['is_discount'];
    $discount_percent = (int)$vouchers['discount_percent'] ?? null;
    $discount_price = (int)$vouchers['discount_price'] ?? null;
    $active_at      = $vouchers['active_at'];
    $expired_at     = $vouchers['expired_at'];
    $connection->query("INSERT INTO voucher_claim (owner_id, user_claim, voucher_id, name_voucher, description, point_voucher, image_voucher, is_discount, discount_percent, discount_price,  is_claim, active_at, expired_at, claim_at) VALUES ('$owner_id', '$user_claim', '$voucher_id', '$name_voucher', '$description', '$point_voucher', '$image_voucher', '$is_discount', '$discount_percent', '$discount_price', 1, '$active_at', '$expired_at', NOW())");

    $connection->query("UPDATE points SET point = point - '$point_voucher' WHERE user_id = '$user_claim'");

    createInbox($connection, 'CLAIM SUCCESS', 'You have successfully exchanged the coins that have been collected for a discount voucher ' . $name_voucher . '', $user_claim);

    $connection->commit();
    $result          = [
      'message' => 'Claim voucher successfully',
      'is_claim' => 1,
      'step_exchange' => howToUseVoucher($name_voucher)
    ];

    echo json_encode(responseAPI('success', $result));
  } catch (\Throwable $th) {
    //throw $th;
    $connection->rollback();
    echo json_encode(responseAPI('error', $th->getMessage() . ' at line ' . $th->getLine()));
  }
} else {
  echo 'Access denied';
}
