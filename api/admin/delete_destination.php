<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    //code...
    $id               = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : "";
    $connection->begin_transaction();
    $connection->query("DELETE FROM product WHERE id = '$id'");
    $foto_product = $connection->query("SELECT * FROM image_product WHERE product_id = '$id'");
    $pathAsset           = '../../assets/images/product/';
    while ($result = $foto_product->fetch_array()) {
      # code...
      unlink($pathAsset . $result['image']);
    }
    $connection->query("DELETE FROM image_product WHERE product_id = '$id'");
    $connection->commit();
    echo json_encode(responseAPI('success', 'Delete product successfully'));
  } catch (\Throwable $th) {
    //throw $th;
    $connection->rollback();
    echo json_encode(responseAPI('error', $th->getMessage()));
  }
} else {
  echo 'Access denied';
}
