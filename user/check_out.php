<?php
// بدء الجلسة
session_start();
require '../config/connection.php';
require '../config/functions.php';
$user_id = isset($_COOKIE['userID']) ? $_COOKIE['userID'] : $_SESSION['userID'];
if (!$user_id) {
    header("location: ../login.php");
}

$pageTitle = 'YAZAN | عملية اتمام طلب منتج';
// if(!isset($_COOKIE['userID']) || !isset($_SESSION['userID'])) {
//     header("location: ../login.php");
// }
// إذا تم إرسال البيانات عبر AJAX لتحديث الكمية
if (isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    // تحديث الكمية في قاعدة البيانات
    $query = "UPDATE cart SET quantity = '$quantity' WHERE cart_id = '$cart_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // استرجاع البيانات المحدثة لإرجاع الإجمالي الجديد
        $query = "SELECT * FROM cart WHERE cart_id = '$cart_id'";
        $result = mysqli_query($conn, $query);
        $cart_item = mysqli_fetch_assoc($result);

        // حساب الإجمالي الجديد للمنتج
        $item_total = $cart_item['quantity'] * $cart_item['product_price'];

        // حساب الإجمالي لجميع العناصر في السلة
        $total_query = "SELECT SUM(quantity * product_price) AS total_price FROM cart WHERE userID = '$user_id'";
        $total_result = mysqli_query($conn, $total_query);
        $total_row = mysqli_fetch_assoc($total_result);
        $total_price = $total_row['total_price'];

        // إرجاع البيانات كـ JSON
        echo json_encode([
            'item_total' => $item_total,
            'total_price' => $total_price
        ]);
        exit;
    } else {
        echo json_encode(['error' => 'فشل التحديث']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../uploads/img/logo3.jpg" type="image/x-icon">
    <title><?php echo getTitle($pageTitle); ?></title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--   FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body style="overflow-x: hidden;">
    <div class="container my-5">
        <h2 class="text-center mb-4">إتمام الطلب</h2>
        <div class="row">
            <!-- تفاصيل الدفع -->
            <div class="col-lg-8">
                <div class="card p-4 mb-4">
                    <h4 class="mb-3">معلومات الشحن</h4>
                    <form method="POST" action="check_out_proccess.php">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fullName" class="form-label">الاسم الكامل</label>
                                <input type="text" id="fullName" class="form-control" placeholder="أدخل اسمك الكامل" name="fullName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phoneNumber" class="form-label">رقم الهاتف</label>
                                <input type="tel" id="phoneNumber" class="form-control" placeholder="أدخل رقم هاتفك" name="phoneNumber" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">العنوان</label>
                            <input type="text" id="address" class="form-control" placeholder="أدخل عنوانك الكامل" name="address" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="city" class="form-label">المدينة</label>
                                <select id="city" class="form-select" name="city" required>
                                    <option value="salka">سلكا</option>
                                    <option value="baheera">بحقيرة</option>
                                    <option value="hawawsha">الحواوشة</option>
                                    <option value="naqeeta">نقيطة</option>
                                    <option value="nosa">نوسا</option>
                                </select>
                            </div>
                        </div>
                </div>

                <div class="card p-4 w-100">
                    <h4 class="mb-3">طريقة الدفع</h4>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" value="creditCard" checked>
                        <label class="form-check-label" for="creditCard">
                            فيزا / بطاقة إئتمان
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="paypal" value="paypal">
                        <label class="form-check-label" for="paypal">
                            محفظة موبايل
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="cash" value="cash">
                        <label class="form-check-label" for="cash">
                            الدفع عند الاستلام
                        </label>
                    </div>
                </div>
            </div>

            <!-- ملخص الطلب -->

            <div class="col-lg-4" style="margin-top: 40px;">
                <div class="card p-4" style="width: 415px;">
                    <h4 class="mb-3">ملخص الطلب</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">اسم المنتج</th>
                                <th scope="col">الكمية</th>
                                <th scope="col">السعر</th>
                                <th scope="col">الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_price = 0;
                            $result = mysqli_query($conn, "SELECT * FROM cart WHERE userID = '$user_id'");
                            while ($cart_item = mysqli_fetch_assoc($result)) {
                                $item_total = $cart_item['quantity'] * $cart_item['product_price'];
                                $total_price += $item_total;
                                echo ' 
                        <tr>
                            <td>' . $cart_item['product_name'] . '</td>
                            <td>
                                <input type="number" class="form-control quantity" data-cart-id="' . $cart_item['cart_id'] . '" value="' . $cart_item['quantity'] . '" min="1">
                            </td>
                            <td>' . $cart_item['product_price'] . '</td>
                            <td class="item-total" data-cart-id="' . $cart_item['cart_id'] . '">' . $item_total . '</td>
                        </tr>
                    ';
                            }
                            ?>
                        </tbody>
                    </table>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            الإجمالي قبل الخصم <strong id="original-total"><?php echo $total_price ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center" id="discount-row" style="display: none;">
                            الخصم <strong id="discount-amount">0</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            الإجمالي بعد الخصم <strong id="final-total"><?php echo $total_price ?></strong>
                        </li>
                    </ul>
                </div>

                <div class="row my-3 align-items-center">
                    <label for="coupon" class="form-label">كود الكوبون</label>
                    <div class="col-9">
                        <input type="text" id="coupon" class="form-control" placeholder="أدخل كود الكوبون" name="coupon">
                    </div>
                    <div class="col-3">
                        <button class="btn btn-primary w-100" id="apply-coupon">تطبيق</button>
                    </div>
                </div>
                <div id="response-message" class="text-center mt-3"></div>

                <button type="submit" class="btn btn-success w-100 mt-3">
                    <i class="fas fa-credit-card">   اتمام الطلب  </i>
                </button>
            </div>

            <script>
                // تحديث الكمية
                document.querySelectorAll('.quantity').forEach(input => {
                    input.addEventListener('change', function() {
                        let cartId = this.getAttribute('data-cart-id');
                        let quantity = this.value;

                        fetch('cart/update_cart.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: `cart_id=${cartId}&quantity=${quantity}`
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.error) {
                                    alert(data.error);
                                } else {
                                    // تحديث الإجمالي الخاص بالمنتج
                                    let itemTotal = document.querySelector(`.item-total[data-cart-id="${cartId}"]`);
                                    itemTotal.innerText = data.item_total;

                                    // تحديث الإجمالي الكلي
                                    document.getElementById('original-total').innerText = data.total_price;
                                    document.getElementById('final-total').innerText = data.total_price;
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    });
                });

                // تطبيق الكوبون
                document.getElementById("apply-coupon").addEventListener("click", function(e) {
                    e.preventDefault();

                    const couponInput = document.getElementById("coupon").value;
                    const originalTotal = parseFloat(document.getElementById("original-total").innerText);

                    fetch("apply_coupons.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: `coupon_code=${couponInput}&original_price=${originalTotal}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            const messageBox = document.getElementById("response-message");
                            messageBox.innerHTML = data.message;
                            messageBox.className = data.status === "success" ? "text-success" : "text-danger";

                            if (data.status === "success") {
                                const discountAmount = originalTotal - data.final_price;
                                const updatedTotalPrice = data.final_price;

                                // تحديث قيم الخصم والإجمالي بعد الخصم
                                document.getElementById("discount-amount").innerText = discountAmount.toFixed(2);
                                document.getElementById("final-total").innerText = updatedTotalPrice.toFixed(2);

                                // إظهار صف الخصم
                                document.getElementById("discount-row").style.display = "flex";
                            }
                        })
                        .catch(error => console.error("Error:", error));
                });
            </script>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $cart_id = $_POST['cart_id'];
                $quantity = $_POST['quantity'];

                if ($quantity <= 0) {
                    echo json_encode(['error' => 'الكمية يجب أن تكون أكبر من صفر.']);
                    exit;
                }

                $query = "UPDATE cart SET quantity = '$quantity' WHERE cart_id = '$cart_id'";
                mysqli_query($conn, $query);

                $result = mysqli_query($conn, "SELECT * FROM cart WHERE userID = '$user_id'");
                $total_price = 0;
                $item_total = 0;

                while ($cart_item = mysqli_fetch_assoc($result)) {
                    if ($cart_item['cart_id'] == $cart_id) {
                        $item_total = $cart_item['quantity'] * $cart_item['product_price'];
                    }
                    $total_price += $cart_item['quantity'] * $cart_item['product_price'];
                }

                echo json_encode([
                    'item_total' => $item_total,
                    'total_price' => $total_price
                ]);
                exit;
            }
            ?>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<!-- <script>
                document.getElementById("apply-coupon").addEventListener("click", function(e) {
                    e.preventDefault();

                    const couponInput = document.getElementById("coupon").value;
                    const totalPrice = parseFloat(document.getElementById("total-price").innerText);

                    fetch("apply_coupons.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: `coupon_code=${couponInput}&original_price=${totalPrice}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            const messageBox = document.getElementById("response-message");
                            messageBox.innerHTML = data.message;
                            messageBox.className = data.status === "success" ? "text-success" : "text-danger";

                            if (data.status === "success") {
                                const updatedTotalPrice = data.final_price;
                                document.getElementById("total-price").innerText = updatedTotalPrice;
                            }
                        })
                        .catch(error => console.error("Error:", error));
                });

                // End of coupons js code

                // JavaScript و AJAX لتحديث الكمية

                document.querySelectorAll('.quantity').forEach(input => {
                    input.addEventListener('change', function() {
                        let cartId = this.getAttribute('data-cart-id');
                        let quantity = this.value;

                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', '', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                let response = JSON.parse(xhr.responseText);
                                if (response.error) {
                                    alert(response.error);
                                } else {
                                    // تحديث الإجمالي للمنتج الفردي بناءً على cart_id
                                    let itemTotal = document.querySelector(`.item-total[data-cart-id="${cartId}"]`);
                                    itemTotal.innerText = response.item_total;

                                    // تحديث الإجمالي الكلي
                                    document.getElementById('total-price').innerText = response.total_price;
                                }
                            }
                        };
                        xhr.send('cart_id=' + cartId + '&quantity=' + quantity);
                    });
                });
            </script> -->