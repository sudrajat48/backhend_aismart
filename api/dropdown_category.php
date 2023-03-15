<?php
header("Content-Type: application/json");
require '../helpers/config.php';
require '../helpers/helpers.php';

try {
  //code...
  $data_category   = [];
  $query_category  = $connection->query("SELECT * FROM category_product");
  while ($result = $query_category->fetch_array()) {
    # code...
    $key['id']   = $result['id'];
    $key['name'] = $result['name'];
    array_push($data_category, $key);
  }
  echo json_encode(responseAPI('success', $data_category));
} catch (\Throwable $th) {
  //throw $th;
  echo json_encode(responseAPI('error', $th->getMessage() . ' line ' . $th->getLine()));
}
