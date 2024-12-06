<?php
require '../config/connection.php';
require '../config/functions.php';
require 'assets/header.php';


// الحصول على product_id من الرابط
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

if ($product_id > 0) {
    // استعلام لجلب تفاصيل المنتج
    $query = "SELECT * FROM products_data WHERE id = $product_id ORDER BY RAND()";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // جلب البيانات من الاستعلام
        $product = mysqli_fetch_assoc($result);
        $category_name = $product['category_name'];
    } else {
        echo "المنتج غير موجود.";
        exit;
    }
} else {
    echo "معلومات المنتج غير صحيحة.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل المنتج</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            direction: rtl;
            /* جعل النص من اليمين لليسار */
        }

        /* .carousel-item img { */
        /* max-height: 300px; */
        /* object-fit: cover; */
        /* width: 300px; */
        /* } */

        .product-details {
            text-align: right;
            /* جعل النص يظهر من اليمين */
        }

        .product-details h1 {
            text-align: center;
            /* العنوان يكون في المنتصف */
        }
    </style>
</head>

<body>
    <!-- <div class="container mt-5 product-details">
        <h1 class="mb-5"><?php // echo $product['name']; 
                            ?></h1>

        <div class="row">
            <div class="col-md-6">
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="../uploads/img/<?php echo $product['image']; ?>" alt="Product Image 1">
                        </div>
                        <?php
                        /*
                        for ($i = 2; $i <= 3; $i++) {
                            if ($product["image$i"]) {
                                echo '<div class="carousel-item">
                                        <img src="../uploads/img/' . $product["image$i"] . '" alt="Product Image ' . $i . '">
                                      </div>';
                            }
                        }*/
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">السابق</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">التالي</span>
                    </button>
                </div>

                <div class="d-flex align-items-center mt-3 m-2">
                    <strong>السعر: </strong>
                    <p class="mb-0" style="font-size: 1.1rem; margin-right: 20px; color: red;">
                        <?php // echo $product['price']; 
                        ?> ج.م
                    </p>
                    <button class="btn btn-primary add-to-cart me-4"
                        data-id="<?php // echo $product['id']; 
                                    ?>"
                        data-name="<?php // echo $product['name']; 
                                    ?>"
                        data-price="<?php // echo $product['price']; 
                                    ?>"
                        data-image="<?php // echo $product['image']; 
                                    ?>"
                        data-quantity="1">
                        إضافة للعربة
                    </button>
                </div>
                <p>بدلا من <del><?php // echo $product['old_price'] 
                                ?></del></p>

            </div>
            <div class="col-md-6">
                <p><strong>الوصف: </strong><?php // echo nl2br($product['description']); 
                                            ?></p>
                <p><strong>الفئة: </strong><?php // echo $product['category_name']; 
                                            ?></p>
                <p style="font-size: 20px; color:red;">السعر : <?php // echo $product['price'] 
                                                                ?>  ج.م </p>
                <strong> بدلا من </strong>
                <del><?php // echo $product['old_price']; 
                        ?> ج.م</del>

                <?php // if ($product['discount']) { 
                ?>
                    <p><strong>الخصم: </strong><?php // echo $product['discount']; 
                                                ?>%</p>
                <?php // } 
                ?>

                <p><strong>موقع العرض: </strong><?php //echo $product['position']; 
                                                ?></p>
            </div>
        </div>
    </div> -->






    <?php
    // $product_id = $product['id'];
    $query_product = "SELECT * FROM products_data WHERE id = $product_id";
    $result_product = mysqli_query($conn, $query_product);
    $product = mysqli_fetch_assoc($result_product);
    ?>

    <!DOCTYPE html>
    <html lang="ar">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>تفاصيل المنتج</title>

        <!-- تضمين Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

    <body>

        <div class="container mt-5 product-details">
            <h1 class="mb-5"><?php echo $product['name']; ?></h1>

            <div class="row">
                <!-- الكاروسيل -->
                <div class="col-md-6">
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="../uploads/img/<?php echo $product['image']; ?>" alt="Product Image 1" class="d-block w-100">
                            </div>

                            <?php
                            for ($i = 2; $i <= 3; $i++) {
                                if ($product["image$i"]) {
                                    echo '<div class="carousel-item">
                                      <img src="../uploads/img/' . $product["image$i"] . '" alt="Product Image ' . $i . '" class="d-block w-100">
                                  </div>';
                                }
                            }
                            ?>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">السابق</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">التالي</span>
                        </button>
                    </div>

                    <!-- السعر وزر إضافة للعربة -->
                    <div class="d-flex align-items-center mt-3">
                        <strong>السعر: </strong>
                        <p class="mb-0" style="font-size: 1.1rem; margin-right: 20px; color: red;"><?php echo $product['price']; ?> ج.م</p>
                        <button class="btn btn-primary add-to-cart me-4"
                            data-id="<?php echo $product['id']; ?>"
                            data-name="<?php echo $product['name']; ?>"
                            data-price="<?php echo $product['price']; ?>"
                            data-image="<?php echo $product['image']; ?>"
                            data-quantity="1">
                            إضافة للعربة
                        </button>
                    </div>
                </div>

                <!-- وصف المنتج والمعلومات -->
                <div class="col-md-6">
                    <p><strong>الوصف:</strong> <?php echo nl2br($product['description']); ?></p>
                    <p><strong>الفئة:</strong> <?php echo $product['category_name']; ?></p>

                    <!-- الألوان المتاحة -->
                    <div>
                        <strong>الألوان المتاحة:</strong>
                        <div id="colors" class="d-flex mt-2">
                            <?php
                            $query_colors = "SELECT id, color, image FROM product_colors WHERE product_id = $product_id";
                            $result_colors = mysqli_query($conn, $query_colors);

                            while ($color = mysqli_fetch_assoc($result_colors)) {
                                echo '<div class="color-option" data-color-id="' . $color['id'] . '" data-image="../uploads/img/' . $color['image'] . '"
                                 style="width: 40px; height: 40px; background-color: ' . $color['color'] . ';
                                 margin: 5px; border-radius: 50%; cursor: pointer; border: 1px solid #ccc;"></div>';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- المقاسات المتاحة -->
                    <div>
                        <strong>المقاسات المتاحة:</strong>
                        <div id="sizes" class="mt-2"></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- تضمين Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- AJAX -->
        <script>
            $(document).ready(function() {
                $('.color-option').on('click', function() {
                    var colorId = $(this).data('color-id');
                    var newImage = $(this).data('image');

                    $('#productCarousel img').first().attr('src', newImage);

                    // AJAX لاسترجاع المقاسات المناسبة للون
                    $.ajax({
                        url: 'get_sizes.php',
                        method: 'POST',
                        data: {
                            color_id: colorId
                        },
                        success: function(response) {
                            $('#sizes').html(response);
                        }
                    });
                });
            });
        </script>

    </body>

    </html>



























    <div class="slider_products slide mt-5" style="margin-top: 100px;">

        <div class="container">

            <div class="slide_product mySwiper">

                <div class="top_slide">
                    <h2><i class="fa-solid fa-tags"></i>منتجات ذات صلة</h2>
                </div>

                <?php
                $sql = "SELECT * FROM products_data WHERE category_name = '$category_name'";
                $result = mysqli_query($conn, $sql);

                // Fetch data into an array
                $products = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $products[] = $row;
                }

                // Close the database connection
                mysqli_close($conn);
                ?>

                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($products as $product) {
                            echo '<div class="swiper-slide">
        <a href="product_details.php?product_id=' . $product['id'] . '">
            <img src="../uploads/img/' . $product['image'] . '" alt="' . $product['name'] . '" style="height: 150px; width: 150px;">
            <h6>' . $product['name'] . '</h6>
        </a>
        <div class="col">
            <p>' . $product['price'] . ' ج.م</p>
            <p class="old-price">' . $product['old_price'] . ' ج.م</p>
        </div>
        <button class="btn add-to-cart"
                data-id="' . $product['id'] . '"
                data-name="' . htmlspecialchars($product['name']) . '"
                data-price="' . $product['price'] . '"
                data-image="' . $product['image'] . '"
                data-quantity="1"
                onclick="playSuccessSound()">🛒
        </button>
        </div>';
                        }
                        ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
                <style>
                    .swiper-container {
                        position: relative;
                        /* ضروري لجعل الأزرار مرتبطة بالـ swiper */
                    }

                    a {
                        text-decoration: none;
                    }

                    .swiper-slide {
                        display: flex;
                        flex-direction: column;
                        /* ترتيب العناصر عموديًا */
                        align-items: center;
                        /* محاذاة العناصر أفقيًا في المنتصف */
                        justify-content: space-between;
                        /* توزيع العناصر بالتساوي داخل الكارد */
                        padding: 10px;
                        box-sizing: border-box;
                        /* لتضمين البادينج في أبعاد العنصر */
                        height: 350px;
                        /* ارتفاع الكارد */
                        background-color: #f8f8f8;
                        /* لون خلفية للكارد (اختياري) */
                        border-radius: 8px;
                        /* زوايا مستديرة (اختياري) */
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                        /* إضافة ظل للكارد */
                    }

                    .swiper-slide img {
                        justify-content: center;
                        align-content: center;
                        height: 120px;
                        width: 120px;
                        /* object-fit: cover; */
                        /* لضمان ملاءمة الصورة داخل الإطار */
                        /* border-radius: 50%; */
                        /* جعل الصور دائرية (اختياري) */
                        margin-bottom: 10px;
                        /* مسافة أسفل الصورة */
                    }

                    .swiper-slide h6 {
                        font-size: 16px;
                        margin: 5px 0;
                        /* مسافة بين النصوص */
                        text-align: center;
                        /* محاذاة النصوص للوسط */
                    }

                    .swiper-slide p {
                        font-size: 16px;
                        color: red;
                        /* لون النص (اختياري) */
                        text-align: center;
                        /* محاذاة النصوص للوسط */
                        margin: 5px 0;
                    }

                    .swiper-slide .old-price {
                        font-size: 14px;
                        /* حجم النص */
                        color: #999;
                        /* لون باهت للإشارة إلى أنه غير فعال */
                        text-decoration: line-through;
                        /* خط على النص للإشارة إلى السعر القديم */
                        margin-right: 5px;
                        /* مسافة بين السعر القديم والجديد */
                    }

                    .swiper-slide button {
                        margin-top: 10px;
                        /* مسافة أعلى الزر */
                        padding: 5px 10px;
                        font-size: 14px;
                        border: none;
                        border-radius: 5px;
                        background-color: #007bff;
                        /* لون الزر */
                        color: white;
                        /* لون النص داخل الزر */
                        cursor: pointer;
                        transition: background-color 0.3s;
                    }

                    .swiper-slide button:hover {
                        background-color: #0056b3;
                        /* تغيير لون الزر عند التمرير */
                    }

                    .swiper-button-next,
                    .swiper-button-prev {
                        position: absolute;
                        /* جعل الأزرار مرتبطة بموقع الـ swiper */
                        top: 50%;
                        /* محاذاة رأسية في منتصف الـ swiper */
                        transform: translateY(-50%);
                        /* لضبط المركز */
                        width: 40px;
                        height: 40px;
                        background-color: rgba(0, 0, 0, 0.5);
                        /* خلفية شفافة */
                        color: white;
                        border-radius: 50%;
                        z-index: 10;
                        /* لضمان ظهور الأزرار فوق المحتوى */
                    }

                    .swiper-button-next {
                        right: 10px;
                        /* على يمين الـ swiper */
                    }

                    .swiper-button-prev {
                        left: 10px;
                        /* على يسار الـ swiper */
                    }

                    /* التأثير عند التمرير بالفأرة */
                    .swiper-button-next:hover,
                    .swiper-button-prev:hover {
                        background-color: rgba(0, 0, 0, 0.7);
                    }
                </style>

                <script>
                    var swiper = new Swiper('.swiper-container', {
                        // Optional parameters
                        direction: 'horizontal',
                        loop: true,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        breakpoints: {
                            // Small screens
                            320: {
                                slidesPerView: 2,
                                spaceBetween: 10
                            },
                            // Medium screens
                            768: {
                                slidesPerView: 4,
                                spaceBetween: 20
                            },
                            // Large screens
                            1024: {
                                slidesPerView: 6,
                                spaceBetween: 30
                            }
                        }
                    });
                </script>
</body>

</html>



<div class="card mb-3" style="max-width: 540px;">
    <div class="row g-0 flex-row-reverse"> <!-- الحفاظ على الصورة في اليمين -->
        <div class="col-md-4">
            <img src="../uploads/img/0f689555-8aa4-4076-aea6-7a3cb69cccff.webp" class="img-fluid rounded-start" alt="...">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">Card Title</h5>
                <p class="card-text">
                    This is a wider card with supporting text below as a natural lead-in
                    to additional content. This content is a little bit longer.
                </p>
                <p class="card-text">
                    <small class="text-body-secondary">Last updated 3 mins ago</small>
                </p>
            </div>
        </div>
    </div>
</div>



<style>
    @media (max-width: 480px) {
        .product {
            width: 630px;
            height: 430px;
        }

        .product .img_product {
            padding-left: 15px;
            height: 200px;
            max-width: 250px;
        }

        .product .icons .btn_add_cart {
            justify-content: center;
            width: 50px;
            font-size: 18px;
            padding: 3px 5px;
        }

    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="./assets/cart.js"></script>
<?php
require 'assets/footer.php';
?>

</html>



<style>
    /* تخصيص عرض الصورة في الشاشات الصغيرة */
    @media (max-width: 767px) {
        .carousel-item img {
            width: 80%;
            /* عرض الصورة 50% من الشاشة */
            margin: 0 auto;
            /* محاذاة الصورة في المنتصف */
            display: block;
        }
    }
</style>
<!-- Footer in Mobile only -->
<style>
    .navbar {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 1030;
        /* لضمان ظهور الشريط فوق أي عنصر آخر */
        background-color: #fff;
        /* لون الخلفية */
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        /* ظل خفيف */
    }

    .navbar-nav .nav-link {
        text-align: center;
        font-size: 14px;
        /* حجم الخط */
    }

    .navbar-nav .nav-link i {
        display: block;
        font-size: 20px;
        /* حجم الأيقونات */
    }

    html,
    body {
        width: 100%;
        height: 100%;
        overflow-x: hidden;
    }

    body {
        padding-bottom: 0;
        margin: 0;
        overflow-x: hidden;
    }
</style>

<nav class="navbar navbar-light bg-light d-lg-none">
    <div class="container-fluid">
        <ul class="navbar-nav nav-justified w-100 d-flex flex-row">
            <li class="nav-item">
                <a class="nav-link" href="./index.php">
                    <i class="bi bi-house-door"></i>
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./account.php">
                    <i class="bi bi-person"></i>
                    Profile
                </a>
            </li>
            <li class="nav-item cart-icon">
                <a class="nav-link" href="../cart.php">
                    <i class="bi bi-cart"></i>
                    Cart
                    <span id="cart-count">0</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotifications">
                    <i class="bi bi-bell"></i>
                    إشعارات
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="text-decoration-none nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <i class="bi bi-list"></i>
                    Menu
                </a>
            </li>
        </ul>
    </div>
</nav>
<!-- Footer in Mobile only -->