<?php
require '../config/connection.php';
require '../config/functions.php';

if (isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    if ($conn) {
        $update_sql = $conn->prepare("UPDATE orders SET `status` = ? WHERE `order_id` = ?");
        
        $update_sql->bind_param('si', $status, $order_id);  // 'si' تعني: string للـ status و integer للـ order_id

        if ($update_sql->execute()) {
            echo 'تم تحديث حالة الطلب بنجاح';
        } else {
            showAlerts(null, "فشل تحديث الحالة", "orders.php");
        }
        
        $update_sql->close();
    } else {
        echo "فشل الاتصال بقاعدة البيانات";
    }
} else {
    echo "البيانات غير مكتملة";
}

$conn->close();
?>
