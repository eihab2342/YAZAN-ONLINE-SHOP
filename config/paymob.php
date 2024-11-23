<?php
// رابط التوكين الخاص بـ Paymob
$auth_url = "https://accept.paymobsolutions.com/api/auth/tokens";

// البيانات المطلوبة (API Key الخاص بك)
$auth_data = [
    "api_key" => "ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TVRBd05qSTNNU3dpYm1GdFpTSTZJbWx1YVhScFlXd2lmUS5nRTQ5MEROcGFtbk1PX09tRzM4SWI3SHV3TFduaDdrT1FFRTRicldlLVJia1RoZEN3YjB5QW1KX2hJUEZpMnE1bkxCMkQ4a2VTNGh2LVI2RDJ6RmV0dw=="  // ضع مفتاح API هنا
];

// إعداد cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $auth_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($auth_data));

// تنفيذ الطلب
$response = curl_exec($ch);
curl_close($ch);

// إذا حدث خطأ، اطبع الخطأ
if($response === false) {
    echo "Error: " . curl_error($ch);
} else {
    // فك JSON
    $response_data = json_decode($response, true);
    var_dump($response_data);  // طباعة البيانات للحصول على معلومات مفصلة
}
?>
