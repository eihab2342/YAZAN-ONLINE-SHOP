<?php
    require '../assets/header.php';
    require '../config/connection.php';
    require '../config/functions.php';
?>

<title><?php $pageTitle = 'Admin | Order Detailes'; echo getTitle($pageTitle) ?></title>

<div class="container-fluid position-relative d-flex p-0 mb-3">
    <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div> 
        </div>  -->
    <!-- Spinner End -->

        <div class="content">
                
            <?php 
                require '../assets/sideBar.php' ;

                require '../assets/navBar.php' ;

                    if (isset($_GET['order_id'])) {
                        $order_id = $_GET['order_id'];

                        $sql = "SELECT o.order_id, oi.quantity, o.order_date, o.total_amount, o.status,
                                        p.name AS name, p.price, 
                                        u.userID, u.username, u.full_name, u.phone_num
                                FROM orders o
                                JOIN users_data u ON o.userID = u.userID
                                JOIN products_data p ON o.product_id = p.id
                                JOIN order_items oi ON o.order_id = oi.order_id
                                WHERE o.order_id = $order_id";

                        $result = mysqli_query($conn, $sql);

                        if ($row = mysqli_fetch_assoc($result)) {
                                $order_id = $row['order_id'];
                                $username = $row['username'];
                                $full_name = $row['full_name'];
                                $phone_num = $row['phone_num'];
                                $product_name = $row['name'];
                                $quantity = $row['quantity'];
                                $order_date = $row['order_date'];
                                $product_price = $row['price'];
                                $total_amount = $product_price * $quantity;
                                $status = $row['status'];
                        } else {
                            echo "الطلب غير موجود.";
                            exit;
                        }
                    } else {
                        echo "معرف الطلب غير محدد.";
                        exit;
                    }
            ?>


                    <div class="container-fluid bg-dark">
                            <h2 class="text-center my-4">تفاصيل الطلب</h2>

                            <div class="row">
                                <div class="col-md-6 mx-auto"  style="direction: rtl;">
                                    <div class="card bg-dark text-white">
                                        <div class="card-header">
                                            <h4 class="card-title">طلب رقم #<?php echo $order_id; ?></h4>
                                        </div>
                                        <div class="card-body">
                                            <table class="table text-white">
                                                <tr>
                                                    <th>اسم العميل</th>
                                                    <td><?php echo $full_name ?></td>
                                                </tr>
                                                <tr>
                                                    <th>اسم المستخدم</th>
                                                    <td><?php echo $username ?></td>
                                                </tr>
                                                <tr>
                                                    <th>رقم التليفون</th>
                                                    <td><?php echo $phone_num ?></td>
                                                </tr>
                                                <tr>
                                                    <th>المنتج</th>
                                                    <td><?php echo $product_name ?></td>
                                                </tr>
                                                <tr>
                                                    <th>الكمية</th>
                                                    <td><?php echo $quantity ?></td>
                                                </tr>
                                                <tr>
                                                    <th>تاريخ الطلب</th>
                                                    <td><?php echo $order_date ?></td>
                                                </tr>
                                                <tr>
                                                    <th>سعر المنتج </th>
                                                    <td><?php echo $product_price; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>المبلغ الكلي</th>
                                                    <td><?php echo $total_amount; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>الحالة</th>
                                                    <td><span class="badge bg-success"><?php echo $status; ?></span></td>
                                                </tr>
                                            </table>
                                            <a href="orders.php" class="btn btn-primary mx-3">العودة إلى قائمة الطلبات</a>
                                            <a href="invoice.php?order_id=<?php echo  $order_id ?>" class="btn btn-success mx-3"> عرض الفاتورة </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    </div>
        </div>
</div>

        <?php // require '../assets/footer.php'; ?>


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