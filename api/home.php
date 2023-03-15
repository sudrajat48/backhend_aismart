<?php
header("Content-Type: application/json");
require '../helpers/config.php';
require '../helpers/helpers.php';

try {
  //code...
  $user_id        = $_GET['user_id'] ?? '';
  $point          = -1;

  if ($user_id != '') {
    $point  = getPointUser($connection, $user_id);
  }
  $data_banner    = [];
  $query_banner   = $connection->query("SELECT * FROM banner");

  while ($result  = $query_banner->fetch_array()) {
    # code...
    $key['id'] = $result['id'];
    $key['name'] = $result['name'];

    array_push($data_banner, $key);
  }

  $data_category   = [];
  $query_category  = $connection->query("SELECT * FROM category_product");

  while ($result = $query_category->fetch_array()) {
    # code...
    $key['id']   = $result['id'];
    $key['name'] = $result['name'];
    array_push($data_category, $key);
  }

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

  $count_notification_query = $connection->query("SELECT COUNT(id) as count_id FROM notifications WHERE user_id = '$user_id' AND is_read = 0");
  $count_notification_result = $count_notification_query->fetch_array();

  $response       = [
    'message'     => 'Response successfully',
    'point_user'  => (int)$point,
    'data_banner' => $data_banner,
    'data_category' => $data_category,
    'data_product' => $data_product,
    'notification' => $count_notification_result['count_id']
  ];

  echo json_encode(responseAPI('success', $response));
} catch (\Throwable $th) {
  //throw $th;
  echo json_encode(responseAPI('error', $th->getMessage() . ' line ' . $th->getLine()));
}
