<?php
session_start();
require '../config/connection.php';
require '../config/functions.php';
$pageTitle = 'YAZAN | عملية اتمام طلب منتج';
$user_id = isset($_COOKIE['userID']) ? $_COOKIE['userID'] : $_SESSION['userID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // استلام بيانات الشحن من النموذج
        $full_name = mysqli_real_escape_string($conn, $_POST['fullName']);
        $phone = mysqli_real_escape_string($conn, $_POST['phoneNumber']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $shipping_address = mysqli_real_escape_string($conn, $_POST['address']);

        // حساب إجمالي الطلب
        $total_amount = 0;
        $cart_query = "SELECT * FROM cart WHERE userID = '$user_id'";
        $cart_result = mysqli_query($conn, $cart_query);

        while ($cart_item = mysqli_fetch_assoc($cart_result)) {
                $product_id = $cart_item['id'];
                $quantity = $cart_item['quantity'];
                $price = $cart_item['product_price'];
                $item_total = $quantity * $price;
                $total_amount += $item_total;
        }

        // إنشاء استعلام لإضافة الطلب إلى جدول orders
        $query = "INSERT INTO orders (userID, full_name, phone_num, shipping_address, city, total_amount, payment_status) 
              VALUES ('$user_id', '$full_name', '$phone', '$address', '$city', '$total_amount', ' معلق')";

        if (mysqli_query($conn, $query)) {
                $order_id = mysqli_insert_id($conn);  // الحصول على الـ order_id الجديد

                // إدخال تفاصيل المنتجات في جدول order_items
                $cart_result = mysqli_query($conn, $cart_query);
                while ($cart_item = mysqli_fetch_assoc($cart_result)) {
                        $product_id = $cart_item['id'];
                        $quantity = $cart_item['quantity'];
                        $price = $cart_item['product_price'];
                        $item_total = $quantity * $price;

                        // إدخال بيانات المنتج في جدول order_items
                        $order_item_query = "INSERT INTO order_items (order_id, product_id, quantity, price, item_total) 
                                 VALUES ('$order_id', '$product_id', '$quantity', '$price', '$item_total')";
                        mysqli_query($conn, $order_item_query);
                }

                // حذف العناصر من السلة بعد إتمام الطلب
                // $delete_cart_query = "DELETE FROM cart WHERE userID = '$user_id'";
                // mysqli_query($conn, $delete_cart_query);

                // توجيه المستخدم إلى صفحة الدفع أو صفحة تأكيد الطلب
?>
                <!-- نموذج لإرسال order_id عبر POST إلى paymob.php -->
                <form action="../payments/paymob.php" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        <!-- <button type="submit" class="btn btn-primary">انتقل إلى الدفع</button> -->
                </form>
<?php
                header('Location: ../payments/index.php');  // أو أي صفحة ترغب في توجيه المستخدم إليها بعد إتمام الطلب
                exit;
        } else {
                echo 'حدث خطأ أثناء إضافة الطلب';
        }
}
?>