<?php


function responseAPI($status, $result)
{
  if ($status == 'success') {
    $response      = [
      'status'        => $status,
      'timestamp'     => date("Y-m-d H:i:s"),
      'result' => $result
    ];
  } else {
    $response      = [
      'status'        => $status,
      'timestamp'     => date("Y-m-d H:i:s"),
      'error_message' => $result
    ];
  }

  return $response;
}


function getRoleName($connection, $role_id)
{
  $query_select_role = $connection->query("SELECT name FROM role WHERE id='$role_id'");
  $result_select_role = $query_select_role->fetch_array();

  return $result_select_role['name'];
}

function getRatingProduct($connection, $productID)
{
  $query_review = $connection->query("SELECT SUM(rating) as rating , COUNT(rating) as count  FROM reviews WHERE product_id = '$productID'");
  $result_review = $query_review->fetch_array();
  $result_value = null;


  if (!$result_review['rating'] == 0 && !$result_review['count'] == 0) {
    $rating     = (int)$result_review['rating'] ?? 0;
    $count      = (int)$result_review['count'] ?? 0;
    $result_value = number_format($rating / $count, 1, '.');
  }

  return $result_value;
}

function getPointUser($connection, $user_id)
{
  $query_get_point = $connection->query("SELECT point FROM points WHERE user_id = '$user_id'");
  $points = $query_get_point->fetch_assoc();
  return $points['point'] ?? 0;
}

function howToUseVoucher($name_voucher)
{
  return "1. Visit the place listed on AISmart\r\n2. Go to My Voucher page\r\n3. Select vouchers '" . $name_voucher . "'\r\n4. Click the 'Exchange Voucher' button\r\n5. Enter the amount spent\r\n6. Click the 'Confirm Exchange' button\r\n7. Congratulations you have used the voucher and your shopping amount has been reduced according to the amount of the discount on the voucher";
}

function createInbox($connection, $title, $description, $user_id)
{
  $connection->query("INSERT INTO notifications (title, description, user_id, is_read, created_at) VALUES ('$title', '$description','$user_id', 0, NOW())");
}
