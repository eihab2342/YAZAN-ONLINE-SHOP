<?php
require '../config/connection.php';

// بيانات المستخدم
$user_id = isset($_COOKIE['userID']) ? $_COOKIE['userID'] : (isset($_SESSION['userID']) ? $_SESSION['userID'] : null);

// تحقق من وجود user_id
if (!$user_id) {
    echo "User is not logged in.";
    exit;
}

// استعلام للحصول على بيانات الطلب
$order_query = "SELECT o.*, u.*
                FROM orders o
                JOIN users_data u ON o.userID = u.userID
                WHERE o.userID = '$user_id' ORDER BY o.order_id DESC LIMIT 1";
$order_result = mysqli_query($conn, $order_query);

if ($order_result && mysqli_num_rows($order_result) > 0) {
    $order = mysqli_fetch_assoc($order_result);
    $order_id = $order['order_id'];
    $total_amount = $order['total_amount'] * 100; // المبلغ بالـ cents
} else {
    echo "Order not found.";
    exit;
}

// استعلام للحصول على بيانات المنتجات المرتبطة بالطلب
$item_query = "SELECT oi.*, p.name, p.price
               FROM order_items oi 
               JOIN products_data p ON oi.product_id = p.id 
               WHERE oi.order_id = '$order_id'";
$item_result = mysqli_query($conn, $item_query);

if ($item_result && mysqli_num_rows($item_result) > 0) {
    $items = [];
    while ($row = mysqli_fetch_assoc($item_result)) {
        $items[] = [
            "name" => $row['name'],
            "amount_cents" => $row['price'] * 100,
            "quantity" => $row['quantity']
        ];
    }
} else {
    echo "No items found for this order.";
    exit;
}

// بيانات الفوترة
$billingData = [
    "apartment" => "NA",
    "email" => $order['email'],
    "floor" => "NA",
    "first_name" => $order['full_name'], // تعديل حسب البنية
    "last_name" => "Customer", // إذا لم يكن الاسم الأخير موجوداً
    "phone_number" => $order['phone_num'],
    "city" => $order['city'],
    "country" => "EGY",
    "street" => $order['shipping_address'],
    "building" => "NA",
    "postal_code" => "NA"
];

// 1. تسجيل الدخول للحصول على auth_token
$api_key = "ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TVRBd09UVTVNaXdpYm1GdFpTSTZJbWx1YVhScFlXd2lmUS51ckZaOGJHaHl2dlMtS0hwalNpZTBlSmlxYl9jZ2hIVEV2ZnlQbG5rVWQxZmREUk5UMmg0RlRHTGxBbFVHblNGVmZQZFhGSzlaaWVBYW5MRi1mQWJwdw==";
$auth_response = authenticatePaymob($api_key);
$auth_token = $auth_response['token'];

// 2. إنشاء الطلب في Paymob
$merchant_id = "1009592";
$order_response = createOrder($auth_token, $merchant_id, $total_amount, $items);
$paymob_order_id = $order_response['id'];

// 3. الحصول على مفتاح الدفع
$integration_id = "4890041"; //    4889972
$payment_key_response = getPaymentKey($auth_token, $paymob_order_id, $total_amount, $integration_id, $billingData);
$payment_token = $payment_key_response['token'];

// 4. توجيه المستخدم لبوابة الدفع
$iframe_url = "https://accept.paymob.com/api/acceptance/iframes/884932?payment_token=$payment_token";
header("Location: $iframe_url");

// الدوال المساعدة
function authenticatePaymob($api_key)
{
    $url = "https://accept.paymob.com/api/auth/tokens";
    $data = ["api_key" => $api_key];
    return sendPostRequest($url, $data);
}

function createOrder($auth_token, $merchant_id, $amount_cents, $items)
{
    $url = "https://accept.paymob.com/api/ecommerce/orders";
    $data = [
        "auth_token" => $auth_token,
        "delivery_needed" => "false",
        "amount_cents" => $amount_cents,
        "currency" => "EGP",
        "merchant_order_id" => uniqid(),
        "items" => $items
    ];
    return sendPostRequest($url, $data);
}

function getPaymentKey($auth_token, $order_id, $amount_cents, $integration_id, $billingData)
{
    $url = "https://accept.paymob.com/api/acceptance/payment_keys";
    $data = [
        "auth_token" => $auth_token,
        "amount_cents" => $amount_cents,
        "currency" => "EGP",
        "order_id" => $order_id,
        "billing_data" => $billingData,
        "integration_id" => $integration_id
    ];
    return sendPostRequest($url, $data);
}

function sendPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}


?>



<?php
// التحقق من حالة الدفع عند العودة من Paymob
$success = isset($_GET['success']) ? $_GET['success'] : 'false';
$order_id = isset($_GET['order']) ? $_GET['order'] : '';

// إذا كانت العملية ناجحة
if ($success == 'true') {
    // تحديث حالة الدفع في قاعدة البيانات
    $update_query = "UPDATE orders 
                     SET payment_status = 'تم الدفع' 
                     WHERE order_id = '$order_id'";

    if (mysqli_query($conn, $update_query)) {
        echo "تم الدفع بنجاح!";
    } else {
        echo "خطأ في تحديث حالة الدفع.";
    }
} else {
    echo "فشل الدفع. يرجى المحاولة مرة أخرى.";
}
?>