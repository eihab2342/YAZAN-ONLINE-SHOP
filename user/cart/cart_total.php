<?php

include('../config/connection.php');

$user_id = isset($_SESSION['userID']) ? $_COOKIE['userID'] : $_SESSION['userID'];
$query = mysqli_query($conn, "SELECT * FROM cart WHERE userID = '$user_id'");

$cart_total = 0;
while ($row = mysqli_fetch_assoc($query)) {
    $cart_total += $row['product_price'] * $row['quantity'];
}

// إرجاع الإجمالي كاستجابة JSON
echo json_encode(['cart_total' => $cart_total]);
