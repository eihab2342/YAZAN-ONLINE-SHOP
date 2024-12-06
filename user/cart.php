<?php
session_start();
include('../config/connection.php');

$user_id = isset($_COOKIE['userID']) ? $_COOKIE['userID'] : $_SESSION['userID'];
if(!$user_id) {
    header("location: ../login.php");
}

// حذف المنتج من عربة التسوق عبر AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove_product') {
    $cart_id = intval($_POST['cart_id']);

    // تنفيذ الحذف من قاعدة البيانات
    $delete_query = "DELETE FROM cart WHERE cart_id = '$cart_id' AND userID = '$user_id'";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        echo json_encode(['success' => true, 'message' => 'تم الحذف بنجاح!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'فشل في حذف المنتج.']);
    }
    exit;
}

// جلب المنتجات من قاعدة البيانات
$query = "SELECT * FROM cart WHERE userID = '$user_id'";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../uploads/img/logo3.jpg" type="image/x-icon">

    <title>عربة التسوق</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- تضمين مكتبة Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .back-btn {
            font-size: 18px;
            text-decoration: none;
            color: #007bff;
            display: flex;
            align-items: center;
        }

        .back-btn:hover {
            color: #0056b3;
        }

        .back-btn i {
            margin-left: 5px;
        }

        .product {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .product img {
            width: 100px;
            height: auto;
            border-radius: 5px;
        }

        .product-details {
            flex: 1;
            margin-left: 10px;
        }

        .product-details p {
            margin: 5px 0;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .quantity-controls button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .quantity-controls button:hover {
            background-color: #0056b3;
        }

        .quantity-controls input {
            width: 40px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
        }

        .remove-btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .remove-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <div class="header">
        <a href="index.php" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            العودة إلى الصفحة الرئيسية
        </a>
        <h1>عربة التسوق</h1>
    </div>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="product" id="product-<?php echo $row['cart_id']; ?>">
            <img src="../uploads/img/<?php echo $row['product_image']; ?>" alt="Product Image">
            <div class="product-details">
                <p><?php echo $row['product_name']; ?></p>
                <p class="price text-danger" id="price-<?php echo $row['cart_id']; ?>">
                    EGP <?php echo $row['product_price'] * $row['quantity']; ?>
                </p>

                <div class="quantity-controls">
                    <button class="decrease-btn" onclick="updateQuantity(<?php echo $row['cart_id']; ?>, 'decrease')">-</button>
                    <input type="text" id="quantity-<?php echo $row['cart_id']; ?>" value="<?php echo $row['quantity']; ?>" readonly>
                    <button class="increase-btn" onclick="updateQuantity(<?php echo $row['cart_id']; ?>, 'increase')">+</button>
                </div>
            </div>

            <!-- زر الحذف -->
            <button class="remove-btn" onclick="removeFromCart(<?php echo $row['cart_id']; ?>)">
                🗑
            </button>
        </div>
    <?php } ?>

    <!-- زر Checkout -->
    <a href="check_out.php" class="btn btn-warning mt-4 d-block text-center" style="width: 30%;">
        <i class="fas fa-credit-card"></i> Checkout
    </a>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // تحديث الكمية في LocalStorage وواجهة المستخدم
        function updateQuantity(productId, change) {
            let quantityInput = document.getElementById('quantity-' + productId);
            let priceTag = document.getElementById('price-' + productId);
            let quantity = parseInt(quantityInput.value);

            quantity += change;
            if (quantity < 1) quantity = 1;

            quantityInput.value = quantity;
            let price = parseFloat(priceTag.innerText.replace('EGP ', ''));
            let total = price * quantity;
            priceTag.innerText = `EGP ${total}`;

            saveToLocalStorage(productId, quantity);
            updateGrandTotal();

            showToast('تم تحديث الكمية.', 'success');
        }

        function saveToLocalStorage(productId, quantity) {
            let cart = JSON.parse(localStorage.getItem('cart')) || {};
            cart[productId] = quantity;
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        function updateGrandTotal() {
            let grandTotal = 0;
            const prices = document.querySelectorAll('[id^="price-"]');
            prices.forEach(priceTag => {
                grandTotal += parseFloat(priceTag.innerText.replace('EGP ', ''));
            });
            document.getElementById('grandTotal').innerText = `EGP ${grandTotal}`;
        }

        // حذف المنتج باستخدام AJAX وتحديث الواجهة
        function removeFromCart(cartId) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);

                            if (response.success) {
                                const productElement = document.getElementById(`product-${cartId}`);
                                if (productElement) {
                                    productElement.remove();
                                }
                                showToast(response.message, 'success');
                            } else {
                                showToast(response.message, 'error');
                            }
                        } catch (error) {
                            console.error("Error parsing response:", error);
                            showToast('حدث خطأ في الحذف.', 'error');
                        }
                    } else {
                        showToast('فشل الطلب، يرجى المحاولة لاحقًا.', 'error');
                    }
                }
            };

            xhr.send(`action=remove_product&cart_id=${cartId}`);
        }

        // عرض رسائل التوست
        function showToast(message, type) {
            Toastify({
                text: message,
                duration: 3000,
                gravity: 'top',
                position: 'center',
                backgroundColor: type === 'success' ? '#28a745' : '#dc3545',
                close: true,
            }).showToast();
        }
    </script>
</body>

</html>