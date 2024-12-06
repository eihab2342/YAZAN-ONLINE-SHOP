    <?php
    require '../config/connection.php';
    require '../config/functions.php';
    require 'assets/header.php';

    // if(!isset($_COOKIE['username'])) {
    //   showAlerts(null, "fgdfgdfgdfg", null);
    // }
    $pageTitle = 'YAZAN | الرئيسية';
    ?>








    <div id="notification" style="display:none; position: fixed; top: 10px; left: 50%; transform: translateX(-50%); padding: 10px; background-color: #28a745; color: white; border-radius: 5px; z-index: 9999;">
        تم إضافة المنتج إلى العربة!
    </div>
    <div id="error-notification" style="display:none; position: fixed; top: 10px; left: 50%; transform: translateX(-50%); padding: 10px; background-color: #dc3545; color: white; border-radius: 5px; z-index: 9999;">
        حدث خطأ أثناء إضافة المنتج إلى العربة.
    </div>






    <title><?php echo getTitle($pageTitle); ?></title>

    <!-- Start of Scroll bar To Display Categories ------------------------------------>

    <h3 class="me-4 mt-3">تصفح المنتجات علي حسب الفئات</h3>
    <?php
    $sql = mysqli_query($conn, "SELECT category_id, category_name, image FROM categories_data");
    if ($sql && mysqli_num_rows($sql) > 0) {
        echo '<div class="categories-container1">';
        while ($category = mysqli_fetch_assoc($sql)) {
            echo '<a href="category.php?category_id=' . $category['category_id'] . '" class="category-item1">';
            // تحقق من وجود الصورة
            if (isset($category['image']) && !empty($category['image'])) {
                echo '<img src="../uploads/img/' . $category['image'] . '" alt="' . $category['category_name'] . '">';
            } else {
                // إذا لم توجد صورة، عرض صورة افتراضية
                echo '<img src="" alt="' . $category['category_name'] . '">';
            }
            echo '<p>' . $category['category_name'] . '</p>';
            echo '</a>';
        }
        echo '</div>';
    }
    ?>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            /* background-color: #f5f5f5; */
        }

        .categories-container1 {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding: 15px;
            margin: 8px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }

        .categories-container1>.category-item {
            transition: all 0.3s ease;
        }

        .category-item1 {
            flex: 0 0 auto;
            /* اجعل العنصر غير قابل للتوسع */
            scroll-snap-align: start;
            text-align: center;
            margin-right: 10px;
            padding: 10px;
            width: 150px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            cursor: 0px;
            /* عرض العنصر */
            text-decoration: none;
        }

        .category-item1 img {
            width: 100%;
            /* تجعل الصورة تتناسب مع عرض العنصر */
            border-radius: 5px;
        }

        .category-item1 p {
            margin: 5px 0 0;
            font-size: 12px;
            font-weight: bold;
            color: #333;
        }

        /* تحسينات على التمرير */
        .categories-container1::-webkit-scrollbar {
            height: 6px;
        }

        .categories-container1::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .categories-container1::-webkit-scrollbar-track {
            background: #f0f0f0;
        }
    </style>

    <!-- End of Scroll bar To Display Categories ------------------------- -->

    <!-- START OF LAND PAGE -->

    <html lang="ar" dir="rtl">

    <head>
        <!-- <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>عرض المنتجات</title> -->

        <!-- تحميل Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">

        <style>
            /* الخلفية */
            .background-section {
                position: relative;
                background: url('../uploads/img/Main.png') no-repeat center center;
                background-size: cover;
                height: 600px;
                background-position: center top;
            }

            .background-section::after {
                content: "";
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 100px;
                background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.8) 100%);
            }

            .cards-container {
                margin-top: -200px;
                z-index: 2;
            }

            .card {
                background-color: #fff;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border: none;
                margin-bottom: 20px;
                display: flex;
                /* flex-direction: column; */
                /* justify-content: space-between; */
                /* height: 100%; */
                height: 400
            }

            .card img {
                height: 200px;
                /* object-fit: cover; */
            }

            .card-title {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
                margin-bottom: 10px;
            }

            .card-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding-top: 10px;
                background-color: #fff;
                padding: 10px;
                box-sizing: border-box;
            }

            .price {
                font-size: 13px;
                margin: 0;
            }

            .add-to-cart {
                padding: 5px 10px;
                font-size: 18px;
                background-color: #ff6f61;
                color: white;
                border: none;
                cursor: pointer;
            }

            @media (max-width: 480px) {
                .card {
                    width: 200px;
                }

                .background-section {
                    height: 400px;
                }

                .card img {
                    height: 150px;
                }

                .card-footer {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .add-to-cart {
                    width: 100%;
                    margin-top: 10px;
                }
            }
        </style>
    </head>

    <body>
        <!-- الخلفية -->
        <div class="background-section"></div>

        <!-- الحاوية الرئيسية للبطاقات -->
        <div class="container cards-container">
            <div class="row g-3">
                <?php
                $sql = mysqli_query($conn, "SELECT * FROM products_data WHERE category_name IN ('مستلزمات العناية الشخصية', 'الكترونيات وأجهزة ذكية', 'هواتف', 'اكسسوارات ومجوهرات حريمي') LIMIT 4");
                if ($sql && mysqli_num_rows($sql) == 4) {
                    while ($product = mysqli_fetch_assoc($sql)) {
                        $product_id = $product['id'];
                        $product_name = $product['name'];
                        $product_price = $product['price'];
                        $product_image = $product['image'];

                        echo '
            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
              <div class="card">
                <img src="../uploads/img/' . $product_image . '" class="card-img-top img-fluid" alt="منتج">
                <div class="card-body">
                  <p class="card-title">' . $product_name . '</p>
                </div>
                <div class="card-footer">
                  <p class="price">' . $product_price . ' جنيه</p>
                    <button 
                        class="btn btn-primary add-to-cart" 
                        data-id="<?php echo htmlspecialchars($product_id); ?>" 
                        data-name="<?php echo htmlspecialchars($product_name); ?>" 
                        data-price="<?php echo htmlspecialchars($product_price); ?>" 
                        data-image="<?php echo htmlspecialchars($product_image); ?>" 
                        data-quantity="1">
                        +
                    </button>
                </div>
              </div>
            </div>';
                    }
                } else {
                    echo 'لا يوجد منتجات لعرضها';
                }
                ?>
            </div>
        </div>

        <!-- تحميل Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
    <!-- Start of Main Images -->




    <!-- Start 25 products section 2 -->

    <?php
    $sql = "SELECT * FROM products_data LIMIT 25";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        echo '<div class="row">';
        while ($product = mysqli_fetch_assoc($result)) {
            $product_id = $product['id'];
            $product_name = $product['name'];
            $product_price = $product['price'];
            $product_image = $product['image'];
            $discount = $product['discount']; // لو كان في خصم
    ?>
            <div class="category-wrapper col-6 col-sm-6 col-md-4 col-lg-3 mb-4 h-100"> <!-- زيادة الحجم والارتفاع -->
                <a href="product_details.php?product_id=<?= htmlspecialchars($product['id']) ?>" class="category-item1" style="width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: space-between; text-decoration: none;">
                    <div class="image-container">
                        <img src="../uploads/img/<?= !empty($product['image']) ? htmlspecialchars($product['image']) : 'default-image.jpg' ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid">
                    </div>
                    <p class="product-name"><?= htmlspecialchars($product_name) ?></p>
                    <div class="product-footer d-flex justify-content-between align-items-center">
                        <span class="product-price" style="font-size: 0.8rem;"><?= htmlspecialchars($product['price']) ?> جنيه</span>
                        <div style="font-size: 0.6rem">
                            <span class="product-price" style="font-size: 0.6rem">بدلا من</span>
                            <del style=""> <?= htmlspecialchars($product['old_price']) ?></del>
                        </div>
                        <!-- </a> -->
                        <button
                            class="btn btn-success add-to-cart"
                            data-id="<?php echo htmlspecialchars($product_id); ?>"
                            data-name="<?php echo htmlspecialchars($product_name); ?>"
                            data-price="<?php echo htmlspecialchars($product_price); ?>"
                            data-image="<?php echo htmlspecialchars($product_image); ?>"
                            data-quantity="1">
                            +
                        </button>
                    </div>
                </a>
            </div>
            <!-- //\\//\\//\\//\\//\\//\\//\\//\\//\\/\/\/\ -->

    <?php }
        echo '</div>';
    } else {
        echo "<p class='text-center'>لا توجد منتجات لعرضها.</p>";
    }
    ?>

    <style>
        .category-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 400px;
            /* زيادة ارتفاع الكارد */
            margin: 10px;
            padding-bottom: 10px;
            background-color: #fff;
            border-radius: 8px;
        }

        .image-container {
            width: 100%;
            height: 200px;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        .category-wrapper img {
            width: 100%;
            object-fit: cover;
            height: 100%;
        }

        .product-name {
            font-size: 16px;
            font-weight: bold;
            height: 3em;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            margin: 10px;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            width: 100%;
        }

        .product-price {
            font-size: 18px;
            font-weight: bold;
        }

        .category-wrapper .btn {
            margin-left: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            font-size: 16px;
        }

        .category-wrapper .btn:hover {
            background-color:darkorange;
        }

        @media (max-width: 480px) {
            .category-wrapper {
                height: 450px;
                max-width: 200px;
                margin: 0;
            }

            .category-wrapper img {
                height: 150px;
            }
        }

        @media (min-width: 768px) {
            .category-wrapper {
                width: 100%;
                max-width: 220px;
            }

            .category-wrapper img {
                height: 199px;
            }
        }

        @media (min-width: 992px) {
            .category-wrapper {
                max-width: 250px;
            }

            .category-wrapper img {
                height: 200px;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // اختر جميع أزرار "أضف إلى العربة"
            const addToCartButtons = document.querySelectorAll('.add-to-cart');

            addToCartButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    // العثور على الرابط الأقرب الذي يحتوي على العنصر <a>
                    const link = this.closest('a');

                    // إلغاء وظيفة الرابط فقط عند الضغط على زر "عربة التسوق"
                    if (link) {
                        e.preventDefault(); // إلغاء الانتقال إلى صفحة المنتج
                    }
                });
            });
        });
    </script>
    <!--End  25 products section 2 -->


    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            /* background-color: #f5f5f5; */
        }

        .product-container {
            display: flex;
            overflow-x: hidden;
            padding: 15px;
            margin: 8px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            position: relative;
        }

        .product-item {
            flex: 0 0 auto;
            scroll-snap-align: start;
            text-align: center;
            margin-right: 10px;
            padding: 10px;
            width: 180px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            text-decoration: none;
        }

        .product-item img {
            width: 100%;
            border-radius: 5px;
        }

        .product-item p {
            margin: 5px 0 0;
            font-size: 12px;
            font-weight: bold;
            color: #333;
        }

        /* تحسينات على التمرير */
        .product-container::-webkit-scrollbar {
            display: none;
        }

        /* تنسيق الأسهم */
        .carousel-control-prev,
        .carousel-control-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
            background-color: rgba(0, 0, 0, 0.2);
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .carousel-control-prev {
            left: 10px;
        }

        .carousel-control-next {
            right: 10px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #fff;
            border-radius: 50%;
            padding: 10px;
        }
    </style>



    <script>
        // document.querySelectorAll('.add-to-cart').forEach(button => {
        //     button.addEventListener('click', function() {
        //         const productId = this.dataset.id;
        //         const productName = this.dataset.name;
        //         const productPrice = this.dataset.price;
        //         const productImage = this.dataset.image;
        //         const productQuantity = this.dataset.quantity;

        //         // إرسال المنتج إلى العربة باستخدام Fetch
        //         fetch('add_to_cart.php', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/x-www-form-urlencoded',
        //             },
        //             body: `id=${productId}&name=${productName}&price=${productPrice}&image=${productImage}&quantity=${productQuantity}`
        //         }).then(response => {
        //             if (response.ok) {
        //                 // عرض Toast لإضافة ناجحة
        //                 Toastify({
        //                     text: `✅ تم إضافة "${productName}" (${productQuantity}) إلى العربة بنجاح!`,
        //                     duration: 3000, // مدة العرض
        //                     close: true, // زر الإغلاق
        //                     gravity: "top", // الموضع: أعلى
        //                     position: "right", // الموضع: يمين
        //                     backgroundColor: "#4caf50", // لون الخلفية
        //                     stopOnFocus: true, // توقف عند التمرير
        //                     avatar: `../uploads/img/${productImage}`, // الصورة
        //                 }).showToast();
        //             } else {
        //                 // عرض Toast لخطأ
        //                 Toastify({
        //                     text: "❌ حدث خطأ أثناء إضافة المنتج.",
        //                     duration: 3000,
        //                     close: true,
        //                     gravity: "top",
        //                     position: "right",
        //                     backgroundColor: "#f44336", // لون الخلفية للخطأ
        //                     stopOnFocus: true,
        //                 }).showToast();
        //             }
        //         }).catch(error => {
        //             // عرض Toast لخطأ في الشبكة
        //             Toastify({
        //                 text: "❌ حدث خطأ في الشبكة. حاول لاحقًا.",
        //                 duration: 3000,
        //                 close: true,
        //                 gravity: "top",
        //                 position: "right",
        //                 backgroundColor: "#f44336",
        //                 stopOnFocus: true,
        //             }).showToast();
        //         });
        //     });
        // });
    </script>









    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const slider = document.querySelector(".product-slider");
            const prevButton = document.querySelector(".slider-prev");
            const nextButton = document.querySelector(".slider-next");

            const productWidth = slider.querySelector(".product-item").offsetWidth + 15; // عرض المنتج مع الفجوة
            const maxScroll = slider.scrollWidth - slider.clientWidth;

            let scrollAmount = 0;

            // تحديث حالة الأزرار
            const updateButtons = () => {
                nextButton.disabled = scrollAmount >= maxScroll;
                prevButton.disabled = scrollAmount <= 0;
            };

            // التمرير للأمام (لليسار)
            nextButton.addEventListener("click", () => {
                if (scrollAmount < maxScroll) {
                    scrollAmount += productWidth;
                    if (scrollAmount > maxScroll) scrollAmount = maxScroll;
                    slider.style.transform = `translateX(-${scrollAmount}px)`;
                    updateButtons();
                }
            });

            // التمرير للخلف (لليمين)
            prevButton.addEventListener("click", () => {
                if (scrollAmount > 0) {
                    scrollAmount -= productWidth;
                    if (scrollAmount < 0) scrollAmount = 0;
                    slider.style.transform = `translateX(-${scrollAmount}px)`;
                    updateButtons();
                }
            });

            // تحديث الأزرار عند التحميل
            updateButtons();
        });
    </script>

    <p>-------------------------------------------------------------------------------------------------------</p>

    <!-- Start of Product الأكثر اقبالا من فئة الإلكترونيات -->

    <script>
        // $(document).ready(function() {
        //     $(".btn-add-to-cart").click(function(e) {
        //         e.preventDefault();

        //         var productId = $(this).data("product-id");
        //         var productName = $(this).data("product-name");
        //         var productPrice = $(this).data("product-price");
        //         var productImage = $(this).data("product-image");
        //         var productQuantity = $(this).closest('.product-card').find('.quantity-input').val() || 1;

        //         // إرسال طلب AJAX
        //         $.ajax({
        //             url: "wishlist_action.php",
        //             type: "POST",
        //             data: {
        //                 product_id: productId,
        //                 product_name: productName,
        //                 product_price: productPrice,
        //                 product_image: productImage,
        //                 quantity: productQuantity
        //             },
        //             success: function(response) {
        //                 if (response.status === "success") {
        //                     Toastify({
        //                         text: response.message,
        //                         duration: 3000,
        //                         close: true,
        //                         gravity: "top",
        //                         position: "right",
        //                         backgroundColor: "#4caf50",
        //                     }).showToast();
        //                 } else {
        //                     Toastify({
        //                         text: response.message,
        //                         duration: 3000,
        //                         close: true,
        //                         gravity: "top",
        //                         position: "right",
        //                         backgroundColor: "#f44336",
        //                     }).showToast();
        //                 }
        //             },
        //             error: function() {
        //                 Toastify({
        //                     text: "حدث خطأ غير متوقع.",
        //                     duration: 3000,
        //                     close: true,
        //                     gravity: "top",
        //                     position: "right",
        //                     backgroundColor: "#f44336",
        //                 }).showToast();
        //             }
        //         });
        //     });
        // });




        // document.querySelectorAll(".add-to-cart").forEach((button) => {
        //     button.addEventListener("click", function() {
        //         const productId = this.dataset.id;
        //         const productName = this.dataset.name;
        //         const productPrice = this.dataset.price;
        //         const productImage = this.dataset.image;
        //         const productQuantity = this.dataset.quantity;

        //         // إرسال المنتج إلى العربة باستخدام Fetch
        //         fetch("add_to_cart.php", {
        //                 method: "POST",
        //                 headers: {
        //                     "Content-Type": "application/x-www-form-urlencoded",
        //                 },
        //                 body: `id=${productId}&name=${productName}&price=${productPrice}&image=${productImage}&quantity=${productQuantity}`,
        //             })
        //             .then((response) => {
        //                 if (response.ok) {
        //                     // عرض Toast لإضافة ناجحة
        //                     Toastify({
        //                         text: `✅ تم إضافة "${productName}" (${productQuantity}) إلى العربة بنجاح!`,
        //                         duration: 3000, // مدة العرض
        //                         close: true, // زر الإغلاق
        //                         gravity: "top", // الموضع: أعلى
        //                         position: "right", // الموضع: يمين
        //                         backgroundColor: "#4caf50", // لون الخلفية
        //                         stopOnFocus: true, // توقف عند التمرير
        //                         avatar: `../uploads/img/${productImage}`, // الصورة
        //                     }).showToast();
        //                 } else {
        //                     // عرض Toast لخطأ
        //                     Toastify({
        //                         text: "❌ حدث خطأ أثناء إضافة المنتج.",
        //                         duration: 3000,
        //                         close: true,
        //                         gravity: "top",
        //                         position: "right",
        //                         backgroundColor: "#f44336", // لون الخلفية للخطأ
        //                         stopOnFocus: true,
        //                     }).showToast();
        //                 }
        //             })
        //             .catch((error) => {
        //                 // عرض Toast لخطأ في الشبكة
        //                 Toastify({
        //                     text: "❌ حدث خطأ في الشبكة. حاول لاحقًا.",
        //                     duration: 3000,
        //                     close: true,
        //                     gravity: "top",
        //                     position: "right",
        //                     backgroundColor: "#f44336",
        //                     stopOnFocus: true,
        //                 }).showToast();
        //             });
        //     });
        // });
    </script>




    <!-- End of Product section -->




    <script>
        // تحديث الكمية عند الضغط على الزر
        document.querySelectorAll('.quantity-left-minus, .quantity-right-plus').forEach(button => {
            button.addEventListener('click', function() {
                const type = this.dataset.type;
                const id = this.dataset.id;
                const input = document.getElementById(`quantity_${id}`);
                let value = parseInt(input.value);

                if (type === 'minus' && value > 1) {
                    value--;
                } else if (type === 'plus') {
                    value++;
                }

                input.value = value;
            });
        });

        // إضافة المنتج إلى العربة باستخدام AJAX
        // ههههههههههههههههههههههههههههههههههههههههههههههههههههههههههه
    </script>











    <!-- تضمين ملف JavaScript الخارجي -->
    <script src="./assets/cart.js"></script>

    <?php
    require 'assets/footer.php';
    ?>