<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

try {
  //code...
  $data_product   = [];
  $query_product  = $connection->query("SELECT * FROM product");
  while ($result = $query_product->fetch_array()) {
    # code...
    $productID = $result['id'];
    $key['id'] = $productID;
    $key['category_id'] = $result['category_id'];
    $key['name'] = $result['name'];
    $key['description'] = $result['description'];
    $key['address'] = $result['address'];

    $key['images'] = [];

    $query_image = $connection->query("SELECT * FROM image_product WHERE product_id = '$productID'");
    while ($result_image = $query_image->fetch_array()) {
      # code...
      $key['images'][] = [
        'image_id' => $result_image['id'],
        'image' => $result_image['image']
      ];
      $key['default_image'] = $key['images'][0]['image'];
    }

    $key['rating'] = getRatingProduct($connection, $productID);
    $key['url_address'] = $result['urlAddress'];
    $key['is_favorit'] = $result['isFavorit'];
    array_push($data_product, $key);
  }

  echo json_encode(responseAPI('success', $data_product));
} catch (\Throwable $th) {
  //throw $th;
  echo json_encode(responseAPI('error', $th->getMessage() . ' line ' . $th->getLine()));
}
