<?php
session_start();
require '../config/connection.php';

$user_id = isset($_COOKIE['userID']) ? $_COOKIE['userID'] : $_SESSION['userID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($user_id)) {
    $order_id = $_POST['order_id'];
}

$query = "SELECT * FROM orders WHERE userID = '$user_id'";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $order = mysqli_fetch_assoc($result);
    $order_id = $order['order_id'];
}

$item_query = mysqli_query($conn, "SELECT oi.*, p.name, p.price
                                   FROM order_items oi
                                   JOIN products_data p ON oi.product_id = p.id
                                   WHERE oi.order_id = '$order_id'");
if ($item_query) {
    $orderItems = [];
    while ($row = mysqli_fetch_assoc($item_query)) {
        $order_items[] = $row;
    }
}

//تجهيز بيانات العميل اللازمة لإتمام عملية الدفع
$billingData = [
    'full_name' => $order['full_name'],
    'phone_num' => $order['phone_num'],
    'city' => $order['city'],
    'shipping_address' => $order['shipping_address'],
    'total_price' => $order['total_amount'],
    'order_date' => $order['order_date']
];

//تجهيز بيانات المنتجات 
$items = [];
foreach ($order_items as $item) {
    $items[] = [
        'product_name' => $item['name'],
        'product_price' => $item['price'],
        'quantity' => $item['quantity']
    ];
}

//تجهيز المبلغ الكلي للطلب
$Total_Amount_in_Cents = $order['total_amount'] * 100; //must be in cents