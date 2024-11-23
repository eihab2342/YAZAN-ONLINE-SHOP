<?php
    session_start();
    require '../config/connection.php';
    require '../config/functions.php';
    $pageTitle = 'YAZAN | طلباتي';
    $user_id = $_SESSION['userID'];
?>

<title><?php echo getTitle($pageTitle); ?></title>
<?php
    // جلب العناصر من سلة المشتريات
    $cart_items = [];
    if (isset($_SESSION['userID'])) {
        $user_id = $_SESSION['userID'];
        
        // عملية الحذف
        if (isset($_POST['remove'])) {
            $cart_id = $_POST['cart_id'];
            $delete_query = "DELETE FROM cart WHERE cart_id = '$cart_id' AND userID = '$user_id'";
            $delete_result = mysqli_query($conn, $delete_query);
            // if ($delete_result) {
                // showAlerts("تم ح    ف المنتج بنجاح")
                // echo '<script>alert("تم حذف المنتج من السلة بنجاح."); window.location.href="cart.php";</script>';
            // } else {
                // echo '<script>alert("حدث خطأ أثناء الحذف.");</script>';
            // }
        }

        // جلب محتويات السلة
        $query = "SELECT * FROM cart WHERE userID = '$user_id'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $cart_items[] = $row;
            }
        }
    } else {
        showAlerts(null, "يرجى تسجيل الدخول أولاً.", "../login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .cart-page {
            margin-top: 50px;
        }
        .cart-summary {
            margin-top: 30px;
        }
        .order-summary-table td, .order-summary-table th {
            text-align: right;
        }
        .remove-icon {
            color: #dc3545;
            font-size: 20px;
            cursor: pointer;
        }
        .remove-icon:hover {
            color: #c82333;
        }
        .product-image {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>

<a href="index.php" class="btn btn-outline-secondary position-absolute" style="top: 20px; left: 20px;">
    <i class="fas fa-arrow-left"></i> 
</a>

<div class="container cart-page">
    <h2 class="text-center">Your Cart</h2>

    <div class="col-md-12">
        <h3>Order Summary</h3>
        <table class="table table-bordered order-summary-table">
            <tr>
                <th>Item</th>
                <th>Image</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php 
            $total_price = 0; // متغير لحساب الإجمالي
            if (count($cart_items) > 0) { 
                foreach ($cart_items as $cart_item) { 
                    $item_total = $cart_item['product_price'] * $cart_item['quantity'];
                    $total_price += $item_total;
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($cart_item['product_name']) . '</td>';
                    $product_image = htmlspecialchars($cart_item['product_image']);
                    $image_path = '../uploads/img/' . $product_image;

                    //بنشوف لو الصورة موجودة ولا لا
                    if (!file_exists($image_path) || empty($product_image)) {
                        $image_path = '../uploads/img/default.png'; 
                    }

                    echo '<td><img src="' . $image_path . '" class="product-image" alt="Product Image"></td>';
                    echo '<td>' . htmlspecialchars($cart_item['product_price']) . '</td>';
                    echo '<td>' . htmlspecialchars($cart_item['quantity']) . '</td>';
                    echo '<td>' . htmlspecialchars($item_total) . '</td>';
                    echo '<td>
                            <form method="POST" action="">
                                <input type="hidden" name="cart_id" value="' . htmlspecialchars($cart_item['cart_id']) . '">
                                <button type="submit" name="remove" class="remove-icon btn btn-sm"><i class="fa-solid fa-delete-left"></i></button>
                            </form>
                        </td>';
                    echo '</tr>';
                }  
            } else {
                echo '<tr><td colspan="6" class="text-center">لا يوجد منتجات تمت إضافتها للعربة</td></tr>';
            }
            ?>
        </table>

        <tr>
            <td colspan="5" class="text-end"><strong>Total</strong></td>
            <td><strong><?php echo htmlspecialchars(number_format($total_price)) ?> EG</strong></td>
        </tr>

        <a href="check_out.php" class="btn btn-warning w-100 my-4 <?php echo (count($cart_items) == 0) ? 'disabled' : ''; ?>">
            Proceed to Checkout
        </a>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/bootstrap-icons.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>
</html>
