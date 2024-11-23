<?php
require '../config/connection.php';
require '../config/functions.php';
require 'assets/header.php';

// استلام product_id من الرابط
$product_id = $_GET['product_id'];

// استعلام لسحب بيانات المنتج بناءً على product_id
$query = mysqli_query($conn, "SELECT * FROM products_data WHERE id = '$product_id'");
$product = mysqli_fetch_assoc($query);

if (!$product) {
    echo '<p class="text-center">هذا المنتج غير موجود.</p>';
    require 'assets/footer.php';
    exit;
}

// تفاصيل المنتج
$product_name = htmlspecialchars($product['name']);
$product_price = htmlspecialchars($product['price']);
$product_description = htmlspecialchars($product['description']);
$product_quantity = 1; // الكمية الافتراضية

// الصور
$image1 = htmlspecialchars($product['image']);
$image2 = htmlspecialchars($product['image2']);
$image3 = htmlspecialchars($product['image3']);

// تحقق من وجود الصور
$image_paths = [
    '../uploads/img/' . $image1,
    '../uploads/img/' . $image2,
    '../uploads/img/' . $image3,
];
foreach ($image_paths as &$path) {
    if (!file_exists($path) || empty($path)) {
        $path = '../uploads/img/default.png'; // صورة افتراضية إذا لم تكن الصورة موجودة
    }
}

// عنوان الصفحة
$pageTitle = 'YAZAN | ' . $product_name;
?>
<title><?php echo getTitle($pageTitle); ?></title>

    <div class="container mt-5">
            <div class="row align-items-center">
                <!-- الكاروسيل لعرض صور المنتج -->
                <div class="col-md-6">

                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php 
                    $images = [
                        htmlspecialchars($product['image']),
                        htmlspecialchars($product['image2']),
                        htmlspecialchars($product['image3']),
                    ];

                    $default_image = '../uploads/img/default.png'; // الصورة الافتراضية
                    $hasImages = false; // للتحقق إذا كان هناك صور مضافة

                    foreach ($images as $index => $image) {
                        // تحقق من وجود الصورة في المسار
                        $image_path = '../uploads/img/' . $image;
                        if (!empty($image) && file_exists($image_path)) {
                            $hasImages = true; // تأكيد وجود صورة على الأقل
                            $active_class = $index === 0 ? 'active' : ''; // جعل الصورة الأولى نشطة
                            ?>
                            <div class="carousel-item <?php echo $active_class; ?>">
                                <img src="<?php echo $image_path; ?>" class="d-block w-100 rounded shadow" alt="Product Image <?php echo $index + 1; ?>" style="height: 350px; object-fit: cover;">
                            </div>
                            <?php
                        }
                    }

                    // إذا لم تكن هناك صور صالحة، يتم عرض الصورة الافتراضية فقط
                    if (!$hasImages) {
                    ?>
                        <div class="carousel-item active">
                            <img src="<?php echo $default_image; ?>" class="d-block w-100 rounded shadow" alt="Default Product Image" style="height: 350px; object-fit: cover;">
                        </div>
                    <?php } ?>
                </div>

            <!-- التحكم في الكاروسيل -->
                <div class="w-50">
                    <button class="carousel-control-prev custom-control" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">السابق</span>
                    </button>
                    <button class="carousel-control-next custom-control" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">التالي</span>
                    </button>
                </div>

        </div>

    </div>

        <!-- تفاصيل المنتج -->
        <div class="col-md-6">
            <h1 class="mb-3"><?php echo $product_name; ?></h1>
            <p class="lead text-muted"><?php echo $product_description; ?></p>
            <h3 class="text-success mb-3"><?php echo number_format($product_price); ?> EG</h3>

            <!-- زر التحكم في الكمية -->
            <form action="add_to_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <input type="hidden" name="product_name" value="<?php echo $product_name; ?>">
                <input type="hidden" name="product_price" value="<?php echo $product_price; ?>">
                <input type="hidden" name="product_image" value="<?php echo $image1; ?>"> <!-- الصورة الأولى -->

                <div class="mb-3">
                    <label for="quantity" class="form-label">الكمية:</label>
                    <div class="input-group">
                        <button type="button" class="btn btn-outline-secondary" id="decreaseQuantity">-</button>
                        <input type="number" class="form-control text-center" id="quantity" name="quantity" value="1" min="1" max="100" readonly>
                        <button type="button" class="btn btn-outline-secondary" id="increaseQuantity">+</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-cart-plus"></i> إضافة إلى العربة
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // التحكم في زيادة ونقصان الكمية
    document.getElementById('increaseQuantity').addEventListener('click', function () {
        let quantityInput = document.getElementById('quantity');
        let currentValue = parseInt(quantityInput.value);
        if (currentValue < 100) {
            quantityInput.value = currentValue + 1;
        }
    });

    document.getElementById('decreaseQuantity').addEventListener('click', function () {
        let quantityInput = document.getElementById('quantity');
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });
</script>

<?php
require 'assets/footer.php';
?>
