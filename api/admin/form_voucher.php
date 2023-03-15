<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  try {
    //code...
    $id               = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : "";
    $user_id          = isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : "";
    $name_voucher     = isset($_POST['name_voucher']) ? htmlspecialchars($_POST['name_voucher']) : "";
    $point            = isset($_POST['point']) ? htmlspecialchars($_POST['point']) : "";
    $description      = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : "";
    $is_discount      = isset($_POST['is_discount']) ? htmlspecialchars($_POST['is_discount']) : "";
    $discount_percent = isset($_POST['discount_percent']) ? htmlspecialchars($_POST['discount_percent']) : NULL;
    $discount_price   = isset($_POST['discount_price']) ? htmlspecialchars($_POST['discount_price']) : NULL;
    $active_at        = isset($_POST['active_at']) ? htmlspecialchars($_POST['active_at']) : "";
    $expired_at       = isset($_POST['expired_at']) ? htmlspecialchars($_POST['expired_at']) : "";
    $image            = isset($_POST['image_url']) ? htmlspecialchars($_POST['image_url']) : "";
    $pathAsset           = '../../assets/images/vouchers/';

    if (isset($_FILES['image'])) {
      if ($id != '') {
        $cek_voucher_query      = $connection->query("SELECT * FROM vouchers WHERE id = '$id'");
        $result_cek_voucher     = $cek_voucher_query->fetch_array();
        if ($result_cek_voucher['image'] != null) {
          # code...
          unlink($pathAsset . $result_cek_voucher['image']);
        }
      }
      if (!file_exists($pathAsset)) {
        mkdir($pathAsset, 0777, true);
      }
      $image = date('dmYHis') . str_replace(" ", "",  basename($_FILES['image']['name']));
      $imagePath = $pathAsset . $image;
      move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }


    $connection->begin_transaction();
    if ($id == '') {
      $image_insert = isset($image) ? $image : NULL;
      $connection->query("INSERT INTO vouchers (user_id, name_voucher, point, image, description, is_discount, discount_percent, discount_price, active_at, expired_at, created_at) VALUES
                                        ('$user_id', '$name_voucher', '$point', '$image_insert', '$description', '$is_discount', '$discount_percent', '$discount_price', '$active_at', '$expired_at', NOW())");
      $connection->commit();

      echo json_encode(responseAPI('success',  'Add vouchers successfully'));
    } else {
      $image_update = isset($image) ? $image : NULL;
      $connection->query("UPDATE vouchers SET name_voucher = '$name_voucher', point='$point', image = '$image_update', description = '$description', is_discount = '$is_discount', discount_percent = '$discount_percent', discount_price = '$discount_price', active_at = '$active_at', expired_at = '$expired_at' WHERE id = '$id'");
      $connection->commit();

      echo json_encode(responseAPI('success',  'Update vouchers successfully'));
    }
  } catch (\Throwable $th) {
    //throw $th;
    $connection->rollback();
    echo json_encode(responseAPI('error', $th->getMessage()));
  }
} else {
  echo 'Access denied';
}
