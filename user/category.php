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
        <div class="row row-cols-1 row-cols-md-2 g-4 overflow-auto d-flex" style="white-space: nowrap;">
            <?php foreach ($row as $product) {
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
            <div class="col" style="min-width: 250px; max-width: 300px; height: 400px;">
                <div class="card" style="width: 100%; height: 100%;">
                    <img src="<?php echo $image_path; ?>" class="card-img-top" alt="Product Image" style="height: 150px; object-fit: cover;">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title text-truncate"><?php echo $product_name; ?></h5>
                        <p class="card-text text-truncate"><?php echo $product_description; ?></p>
                        <p class="card-text"><strong><?php echo number_format($product_price); ?> EG</strong></p>
                        <a href="product_details.php?product_id=<?php echo $product['id']; ?>" class="btn btn-primary btn-sm mt-auto">عرض التفاصيل</a>
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

<?php
require 'assets/footer.php';
?>
