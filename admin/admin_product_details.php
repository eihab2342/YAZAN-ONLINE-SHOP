<?php
session_start();
require '../assets/header.php';
require '../config/connection.php';
require '../config/functions.php';
$product_id = $_GET['product_id'];
$result = mysqli_query($conn, "SELECT * FROM products_data WHERE id = '$product_id'");
$product = mysqli_fetch_assoc($result);
// $category_name = $product['category_name'];
?>
<title><?php $pageTitle = 'Admin | Product Detailes';
        echo getTitle($pageTitle); ?></title>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="direction: rtl;">
    <a href="index.php" class="btn btn-outline-secondary position-absolute" style="top: 20px; left: 20px;">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="container mt-5">
        <h1 class="text-center text-primary mb-4">Product Details</h1>
        <div class="card">
            <div class="card-header bg-info text-white">
                <h4><?php echo $product['name']; ?></h4>
            </div>
            <div class="card-body">
                <?php
                $category_name = $product['category_name'];
                ?>

                <p><strong>Category: </strong> <?php echo htmlspecialchars($product['category_name']); ?></p>
                <p><strong>Price: </strong> $<?php echo htmlspecialchars($product['price']); ?></p>
                <p><strong>Old Price: </strong> $<?php echo htmlspecialchars($product['old_price']); ?></p>
                <p><strong>Description: </strong> <?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong>Keywords: </strong> <?php echo htmlspecialchars($product['keywords']); ?></p>

                <?php if (in_array($category_name, ['ملابس رجالى', 'ملابس حريمى'])): ?>
                    <p><strong>Size: </strong> <?php echo htmlspecialchars($product['size']); ?></p>
                    <p><strong>Color: </strong> <?php echo htmlspecialchars($product['color']); ?></p>
                <?php elseif (in_array($category_name, ['هواتف'])): ?>
                    <p><strong>Color: </strong> <?php echo htmlspecialchars($product['color']); ?></p>
                <?php endif; ?>


                <?php if (!empty($product['image']) && file_exists("../uploads/img/" . $product['image'])): ?>
                    <div class="mb-3">
                        <img src="../uploads/img/<?php echo $product['image']; ?>" class="img-fluid" alt="Product Image">
                    </div>
                <?php endif; ?>
                <div class="col-6">
                    <a href="product.php" class="btn btn-secondary">Back to Products</a>
                    <a href="product.php?do=Edit&product_id=<?php echo $product_id; ?>" class="btn btn-warning">تعديل</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>