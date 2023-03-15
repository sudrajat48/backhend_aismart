<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    //code...
    $user_id               = isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : "";
    $product_id            = isset($_POST['product_id']) ? htmlspecialchars($_POST['product_id']) : "";
    $query_review_personal = $connection->query("SELECT * FROM reviews WHERE reviews.product_id ='$product_id' AND reviews.user_id = '$user_id'");
    $result_review_personal = $query_review_personal->fetch_array();

    $data_all_reviews  = [];
    $query_review_all      = $connection->query("SELECT reviews.*, users.image, users.name FROM reviews LEFT JOIN users ON reviews.user_id = users.id WHERE reviews.product_id ='$product_id'");

    while ($result = $query_review_all->fetch_array()) {
      # code...
      $key['id_review'] = $result['id'];
      $key['user_id'] = $result['user_id'];
      $key['product_id'] = $result['product_id'];
      $key['rating'] = number_format((int)$result['rating'], 1, '.');
      $key['review'] = $result['review'];
      $key['name_user'] = $result['name'];
      $key['image_user'] = $result['image'];

      array_push($data_all_reviews, $key);
    }

    $response       = [
      'message'     => 'Response successfully',
      'data_review_personal' => [
        'id_review' => $result_review_personal['id'] ?? '',
        'user_id' => $result_review_personal['user_id'] ?? '',
        'product_id' => $result_review_personal['product_id'] ?? '',
        'rating' => isset($result_review_personal['rating']) ?  number_format((int)$result_review_personal['rating'] ?? 0, 1, '.') : '',
        'review'  => $result_review_personal['review'] ?? ''
      ],
      'reviews' => $data_all_reviews
    ];

    echo json_encode(responseAPI('success', $response));
  } catch (\Throwable $th) {
    //throw $th;
    echo json_encode(responseAPI('error', $th->getMessage()));
  }
} else {
  echo 'Access denied';
}
