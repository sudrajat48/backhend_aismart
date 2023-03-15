<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    //code...
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    $id = $data->id;
    $category_id = $data->category_id;
    $name = $data->name;
    $description = $data->description;
    $address = $data->address;
    $url_address = $data->url_address;
    $is_favorit = $data->is_favorit;
    $images = $data->images;
    $pathAsset           = '../../assets/images/product/';

    $connection->begin_transaction();
    if ($id != '') {
      $connection->query("UPDATE product SET category_id = '$category_id', name = '$name', description = '$description', address = '$address', urlAddress = '$url_address', isFavorit = '$is_favorit' WHERE id = '$id'");

      $select_image  = $connection->query("SELECT * FROM image_product WHERE product_id = '$id'");
      $result = $select_image->fetch_array();
      for ($i = 0; $i < count($result); $i++) {
        # code...
        $imageSend = isset($images[$i]) ? $images[$i] : '';

        if ($imageSend == $result['image']) {
          continue;
        } else {
          if (file_exists($pathAsset . $result['image'])) {
            # code...
            unlink($pathAsset . $result['image']);
          }
        }
      }
      // exit();
      // while ($result = $select_image->fetch_array()) {
      //   # code...
      //   if (file_exists($pathAsset . $result['image'])) {
      //     # code...
      //     unlink($pathAsset . $result['image']);
      //   }
      // }
      $connection->query("DELETE FROM image_product WHERE product_id = '$id'");
      for ($i = 0; $i < count($images); $i++) {
        $image = $images[$i];
        $connection->query("INSERT INTO image_product (product_id, image) VALUES ('$id', '$image')");
      }
      $connection->commit();
      echo json_encode(responseAPI('success', 'Update product successfully'));
    } else {
      $connection->query("INSERT INTO product (category_id, name, description, address, urlAddress, isFavorit) VALUES ('$category_id', '$name', '$description', '$address', '$url_address', '$is_favorit')");
      $last_id_product         = $connection->insert_id;
      for ($i = 0; $i < count($images); $i++) {
        $image = $images[$i];
        $connection->query("INSERT INTO image_product (product_id, image) VALUES ('$last_id_product', '$image')");
      }
      $connection->commit();
      echo json_encode(responseAPI('success', 'Save product successfully'));
    }
  } catch (\Throwable $th) {
    //throw $th;
    $connection->rollback();
    echo json_encode(responseAPI('error', $th->getMessage()));
  }
} else {
  echo 'Access denied';
}
