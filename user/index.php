    <?php
    require '../config/connection.php';
    require '../config/functions.php';
    require 'assets/header.php';

    // if(!isset($_COOKIE['username'])) {
    //   showAlerts(null, "fgdfgdfgdfg", null);
    // }
    $pageTitle = 'YAZAN | الرئيسية';
    ?>
    <!-- title of page -->
    <title><?php echo getTitle($pageTitle); ?></title>



    <!-- this link is to style cards -->
    <link rel="stylesheet" href="assets/css/styles.css">

    <!-- this block for add to cart notification -->
    <div id="notification" style="display:none; position: fixed; top: 10px; left: 50%; transform: translateX(-50%); padding: 10px; background-color: #28a745; color: white; border-radius: 5px; z-index: 9999;">
      تم إضافة المنتج إلى العربة!
    </div>
    <div id="error-notification" style="display:none; position: fixed; top: 10px; left: 50%; transform: translateX(-50%); padding: 10px; background-color: #dc3545; color: white; border-radius: 5px; z-index: 9999;">
      حدث خطأ أثناء إضافة المنتج إلى العربة.
    </div>

    <script>
      function playSuccessSound() {
        var audio = new Audio('../uploads/sounds/success.mp4'); // تأكد من أن المسار صحيح
        audio.play();
      }
    </script>








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

    <!-- End of Scroll bar To Display Categories ------------------------- -->



    <!-- Impoetant for main image -->
    <div class="background-section col-sm-12"></div>

    <!-- Container of Cards -->
    <div class="container mt-4">
      <div class="row">
        <!-- الكارد الأول مع 4 صور -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
          <div class="card1">
            <div class="card-header1">
              تخفيضات الجمعة البيضاء | احتياجاتك اليومية
            </div>
            <div class="card-body">
              <!-- الصور داخل الكارد -->
              <img src="../uploads/img/49.jpg" alt="عروض اقل من 49" class="top-left">
              <img src="../uploads/img/149.jpg" alt="عروض اقل من 149" class="top-right">
              <img src="../uploads/img/199.jpg" alt="عروض اقل من 199" class="bottom-left">
              <img src="../uploads/img/elec.jpg" alt="عروض وتخفيضات" class="bottom-right">
            </div>
            <div class="card-footer1">
              <a href="#" class="text-primary">المزيد من العروض</a>
            </div>
          </div>
        </div>

        <!-- الكارد الثاني -->
        <div class="col-lg-4 col-md-6 col-sm-6 mb-3">
          <div class="card1">
            <div class="card-header1">
              تخفيضات الجمعة البيضاء | احتياجاتك اليومية
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-6 mb-3">
                  <img src="../uploads/img/49.jpg" alt="عروض اقل من 49" class="img-fluid">
                </div>
                <div class="col-6 mb-3">
                  <img src="../uploads/img/149.jpg" alt="عروض اقل من 149" class="img-fluid">
                </div>
                <div class="col-6 mb-3">
                  <img src="../uploads/img/199.jpg" alt="عروض اقل من 199" class="img-fluid">
                </div>
                <div class="col-6 mb-3">
                  <img src="../uploads/img/elec.jpg" alt="عروض وتخفيضات" class="img-fluid">
                </div>
              </div>
            </div>
            <div class="card-footer1">
              <a href="#" class="text-primary">المزيد من العروض</a>
            </div>
          </div>
        </div>

        <!-- الكارد الثالث -->
        <div class="col-lg-4 col-md-12 col-sm-12 mb-3">
          <div class="card1">
            <div class="card-header1 text-center">
              خصومات وتقسيط
            </div>
            <div class="card-body">
              <ul>
                <li>خصم 10% باستخدام بطاقة QNB</li>
                <li>تقسيط بدون فوائد عبر البنك الأهلي</li>
                <li>خصم 15% لعملاء فودافون كاش</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- start of section 3 ===> only appear on large screens -->
    <div class="container mt-5 d-none d-lg-block">
      <div class="row justify-content-center">
        <?php
        $sql = "SELECT * FROM products_data LIMIT 20";
        $result = $conn->query($sql);

        // تحقق إذا كانت هناك نتائج
        if ($result->num_rows > 0) {
          // عرض المنتجات
          while ($row = $result->fetch_assoc()) {
            $product_id = $row['id'];
            $product_name = $row['name'];
            $product_image = $row['image'];
            $old_price = $row['old_price'];
            $price = $row['price'];
            $discount = (($row['old_price'] - $row['price']) / $row['old_price']) * 100;
        ?>
            <div class="col-md-3 mb-4">
              <div class="product-card">
                <div class="product-image">
                  <!-- نسبة الخصم على اليمين فوق الصورة -->
                  <span class="discount-badge"><?php echo number_format($discount, 1); ?>%OFF</span>
                  <img src="../uploads/img//<?php echo $product_image; ?>" alt="Product Image">
                </div>
                <div class="product-name"><?php echo $product_name; ?></div>
                <div class="product-price">
                  <?php echo $price; ?> EG
                  <span class="old-price"><?php echo $old_price; ?> EG</span>
                </div>
                <button class="btn add-to-cart btn_add_cart"
                  data-id="<?php echo $product_id; ?>"
                  data-name="<?php echo $product_name; ?>"
                  data-price="<?php echo $product_price; ?>"
                  data-image="<?php echo $product_image; ?>"
                  data-quantity="1"
                  onclick="playSuccessSound()">
                  <i class="fa-solid fa-cart-shopping"></i>
                </button>
              </div>
            </div>
        <?php
          }
        } else {
          echo "لا توجد منتجات.";
        }


        ?>
      </div>
    </div>


    <!-- /*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/**/ */ -->

    <!-- ************************************************************************************************* -->

    <hr>

    <!-- Start of section 4 ===> only appears on small screens -->

    <div class="container mt-4">
      <div class="mobile-product-list">
        <!-- Loop through products -->
        <?php
        $sql = "SELECT id, name, image, price, old_price FROM products_data WHERE price <= 200 ORDER BY RAND() ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          echo '<h3>عروض و منتجات اقل من 200 جنيه</h3>';
          while ($row = $result->fetch_assoc()) {
            // حساب نسبة الخصم
            $discount = round(((($row['old_price'] - $row['price']) / $row['old_price']) * 100));
            echo '
      <div class="mobile-product-card col-6">
        <span class="mobile-discount-label">' . $discount . '% Off</span>
        <img src="../uploads/img/' . $row['image'] . '" class="mobile-product-img" alt="' . $row['name'] . '" style="height: 180px;">
        <div class="mobile-card-body text-center">
          <p class="mobile-product-title">' . htmlspecialchars($row['name']) . '</p>
          <p class="mobile-product-price text-danger mt-1">EGP ' . $row['price'] . '</p>
          <p class="mobile-product-old-price text-muted text-decoration-line-through mt-1">EGP ' . $row['old_price'] . '</p>
        <button class="btn add-to-cart bg-warning text-dark"
                data-id="' . $row['id'] . '"
                data-name="' . htmlspecialchars($row['name']) . '"
                data-price="' . $row['price'] . '"
                data-image="' . $row['image'] . '"
                data-quantity="1"
                onclick="playSuccessSound()">🛒
        </button>
        </div>
      </div>';
          }
        } else {
          echo "<p>No products available</p>";
        }
        ?>
      </div>
    </div>




    <!-- swiper num 2 -->
    <?php
    $sql = "SELECT * FROM products_data LIMIT 15";
    $result = mysqli_query($conn, $sql);

    // Fetch data into an array
    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $products[] = $row;
    }

    // Close the database connection
    ?>
    <div class="swiper-container" style="position: relative; margin-top: 70px;">
      <div class="swiper-wrapper">
        <?php
        foreach ($products as $product) {
          echo '<div class="swiper-slide">
        <a href="product_details.php?product_id=' . $product['id'] . '" style="text-decoration: none;">
            <img src="../uploads/img/' . $product['image'] . '" alt="' . $product['name'] . '" style="height: 150px; width: 150px;">
            <h6>' . $product['name'] . '</h6>
        </a>
        <div class="col">
            <p class="text-danger fs-5">' . $product['price'] . ' ج.م</p>
            <p class="old-price">' . $product['old_price'] . ' ج.م</p>
        </div>
        <button class="btn add-to-cart bg-warning text-dark"
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
      .swiper-button-next,
      .swiper-button-prev {
        position: absolute;
        /* جعل الأزرار مرتبطة بموقع الـ swiper */
        top: 20%;
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
    <!-- End of Swiper -->

    <hr>
    <!--  -->
    <?php
    $products_query = mysqli_query($conn, "SELECT * FROM products_data LIMIT 15");
    ?>
    <div style="padding-block: 24px; background-color: rgb(255, 255, 255);">
      <div class="row">
        <div class="col-md-12">
          <div class="container">
            <div class="row">
              <div class="col-md-12 px-3 pb-4">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                    <img srcset="/_next/static/media/discounted_products.bbe8cd65.svg" alt="خصومات" style="height: 40px;">
                    <h6 class="mx-2" style="font-size: 18px; font-weight: 700;">خصومات رائعة</h6>
                  </div>

                  <button class="kenzz-button btn btn-primary" style="background-color: #7e00e1; color: #fff; border-radius: 10px;">
                    <span>شوف كل المنتجات</span>
                  </button>
                </div>
              </div>

              <!-- المنتجات -->
              <div class="col-md-12">
                <div class="infinite-scroll-component__outerdiv">
                  <div class="infinite-scroll-component row flex-nowrap pb-3" style="height: auto; overflow: auto;">

                    <?php
                    while ($product = mysqli_fetch_assoc($products_query)) {
                      $discount = ($product['old_price'] && $product['old_price'] > $product['price']) ?
                        (round(($product['old_price'] - $product['price']) / $product['old_price'] * 100)) : 0;
                    ?>

                      <div class="col-md-3 col-6 mb-4">
                        <div class="product-card" style="border-radius: 10px; padding: 10px; background: #f9f9f9; box-shadow: 0 0 8px rgba(0,0,0,0.1);">
                          <a href="product_details.php?product_id=<?php echo $product['id']; ?>" style="text-decoration: none; color: inherit;">
                            <img src="../uploads/img/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px;">
                          </a>
                            <h5 style="font-size: 18px; margin-top: 10px;"><?php echo $product['name']; ?></h5>

                            <p style="font-weight: bold; color: red; font-size: 20px;">
                              <?php echo $product['price']; ?> ج.م
                            </p>

                            <!-- أيقونة عربة التسوق -->
                            <button class="btn btn-warning add-to-cart bg-warning text-dark"
                              data-id="<?php echo $product['id']; ?>"
                              data-name="<?php echo htmlspecialchars($product['name']); ?>"
                              data-price="<?php echo $product['price']; ?>"
                              data-image="<?php echo $product['image']; ?>"
                              onclick="playSuccessSound()">🛒
                            </button>
                        </div>
                        <!-- </a> -->
                      </div>

                    <?php } ?>

                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>































    <script src="./assets/cart.js"></script>
    <?php
    require 'assets/footer.php';
    ?>