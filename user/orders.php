<?php
    // session_start();
    require '../config/connection.php';
    require '../config/functions.php';
    // require 'sendEmail.php';
    require 'assets/header.php';
    $pageTitle = 'YAZAN | طلباتي';
    $user_id = $_SESSION['userID'];
?>

<title><?php echo getTitle($pageTitle); ?></title>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> -->
</head>
<body>
    <div class="container py-5">
        <a href="index.php" class="btn btn-outline-secondary position-absolute" style="top: 20px; left: 20px;">
            <i class="fas fa-arrow-left"></i> 
        </a>

        <h2 class="text-center mb-4">طلباتي </h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>اسم المنتج</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>الحالة</th>
                        <th>تاريخ الطلب</th>
                        <th>الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- بيانات الطلبات -->
                    <?php 
                        $query = "SELECT o.*, oi.product_id, oi.quantity, 
                                      p.name AS product_name, p.price AS product_price
                                  FROM orders o
                                  JOIN order_items oi ON oi.order_id = o.order_id
                                  JOIN products_data p ON p.id = oi.product_id
                                  WHERE o.userID = '$user_id'";

                        $order_number = 1;

                        $result = mysqli_query($conn, $query);
                        if($result && mysqli_num_rows($result) > 0) {
                            while($order = mysqli_fetch_assoc($result)) {
                    ?>
                                <tr>
                                    <td><?php echo $order_number ?></td>
                                    <td><?php echo $order['product_name'] ?></td>
                                    <td><?php echo $order['quantity'] ?></td>
                                    <td><?php echo $order['product_price'] ?></td>
                                    <td><span class="badge bg-success"><?php echo $order['status'] ?></span></td>
                                    <td><?php echo $order['order_date'] ?></td>
                                    <td><?php echo $order['quantity'] * $order['product_price'] ?>.00</td>
                                </tr>
                    <?php 
                                $order_number++;
                            } 
                        } else {
                            echo '<tr>
                                    <td colspan="8" class="text-center">
                                        لا يوجد طلبات سابقة لديك.. 
                                        <a href="index.php" class="text-decoration-none">تسوق الآن واستكشف متجرنا</a>
                                    </td>
                                </tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- رابط Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
