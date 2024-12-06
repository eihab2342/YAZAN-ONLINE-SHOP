<?php
session_start();
require '../assets/header.php';
require '../config/connection.php';
require '../config/functions.php';
?>

<title><?php $pageTitle = 'YAZAN | Invoice';
        echo getTitle($pageTitle) ?></title>
<?php
// بنتأكد من أن order_id موجود في الرابط
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id']; // استلام order_id من الرابط

    $sql = "SELECT o.order_id, u.username, u.full_name, u.email, u.phone_num, 
                   p.name AS name, p.price, oi.quantity, o.total_amount, 
                   o.order_date, o.status
            FROM orders o
            JOIN users_data u ON o.userID = u.userID
            JOIN order_items oi ON o.order_id = oi.order_id
            JOIN products_data p ON oi.product_id = p.id
            WHERE o.order_id = $order_id";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        $order = mysqli_fetch_assoc($result);

        $order_id = $order['order_id'];
        $username = $order['username'];
        $full_name = $order['full_name'];
        $email = $order['email'];
        $phone_num = $order['phone_num'];
        $product_name = $order['name'];
        $quantity = $order['quantity'];
        $order_date = $order['order_date'];
        $product_price = $order['price'];
        $total_amount = $product_price * $quantity;
        $status = $order['status'];
    } else {
        echo "لا توجد بيانات للطلب";
        exit;
    }

    mysqli_close($conn);
} else {
    echo "معرف الطلب غير محدد.";
    exit;
}
?>


<?php

// require '../assets/header.php';
?>
<h1 class="text-center text-warning m-4">Yazan Online Shop</h1>
<div class="container text-dark" style="direction: rtl;">
    <h3 class="text-center my-4 text-dark">فاتورة</h3>

    <div class="row text-dark">
        <div class="col-md-6">
            <h4 class="text-dark">تفاصيل المستخدم : </h4>
            <div class="m-4">
                <p><strong>الاسم : </strong><?php echo $order['full_name']; ?></p>
                <p><strong>اسم المستخدم : </strong><?php echo $order['username']; ?></p>
                <p><strong>البريد الإلكتروني : </strong><?php echo $order['email']; ?></p>
                <p><strong>رقم الهاتف : </strong><?php echo $order['phone_num']; ?></p>
            </div>
            <div class="col-md-6">
                <h4 class="text-dark">تفاصيل الطلب</h4>
                <p><strong>تاريخ الطلب : </strong><?php echo $order['order_date']; ?></p>
                <p><strong>حالة الطلب : </strong><?php echo $order['status']; ?></p>
            </div>
        </div>
    </div>

    <h4 class="text-dark">تفاصيل المنتجات</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>اسم المنتج</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>المبلغ الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-dark">
                <td><?php echo $order['name']; ?></td>
                <td><?php echo $order['quantity']; ?></td>
                <td><?php echo $order['price']; ?> جنيه</td>
                <td><?php echo $total_amount ?> جنيه</td>
            </tr>
        </tbody>
    </table>

    <h3 class="text-right text-dark">المجموع الكلي: <?php echo $total_amount + ($total_amount * 0.05); ?> جنيه</h3>

    <div class="text-center">
        <button class="btn btn-success mb-4 d-print-none" onclick="window.print()">طباعة الفاتورة</button>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../uploads/lib/chart/chart.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="../uploads/lib/easing/easing.min.js"></script>
<script src="../uploads/lib/waypoints/waypoints.min.js"></script>
<script src="../uploads/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="../uploads/lib/tempusdominus/js/moment.min.js"></script>
<script src="../uploads/lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="../uploads/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../uploads/js/main.js"></script>
</body>

</html>