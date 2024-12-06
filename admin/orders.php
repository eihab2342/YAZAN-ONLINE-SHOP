<?php
require '../assets/header.php';
require '../config/connection.php';
require '../config/functions.php';

if (!isset($_SERVER['HTTP_REFERER']) || parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != $_SERVER['HTTP_HOST']) {
    showAlerts(null, "الرجاء تسجيل الدخول أولا ", "../login.php");
    exit();
}


?>

<title><?php $pageTitle = 'Admin | Orders Page';
        echo getTitle($pageTitle) ?></title>

<!-- HTML structure remains the same -->

<div class="container-fluid position-relative d-flex p-0">
    <!-- Spinner Start -->
    <!-- <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div> -->
    <!-- Spinner End -->

    <!-- Sidebar Start -->
    <?php require '../assets/sideBar.php' ?>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content" style="background-color: whitesmoke;">
        <!-- Navbar Start -->
        <?php require '../assets/navBar.php' ?>
        <!-- Navbar End -->

        <div class="container-fluid pt-4 px-4 " style="background-color: whitesmoke;">
            <h2 class="text-center mb-4 text-dark">إدارة الطلبات</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم العميل</th>
                            <th>تاريخ الطلب</th>
                            <th>اسم المنتج</th>
                            <th>الكمية</th>
                            <th>المبلغ</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // استعلام لجلب جميع الطلبات
                        $sql = "
                                SELECT 
                                    o.order_id, 
                                    u.username, 
                                    o.order_date,
                                    oi.product_id, 
                                    oi.quantity, 
                                    p.name AS product_name, 
                                    p.price, 
                                    o.status
                                FROM 
                                    orders o
                                JOIN 
                                    users_data u ON o.userID = u.userID
                                JOIN 
                                    order_items oi ON o.order_id = oi.order_id
                                JOIN 
                                    products_data p ON oi.product_id = p.id
                                WHERE 
                                    o.userID = u.userID 
                                ORDER BY 
                                    o.order_date DESC";
                        $result = mysqli_query($conn, $sql);

                        // عرض البيانات
                        while ($order = mysqli_fetch_assoc($result)) {
                            $total_price = $order['price'] * $order['quantity']; // السعر الإجمالي للمنتج
                        ?>
                            <tr>
                                <td><?php echo $order['order_id']; ?></td>
                                <td><?php echo $order['username']; ?></td>
                                <td><?php echo $order['order_date']; ?></td>
                                <td><?php echo $order['product_name']; ?></td>
                                <td><?php echo $order['quantity']; ?></td>
                                <td><?php echo number_format($total_price, 2); ?> جنيه</td>
                                <td>
                                    <select class="form-select status-update bg-white w-75" data-order-id="<?php echo $order['order_id']; ?>">
                                        <?php
                                        $status_options = ['قيد التحضير', 'تم الشحن', 'تم التوصيل', 'في الانتظار'];
                                        foreach ($status_options as $status) {
                                            $selected = ($order['status'] == $status) ? 'selected' : '';
                                            echo '<option value="' . $status . '" ' . $selected . '>' . $status . '</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <a href="order_details.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-info btn-sm">عرض التفاصيل</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-update').change(function() {
            var order_id = $(this).data('order-id');
            var status = $(this).val();

            $.ajax({
                url: 'update_status.php',
                type: 'POST',
                data: {
                    order_id: order_id,
                    status: status
                },
                success: function(response) {
                    alert(response); //رسالة نجاح 
                },
                error: function() {
                    alert("حدث خطأ، لم يتم تحديث الحالة");
                }
            });
        });
    });
</script>

<?php
require '../assets/footer.php';
?>