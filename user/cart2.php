<?php
session_start();
$user_id = isset($_COOKIE['userID']) ? $_COOKIE['userID'] : $_SESSION['userID'];

?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>عربة التسوق</title>

    <!-- تضمين Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- تضمين Toastify -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- تضمين FontAwesome لأيقونات -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .cart-item {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 15px;
            transition: 0.3s;
        }

        .cart-item:hover {
            transform: scale(1.02);
        }

        .btn-custom {
            font-weight: bold;
        }

        .btn-custom:hover {
            opacity: 0.8;
        }

        .checkout-btn {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <header class="bg-dark text-white text-center py-4">
        <h1>🛒 عربة التسوق</h1>
    </header>
    <?php
    require '../config/connection.php';
    $result = mysqli_query($conn, "SELECT * FROM cart WHERE userID = '$user_id'");

    ?>
    <div class="container mt-4">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="cart-item row align-items-center">
                <div class="col-md-4">
                    <img src="../uploads/img/<?php echo $row['product_image']; ?>" alt="صورة المنتج" class="img-fluid rounded">
                </div>

                <div class="col-md-6">
                    <p><strong><?php echo $row['product_name']; ?></strong></p>
                    <p>السعر: EGP <?php echo $row['product_price'] * $row['quantity']; ?></p>

                    <div class="d-flex align-items-center mt-2">
                        <button class="btn btn-danger btn-sm me-2" onclick="updateQuantity(<?php echo $row['cart_id']; ?>, -1)"><i class="fas fa-minus"></i></button>
                        <input type="number" id="quantity-<?php echo $row['cart_id']; ?>" value="<?php echo $row['quantity']; ?>" readonly class="form-control w-50">
                        <button class="btn btn-primary btn-sm ms-2" onclick="updateQuantity(<?php echo $row['cart_id']; ?>, 1)"><i class="fas fa-plus"></i></button>
                    </div>
                </div>

                <div class="col-md-2 text-end">
                    <button class="btn btn-outline-danger btn-sm mt-2" onclick="removeFromCart(<?php echo $row['cart_id']; ?>)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        <?php } ?>

        <div class="d-flex justify-content-end mt-4">
            <a href="check_out.php" class="btn btn-success btn-lg checkout-btn mt-3">
                <i class="fas fa-credit-card"></i> Checkout
            </a>
        </div>
    </div>

    <!-- Script التحديث والحذف -->
    <script>
        function updateQuantity(cartId, change) {
            let quantityInput = document.getElementById('quantity-' + cartId);
            let quantity = parseInt(quantityInput.value);

            quantity += change;
            if (quantity < 1) quantity = 1;

            quantityInput.value = quantity;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    showToast('تم تحديث الكمية بنجاح', 'success');
                    updateGrandTotal();
                }
            };

            xhr.send(`action=update_quantity&cart_id=${cartId}&quantity=${quantity}`);
        }

        function removeFromCart(cartId) {
            if (confirm('هل تريد حذف المنتج من العربة؟')) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const productElement = document.getElementById(`product-${cartId}`);
                        if (productElement) productElement.remove();
                        showToast('تم الحذف بنجاح', 'success');
                        updateGrandTotal();
                    }
                };

                xhr.send(`action=remove_product&cart_id=${cartId}`);
            }
        }

        function showToast(message, type) {
            Toastify({
                text: message,
                duration: 3000,
                gravity: 'top',
                position: 'center',
                backgroundColor: type === 'success' ? '#28a745' : '#ff5722',
            }).showToast();
        }

        function updateGrandTotal() {
            let grandTotal = 0;
            const prices = document.querySelectorAll('[id^="price-"]');

            prices.forEach(priceTag => {
                grandTotal += parseFloat(priceTag.innerText.replace('EGP ', ''));
            });

            console.log('إجمالي السعر: EGP ' + grandTotal);
        }
    </script>

    <!-- تضمين Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>

</html>