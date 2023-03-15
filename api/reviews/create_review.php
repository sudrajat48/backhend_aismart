<?php
header("Content-Type: application/json");
require '../../helpers/config.php';
require '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    //code...
    $user_id               = isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : "";
    $product_id            = isset($_POST['product_id']) ? htmlspecialchars($_POST['product_id']) : "";
    $rating                = isset($_POST['rating']) ? htmlspecialchars(round($_POST['rating'])) : "";
    $review                = isset($_POST['review']) ? htmlspecialchars($_POST['review']) : "";

    $check_review_query    = $connection->query("SELECT * FROM reviews WHERE user_id = '$user_id' AND product_id = '$product_id'");
    $result_review_query   = $check_review_query->fetch_array();
    $connection->begin_transaction();
    if ($result_review_query) {
      $connection->query("UPDATE reviews SET rating = '$rating', review = '$review' WHERE user_id = '$user_id' AND product_id = '$product_id'");
      $connection->commit();
      $result          = [
        'message' => 'Review save successfully',
        'data' => [
          'id' => $result_review_query['id'],
          'user_id' => $result_review_query['user_id'],
          'product_id' => $result_review_query['product_id'],
          'rating' => $rating,
          'review' => $review
        ]
      ];
      echo json_encode(responseAPI('success', $result));
    } else {
      $connection->query("INSERT INTO reviews (user_id, product_id, rating, review) VALUES ('$user_id', '$product_id', '$rating', '$review')");
      $last_id         = $connection->insert_id;
      $check_user_point = $connection->query("SELECT * FROM points WHERE user_id='$user_id'");
      $result_user_point = $check_user_point->fetch_array();
      if ($result_user_point) {
        $idUser = $result_user_point['user_id'];
        $connection->query("UPDATE points SET point = point + 10 WHERE user_id = '$idUser'");
      } else {
        $connection->query("INSERT INTO points (user_id, point) VALUES ('$user_id', 10)");
      }
      createInbox($connection, 'YOU GET 10 COINS', 'You have earned 10 coins for reviewing. Use your coins to exchange discount vouchers that can be used at AISMART outlets/partners', $user_id);
      $connection->commit();
      $result          = [
        'message' => 'Review save successfully',
        'data' => [
          'id' => (string)$last_id ?? 0,
          'user_id' => $user_id,
          'product_id' => $product_id,
          'rating' => $rating,
          'review' => $review
        ],
        'message_points' => ['title' => 'Congratulations ...', 'message' => 'You get 10 coins']
      ];
      echo json_encode(responseAPI('success', $result));
    }
  } catch (\Throwable $th) {
    //throw $th;
    $connection->rollback();
    echo json_encode(responseAPI('error', $th->getMessage() . " at line " . $th->getLine()));
  }
} else {
  echo 'Access denied';
}
