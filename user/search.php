<?php
session_start();
include('../config/connection.php');

// الحصول على الاستعلام من المتغير GET
$query = isset($_GET['query']) ? $_GET['query'] : '';

if (!empty($query)) {
    // تحويل النص المدخل إلى lowercase لإجراء مقارنة غير حساسة لحالة الأحرف
    $query = strtolower($query);
    $query = "%" . $query . "%"; // إضافة الـ "%" للبحث الجزئي

    // الاستعلام لاستخدام LIKE مع جملة 'OR' لتحسين البحث عن الكلمات المفتاحية (مثل "بامبرز")
    $sql = "SELECT id, name FROM products_data WHERE LOWER(name) LIKE ? OR LOWER(keywords) LIKE ?";  // إذا كنت تستخدم كلمات مفتاحية

    // إعداد الاستعلام
    if ($stmt = $conn->prepare($sql)) {
        // ربط المتغيرات
        $stmt->bind_param("ss", $query, $query); // تم ربط نفس المتغير للبحث في `name` و `keywords`
        $stmt->execute();
        $result = $stmt->get_result();

        // إنشاء مصفوفة لتخزين المنتجات التي تم العثور عليها
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        // إرجاع النتيجة بتنسيق JSON
        echo json_encode($products);
    } else {
        // إذا فشل الاستعلام
        echo json_encode([]);
    }
} else {
    // إذا لم يكن هناك استعلام
    echo json_encode([]);
}
