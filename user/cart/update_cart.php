<?php
session_start();
require '../config/connection.php';

$user_id = isset($_COOKIE['userID']) ? $_COOKIE['userID'] : $_SESSION['userID'];
if (!$user_id) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action == "update_quantity") {
        $cart_id = intval($_POST['cart_id']);
        $quantity = intval($_POST['quantity']);

        if ($quantity < 1) {
            echo json_encode(['success' => false, 'message' => 'الكمية غير صحيحة']);
            exit();
        }

        // استخدام Prepared Statement لحماية البيانات
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ? AND userID = ?");
        $stmt->bind_param("iii", $quantity, $cart_id, $user_id);

        if ($stmt->execute()) {
            $product_query = $conn->prepare("SELECT product_price FROM cart WHERE cart_id = ?");
            $product_query->bind_param("i", $cart_id);
            $product_query->execute();
            $result = $product_query->get_result();
            $product = $result->fetch_assoc();

            $product_price = $product['product_price'];
            $new_price = $product_price * $quantity;

            echo json_encode(['success' => true, 'new_price' => $new_price, 'message' => 'تم تحديث الكمية']);
        } else {
            echo json_encode(['success' => false, 'message' => 'حدث خطأ في التحديث']);
        }
    }

    if ($action == "remove_product") {
        $cart_id = intval($_POST['cart_id']);

        $stmt = $conn->prepare("DELETE FROM cart WHERE cart_id = ? AND userID = ?");
        $stmt->bind_param("ii", $cart_id, $user_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'تم حذف المنتج من السلة']);
        } else {
            echo json_encode(['success' => false, 'message' => 'لم يتم الحذف']);
        }
    }
}
