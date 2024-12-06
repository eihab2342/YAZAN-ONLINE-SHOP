<?php
require_once 'paymob.php';

// إعداد بيانات Paymob
$api_key = "ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TVRBd09UVTVNaXdpYm1GdFpTSTZJbWx1YVhScFlXd2lmUS51ckZaOGJHaHl2dlMtS0hwalNpZTBlSmlxYl9jZ2hIVEV2ZnlQbG5rVWQxZmREUk5UMmg0RlRHTGxBbFVHblNGVmZQZFhGSzlaaWVBYW5MRi1mQWJwdw==";
$merchant_id = "1009592";
$integration_id = "4889972";

// تسجيل الدخول للحصول على auth_token
$auth_response = authenticatePaymob($api_key);
$auth_token = $auth_response['token'];

// إنشاء طلب جديد
$order_response = createOrder($auth_token, $merchant_id, 10000); // 100 جنيه
$order_id = $order_response['id'];

// الحصول على رابط الدفع
$payment_key_response = getPaymentKey($auth_token, $order_id, 10000, $integration_id);
$payment_token = $payment_key_response['token'];

// توجيه المستخدم لبوابة الدفع
$iframe_url = "https://accept.paymob.com/api/acceptance/iframes/884932?payment_token=$payment_token";
header("Location: $iframe_url");
