<?php
session_start();
require '../config/connection.php';

$user_id = isset($_COOKIE['userID']) ? $_COOKIE['userID'] : $_SESSION['userID'];
if (!$user_id) {
    header("location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coupon_code = mysqli_real_escape_string($conn, $_POST['coupon_code']);
    $original_price = floatval($_POST['original_price']);

    $coupon_query = mysqli_query($conn, "SELECT * FROM coupons WHERE coupon_code = '$coupon_code'");

    if ($coupon_query && mysqli_num_rows($coupon_query) > 0) {
        $coupon = mysqli_fetch_assoc($coupon_query);
        $coupon_id = $coupon['id'];
        $expiry_date = $coupon['expiry_date'];
        $discount_value = floatval($coupon['discount_value']);
        $max_discount = floatval($coupon['max_discount']);
        $status = $coupon['status'];

        if ($status === 'active') {
            if ($expiry_date >= date('Y-m-d')) {
                $coupon_usage_query = mysqli_query($conn, "SELECT * FROM coupon_usage WHERE coupon_id = '$coupon_id' AND user_id = '$user_id'");

                if ($coupon_usage_query && mysqli_num_rows($coupon_usage_query) > 0) {
                    $coupon_usage = mysqli_fetch_assoc($coupon_usage_query);
                    $coupon_used_at = $coupon_usage['used_at'];
                    echo json_encode(['status' => 'error', 'message' => '  لقد استخدمت الكوبون بالفعل في.' . $coupon_used_at]);
                } else {
                    $insert_usage_query = mysqli_query($conn, "INSERT INTO coupon_usage (user_id, coupon_id, used_at) VALUES ('$user_id', '$coupon_id', NOW())");

                    if ($insert_usage_query) {
                        $discount_amount = ($original_price * $discount_value) / 100;

                        //عشان اضمن ان الحد الاقصي للخصم لا يتجاز الحد الذى حددة الادمن
                        if ($discount_amount > $max_discount) {
                            $discount_amount = $max_discount;
                        }

                        $final_price = $original_price - $discount_amount;

                        echo json_encode([
                            'status' => 'success',
                            'message' => 'تم تطبيق الكوبون بنجاح!',
                            'final_price' => $final_price,
                            'discount' => $discount_amount
                        ]);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء تطبيق الكوبون.']);
                    }
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'تم انتهاء فترة صلاحية الكوبون.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'تم إلغاء تفعيل الكوبون.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'كود الكوبون غير صالح.']);
    }
}
