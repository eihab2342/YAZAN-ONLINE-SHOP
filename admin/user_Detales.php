<?php
session_start();
require '../assets/header.php';
require '../config/connection.php';
require '../config/functions.php';

$pageTitle = 'Admin | User Details';

$userID = isset($_GET['userID']) ? $_GET['userID'] : showAlerts(null, "User Not Found", "total_users.php");

$query = "
    SELECT 
        users_data.userID, 
        users_data.full_name, 
        users_data.username, 
        users_data.phone_num, 
        users_data.created_at AS user_created_at,

        orders.order_id, 
        orders.status,
        orders.shipping_address,
        orders.quantity,
        orders.total_amount,
        orders.payment_method,
        orders.created_at AS order_created_at,
        orders.product_id,

        products_data.id AS product_id,
        products_data.name AS product_name,
        products_data.price

    FROM 
        users_data 
    LEFT JOIN 
        orders 
    ON 
        users_data.userID = orders.userID 
    LEFT JOIN 
        products_data
    ON 
        orders.product_id = products_data.id
    WHERE 
        users_data.userID = '$userID'
";

$result = mysqli_query($conn, $query);

if ($result) {
    // echo "BRAVOOOOOOOOO";
    $user = mysqli_fetch_assoc($result);
    $orders = []; 

    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;  
    }
}  else {
    showAlerts(null, "Error fetching user data", null);
}
?>

    <title><?php echo getTitle($pageTitle); ?></title>

    <div class="container-fluid position-relative d-flex p-0">
                <!-- Spinner Start -->
                <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->

                <!-- Sidebar Start -->
                <?php  require_once '../assets/sideBar.php'; ?>
                <!-- Sidebar End -->

                <!-- Content Start -->
        <div class="content">
                            <!-- Navbar Start -->
                            <?php  require_once '../assets/navBar.php'; ?>
                            <!-- Navbar End -->

            <div class="container my-4">
            <h4 class="mb-3 text-center">بيانات المستخدم</h4>
                <div class="user-info table-responsive">
                    <table class="table table-striped table-bordered table-responsive text-center">
                        <thead class="table-primary">
                        <tr>
                            <th>رقم المستخدم</th>
                            <th>الاسم</th>
                            <th>اسم المستخدم</th>
                            <th>رقم التليفون</th>
                            <th>تاريخ انشاء الحساب</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-white">
                            <td><?php echo $user['userID']; ?></td> 
                            <td><?php echo $user['full_name']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['phone_num']; ?></td>
                            <td><?php echo $user['user_created_at']; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- جدول الطلبات -->
            <h4 class="my-3 text-center">الطلبات</h4>
                <div class="order-info table-responsive mt-4">
                    <table class="table table-striped table-bordered table-responsive text-center">
                        <thead class="table-secondary">
                        <tr>
                            <th>رقم الطلب</th>
                            <th>حالة الطلب</th>
                            <th>اسم المتتج</th>
                            <th>سعرالمنتج</th>
                            <th>الكمية</th>
                            <th>الإجمالي</th>
                            <th>تارخ الطلب</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($orders)) : ?>
                            <?php foreach ($orders as $order) : ?>
                                <tr class="text-white">
                                    <td><?php echo $order['order_id']; ?></td>
                                    <td><span class="badge bg-success"><?php echo $order['status']; ?></span></td>
                                    <td><?php echo $order['product_name']; ?></td>
                                    <td><?php echo $order['price']; ?></td>
                                    <td><?php echo $order['quantity']; ?></td>
                                    <td><?php echo $order['price'] * $order['quantity'] + (0.05);  ; ?></td>
                                    <td><?php echo $order['order_created_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3" class="text-center">لا توجد طلبات</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>


                <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
            </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
            <!-- JavaScript Libraries -->
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