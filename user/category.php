<?php
require '../config/connection.php';
require '../config/functions.php';
require 'assets/header.php';

// استلام category_id من الرابط
$category_id = $_GET['category_id'];

// استعلام لسحب اسم الفئة بناءً على category_id
$query = mysqli_query($conn, "SELECT category_name FROM categories_data WHERE category_id = '$category_id'");
$category = mysqli_fetch_assoc($query);

// إذا كانت الفئة موجودة
if ($category) {
    $category_name = $category['category_name'];
    $pageTitle = 'YAZAN | ' . $category_name;
} else {
    $category_name = '';
    $pageTitle = 'YAZAN | Unknown Category';
}

?>
<title><?php echo getTitle($pageTitle); ?></title>

<div class="container mt-4">
    <h2 class="text-center"><?php echo htmlspecialchars($category_name); ?></h2>

    <!-- استعلام لعرض المنتجات الخاصة بالفئة -->
    <?php
    $products_query = "SELECT * FROM products_data WHERE category_name = '$category_name'";
    $products_result = mysqli_query($conn, $products_query);

    if ($products_result && mysqli_num_rows($products_result) > 0) {
        $products = [];
        while ($product = mysqli_fetch_assoc($products_result)) {
            $products[] = $product;
        }

        // تقسيم المنتجات إلى صفوف
        $rows = array_chunk($products, 4); // 4 منتجات في كل صف
        foreach ($rows as $row) {
    ?>
            <div class="row row-cols-2 row-cols-md-4 g-4 my-3">
                <?php foreach ($row as $product) {
                    $product_id = htmlspecialchars($product['id']);
                    $product_name = htmlspecialchars($product['name']);
                    $product_price = htmlspecialchars($product['price']);
                    $product_image = htmlspecialchars($product['image']);
                    $product_description = htmlspecialchars($product['description']);

                    // تحقق من وجود صورة المنتج
                    $image_path = '../uploads/img/' . $product_image;
                    if (!file_exists($image_path) || empty($product_image)) {
                        $image_path = '../uploads/img/default.png';
                    }
                ?>
                    <div class="col">
                        <a href="product_details.php?product_id=<?php echo $product['id'] ?>" style="text-decoration: none;">
                            <div class="card shadow-sm" style="height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                                <img src="<?php echo $image_path; ?>" class="card-img-top" alt="Product Image" style="height: 220px; object-position: center center;"> <!-- object-fit: cover; -->
                                <div class="card-body d-flex flex-column">
                        </a>
                        <p class="card-title text-truncate"><?php echo $product_name; ?></p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <p class="card-text mb-0"><strong><?php echo number_format($product_price); ?> EG</strong></p>
                            <button class="btn btn-primary add-to-cart"
                                data-id="<?php echo $product_id; ?>"
                                data-name="<?php echo $product_name; ?>"
                                data-price="<?php echo $product_price; ?>"
                                data-image="<?php echo $product_image; ?>"
                                data-quantity="1">
                                +
                            </button>
                        </div>
                    </div>
            </div>
</div>
<?php } ?>
</div>
<?php
        }
    } else {
        echo '<p class="text-center">لا توجد منتجات في هذه الفئة.</p>';
    }
?>
</div>
<script src="./assets/cart.js"></script>
<?php
require 'assets/footer.php';
?>




<!-- <script>
    $(".add-to-cart").click(function() {
        var product_id = $(this).data("id");
        var product_name = $(this).data("name");
        var product_price = $(this).data("price");
        var quantity = $(this).data("quantity");
        var product_image = $(this).data("image");

        $.ajax({
            url: "add_to_cart.php",
            type: "POST",
            data: {
                product_id: product_id,
                product_name: product_name,
                product_price: product_price,
                quantity: quantity,
                product_image: product_image
            },
            success: function(response) {

                $("#notification").fadeIn().delay(3000).fadeOut();
            },
            error: function() {
                alert("حدث خطأ أثناء إضافة المنتج إلى العربة.");
            }
        });
    });
</script> -->