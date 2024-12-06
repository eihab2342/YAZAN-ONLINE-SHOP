<?php
$data = file_get_contents('php://input');
$decoded = json_decode($data, true);

// تحقق من حالة الدفع
if ($decoded['type'] == 'TRANSACTION' && $decoded['obj']['success']) {
    // الدفع ناجح
    file_put_contents('payment_logs.txt', "نجاح الدفع: " . json_encode($decoded) . PHP_EOL, FILE_APPEND);
} else {
    // الدفع فشل
    file_put_contents('payment_logs.txt', "فشل الدفع: " . json_encode($decoded) . PHP_EOL, FILE_APPEND);
}
