<?php
session_start();
include('../config/connection.php'); // تأكد من وجود الاتصال بقاعدة البيانات هنا

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // استخراج البيانات من الطلب
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $quantity = $_POST['quantity'] ? $_POST['quantity'] : 1 ;
    $product_image = $_POST['product_image'];

    if (isset($_SESSION['userID'])) {
        $user_id = $_SESSION['userID'];

        $check_query = "SELECT * FROM cart WHERE userID = '$user_id' AND id = '$product_id'";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            $update_query = "UPDATE cart SET quantity = quantity + $quantity WHERE userID = '$user_id' AND id = '$product_id'";
            mysqli_query($conn, $update_query);
        } else {
            $insert_query = "INSERT INTO cart (userID, id, product_name, product_price, quantity, product_image) 
                             VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$quantity', '$product_image')";
            mysqli_query($conn, $insert_query);
        }
        echo "تم إضافة المنتج إلى العربة!";
    } else {
        echo "يرجى تسجيل الدخول أولاً.";
    }
}
?>
