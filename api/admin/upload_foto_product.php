<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    //code...
    $pathAsset        = '../../assets/images/product/';
    if (isset($_FILES['image'])) {

      // if ($id != '') {
      //   $cek_foto_product     = $connection->query("SELECT * FROM image_product WHERE product_id = '$id'");
      //   $cek_foto_product     = $cek_foto_product->fetch_array();
      //   if ($cek_foto_product['image'] != null) {
      //     # code...
      //     unlink($pathAsset . $cek_foto_product['image']);
      //   }
      // }

      if (!file_exists($pathAsset)) {
        mkdir($pathAsset, 0777, true);
      }
      $image = date('dmYHis') . str_replace(" ", "",  basename($_FILES['image']['name']));
      $imagePath = $pathAsset . $image;
      move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
      echo json_encode(responseAPI('success', $image));
    } else {
      echo json_encode(responseAPI('error', 'Photo not found'));
    }
  } catch (\Throwable $th) {
    //throw $th;
    echo json_encode(responseAPI('error', $th->getMessage()));
  }
} else {
  echo 'Access denied';
}
