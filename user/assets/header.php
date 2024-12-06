<?php
session_start();
require '../config/connection.php';
// header("refresh=1s;");

// التحقق من تسجيل الدخول باستخدام الجلسة أو الكوكيز
// التحقق من تسجيل الدخول باستخدام الجلسة أو الكوكيز
if (isset($_SESSION['userID']) && isset($_SESSION['username'])) {
    // إذا كان المستخدم قد سجل دخول باستخدام الجلسة
    $userID = intval($_SESSION['userID']); // تحويل إلى عدد صحيح
    $username = htmlspecialchars($_SESSION['username']); // حماية من XSS
    // $role = htmlspecialchars($_SESSION['role']);
} elseif (
    isset($_COOKIE['userID']) &&
    isset($_COOKIE['username']) &&
    isset($_COOKIE['password'])
) {
    // إذا لم تكن هناك جلسة ولكن توجد كوكيز
    $userID = intval($_COOKIE['userID']);
    $username = htmlspecialchars($_COOKIE['username']);
    $hashed_pass = $_COOKIE['password'];

    // يجب التأكد من صلاحية المستخدم عن طريق قاعدة البيانات
    $stmt = $conn->prepare("SELECT userID, username, role FROM users_data WHERE userID = ? AND password = ?");
    $stmt->bind_param("is", $userID, $hashed_pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['userID'] = $row['userID'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
    } else {
        // الكوكيز غير صحيحة
        header("location: ../login.php");
        exit;
    }
} else {
    // لا جلسة ولا كوكيز
    header("location: ../login.php");
    exit;
}
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../uploads/img/logo3.jpg" type="image/x-icon">
    <!-- Bootstrap CSS (أحدث نسخة) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery (إذا كنت بحاجة إليه) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">

    <!-- خط جوجل: Nunito و Open Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Custom Stylesheets -->
    <link rel="stylesheet" type="text/css" href="css/vendor.css">
    <link rel="stylesheet" type="text/css" href="style.css">


    <!-- swiper style -->
    <!-- <link rel="stylesheet" href="../uploads/css/stylefoodmart.css"> -->
    <!-- Below css for cards in index.php -->
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toastify JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<!DOCTYPE html>

<body style="direction: rtl;">

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <defs>
            <symbol xmlns="http://www.w3.org/2000/svg" id="link" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12 19a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0-4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm-5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm7-12h-1V2a1 1 0 0 0-2 0v1H8V2a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3Zm1 17a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-9h16Zm0-11H4V6a1 1 0 0 1 1-1h1v1a1 1 0 0 0 2 0V5h8v1a1 1 0 0 0 2 0V5h1a1 1 0 0 1 1 1ZM7 15a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0 4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="arrow-right" viewBox="0 0 24 24">
                <path fill="currentColor" d="M17.92 11.62a1 1 0 0 0-.21-.33l-5-5a1 1 0 0 0-1.42 1.42l3.3 3.29H7a1 1 0 0 0 0 2h7.59l-3.3 3.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l5-5a1 1 0 0 0 .21-.33a1 1 0 0 0 0-.76Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="category" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19 5.5h-6.28l-.32-1a3 3 0 0 0-2.84-2H5a3 3 0 0 0-3 3v13a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-10a3 3 0 0 0-3-3Zm1 13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-13a1 1 0 0 1 1-1h4.56a1 1 0 0 1 .95.68l.54 1.64a1 1 0 0 0 .95.68h7a1 1 0 0 1 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="calendar" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19 4h-2V3a1 1 0 0 0-2 0v1H9V3a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3Zm1 15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-7h16Zm0-9H4V7a1 1 0 0 1 1-1h2v1a1 1 0 0 0 2 0V6h6v1a1 1 0 0 0 2 0V6h2a1 1 0 0 1 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="heart" viewBox="0 0 24 24">
                <path fill="currentColor" d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Zm-1.41 7.46L12 18.81l-6.75-6.74a4.28 4.28 0 0 1 3-7.3a4.25 4.25 0 0 1 3 1.25a1 1 0 0 0 1.42 0a4.27 4.27 0 0 1 6 6.05Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="plus" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="minus" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19 11H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 24 24">
                <path fill="currentColor" d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="check" viewBox="0 0 24 24">
                <path fill="currentColor" d="M18.71 7.21a1 1 0 0 0-1.42 0l-7.45 7.46l-3.13-3.14A1 1 0 1 0 5.29 13l3.84 3.84a1 1 0 0 0 1.42 0l8.16-8.16a1 1 0 0 0 0-1.47Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="trash" viewBox="0 0 24 24">
                <path fill="currentColor" d="M10 18a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1ZM20 6h-4V5a3 3 0 0 0-3-3h-2a3 3 0 0 0-3 3v1H4a1 1 0 0 0 0 2h1v11a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8h1a1 1 0 0 0 0-2ZM10 5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v1h-4Zm7 14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8h10Zm-3-1a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="star-outline" viewBox="0 0 15 15">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M7.5 9.804L5.337 11l.413-2.533L4 6.674l2.418-.37L7.5 4l1.082 2.304l2.418.37l-1.75 1.793L9.663 11L7.5 9.804Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="star-solid" viewBox="0 0 15 15">
                <path fill="currentColor" d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="search" viewBox="0 0 24 24">
                <path fill="currentColor" d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="user" viewBox="0 0 24 24">
                <path fill="currentColor" d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19ZM12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 15 15">
                <path fill="currentColor" d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
            </symbol>
            <!-- أيقونة التنبيهات -->
            <symbol xmlns="http://www.w3.org/2000/svg" id="notifications" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12 3a6 6 0 0 0-6 6v6.72l-1.43 1.43a1 1 0 0 0-.29.71V18a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-2.14a1 1 0 0 0-.29-.71L18 15.72V9a6 6 0 0 0-6-6Zm1 14h-2v-2h2v2Zm-1-12a4 4 0 0 1 4 4v5h-8V9a4 4 0 0 1 4-4Z" />
            </symbol>
            <!-- wishlist -->
            <symbol xmlns="http://www.w3.org/2000/svg" id="wishlist" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
            </symbol>

        </defs>
    </svg>

    <!-- <div class="preloader-wrapper">
      <div class="preloader">
      </div>
    </div> -->

    <?php
    // if(!isset($_COOKIE['userID'])) {
    //     showAlerts(null, "يجب تسجيل الدخول اولا", "../login.php");
    // }
    // $userID = $_COOKIE['userID'];
    // $userID = $_SESSION['userID'];

    $sql = "SELECT * FROM cart WHERE userID = $userID";
    $result = mysqli_query($conn, $sql);

    // حساب إجمالي المبلغ
    $total = 0;
    $cartItems = [];

    // إذا كانت هناك نتائج في السلة
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // حساب المجموع الإجمالي
            $total += $row['product_price'] * $row['quantity'];
            $cartItems[] = $row; // تخزين المنتجات في المصفوفة
        }
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script>
    // تحديث الكمية عند الضغط على الزر
    document.querySelectorAll('.quantity-left-minus, .quantity-right-plus').forEach(button => {
        button.addEventListener('click', function () {
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

            // تحديث الكمية في السلة باستخدام AJAX
            $.ajax({
                url: "update_cart.php", // تأكد من أن هذا الملف يعالج تحديث الكمية في قاعدة البيانات
                type: "POST",
                data: {
                    product_id: id,
                    quantity: value
                },
                success: function(response) {
                    // بعد التحديث، يمكنك تحديث الإجمالي أو العناصر في السلة إذا لزم الأمر
                    $("#notification").fadeIn().delay(3000).fadeOut();
                    updateCart(); // لتحديث السلة بعد تعديل الكمية
                },
                error: function() {
                    alert("حدث خطأ أثناء تحديث الكمية.");
                }
            });
        });
    });

    // إضافة المنتج إلى العربة باستخدام AJAX
    // $(".add-to-cart").click(function() {
    //     var product_id = $(this).data("id");
    //     var product_name = $(this).data("name");
    //     var product_price = $(this).data("price");
    //     var quantity = $(this).data("quantity");
    //     var product_image = $(this).data("image");

    //     $.ajax({
    //         url: "addtocart.php",
    //         type: "POST",
    //         data: {
    //             product_id: product_id,
    //             product_name: product_name,
    //             product_price: product_price,
    //             quantity: quantity,
    //             product_image: product_image 
    //         },
    //         success: function(response) {
    //             // إشعار بعد إضافة المنتج بنجاح
    //             $("#notification").fadeIn().delay(3000).fadeOut();
    //             updateCart(); // تحديث السلة بعد إضافة المنتج
    //         },
    //         error: function() {
    //             alert("حدث خطأ أثناء إضافة المنتج إلى العربة.");
    //         }
    //     });
    // });

    // // دالة لتحديث السلة
    // function updateCart() {
    //     $.ajax({
    //         url: 'get_cart.php', // الملف الذي يعرض السلة المحدثة
    //         method: 'GET',
    //         success: function(response) {
    //             var data = JSON.parse(response);
    //             // تحديث واجهة المستخدم مع العناصر الجديدة في السلة
    //             $('.cart-items').html(data.cartItems);
    //             $('.cart-badge').text(data.cartCount); // تحديث عدد المنتجات في السلة
    //             $('.cart-total').text(data.cartTotal); // تحديث إجمالي السلة
    //         }
    //     });
    // }
</script> -->


    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="My Cart">
        <div class="offcanvas-header justify-content-center">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <!-- --------------------------NO need------------------------ -->
        <div class="offcanvas-body">
            <div class="order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your cart111</span>
                    <span class="badge bg-primary rounded-pill cart-badge"><?php echo count($cartItems); ?></span>
                </h4>
                <ul class="list-group mb-3 cart-items">
                    <?php
                    if (!empty($cartItems)) {
                        foreach ($cartItems as $item) {
                            echo "<li class='list-group-item d-flex justify-content-between lh-sm'>
                                    <div>
                                        <h6 class='my-0'>{$item['product_name']}</h6>
                                    </div>
                                    <span class='text-body-secondary'>{$item['product_price']} * {$item['quantity']}</span>
                                </li>";
                        }
                    } else {
                        echo "<li class='list-group-item'>سلة التسوق فارغة</li>";
                    }
                    ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total</span>
                        <strong><?php echo $total; ?></strong>
                    </li>
                </ul>

                <a href="check_out.php" class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</a>
            </div>
        </div>
    </div>

    <!-- </div> -->
    <!-- --------------------------NO need------------------------ -->





    <!-- <header> -->
    <style>
        /* تنسيق مظهر أيقونة العربة */
        .cart-icon {
            position: relative;
            /* لتحديد الموضع النسبي للعنصر */
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }

        /* تنسيق مظهر عدد العناصر في العربة */
        #cart-count {
            position: absolute;
            top: -5px;
            /* تعديل المسافة من الأعلى */
            right: -5px;
            /* تعديل المسافة من اليمين */
            background-color: #ff5733;
            /* لون الخلفية، يمكنك تغييره */
            color: white;
            /* لون النص */
            font-size: 12px;
            /* حجم النص */
            font-weight: bold;
            /* جعل النص عريضًا */
            border-radius: 50%;
            /* جعل الخلفية دائرية */
            padding: 2px 6px;
            /* تحديد المسافة داخل الدائرة */
            min-width: 20px;
            /* لضمان وجود مساحة كافية للنص */
            text-align: center;
            /* محاذاة النص في المنتصف */
        }
    </style>
    <header>
        <div class="container-fluid">
            <div class="row py-3 border-bottom align-items-center">
                <!-- الشعار: سيظل مرئيًا في جميع الأحجام -->
                <div class="col-12 col-lg-3 d-flex justify-content-start align-items-center mt-sm-3">
                    <div class="main-logo ms-2 d-flex align-items-center">
                        <a href="index.php" class="d-flex align-items-center text-decoration-none">
                            <img src="../uploads/img/icon.png" alt="YAZAN ONLINE SHOP" class="img-fluid" style="height: 60px; width: 60px;">
                            <div class="ms-2 text-end">
                                <h1 style="color: #26415E; margin: 0;">YAZAN</h1>
                                <h5 style="color: #274D60; margin: 0;">ONLINE SHOP</h5>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- البحث -->
                <div class="col-12 col-lg-4 d-lg-flex justify-content-center align-items-center mt-3 mt-sm-4 mt-lg-0">
                    <form class="w-100" action="search.php" method="GET" id="search-form">
                        <input type="text" id="search-input" class="form-control me-2" name="query" placeholder="ابحث عن المنتجات..." aria-label="Search">
                    </form>
                    <div id="search-results" class="dropdown-menu" style="width: 90%;"></div> <!-- لعرض نتائج البحث -->
                </div>

                <!-- الدعم والأيقونات: ستكون مرئية فقط على الشاشات الكبيرة -->
                <div class="col-12 col-lg-3 d-none d-lg-flex justify-content-end align-items-center gap-3">
                    <div class="support-box text-end">
                        <span class="fs-6 text-muted">الدعم والتواصل</span>
                        <h5 class="mb-0">
                            <a href="https://wa.me/201119842314" target="_blank" class="text-decoration-none">
                                <i class="fab fa-whatsapp" style="font-size: 24px; color: #25D366;"></i>
                            </a>
                        </h5>
                    </div>
                    <div class="icons d-flex gap-2">
                        <a href="account.php" class="rounded-circle bg-light p-2">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#user"></use>
                            </svg>
                        </a>
                        <a href="#" class="rounded-circle bg-light p-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWishlist" aria-controls="offcanvasWishlist">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#wishlist"></use>
                            </svg>
                        </a>
                        <!-- <a href="#" class="rounded-circle bg-light p-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                            <use xlink:href="#search"></use>
                        </svg>
                    </a> -->
                        <a href="#" class="rounded-circle bg-light p-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotifications" aria-controls="offcanvasNotifications">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#notifications"></use>
                            </svg>
                        </a>
                        <!-- data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart" -->
                        <a href="cart.php" class=" cart-icon rounded-circle bg-light p-2" style="text-decoration: none;">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#cart"></use>
                            </svg>
                            <span id="cart-count">0</span>
                        </a>
                        <!-- <li class="nav-item cart-icon">
                            <a class="nav-link" href="../cart.php">
                                <i class="bi bi-cart"></i>
                                Cart
                                <span id="cart-count">0</span>
                            </a>
                        </li> -->

                    </div>
                </div>
            </div>

            <!-- إضافة كود JavaScript للبحث التلقائي -->
            <script>
                $(document).ready(function() {
                    $('#search-input').keyup(function() {
                        var query = $(this).val();

                        if (query.length > 1) { // إذا كان النص المدخل أطول من حرفين
                            $.ajax({
                                url: 'search.php', // الصفحة التي ستستقبل الاستعلامات
                                method: 'GET',
                                data: {
                                    query: query
                                }, // إرسال النص المدخل في المتغير query
                                success: function(response) {
                                    var results = JSON.parse(response); // تحويل الاستجابة إلى JSON
                                    var resultsHtml = '';

                                    // التحقق إذا كانت النتائج تحتوي على منتجات
                                    if (results.length > 0) {
                                        resultsHtml = '<ul class="list-unstyled">';

                                        // عرض كل منتج في قائمة منسدلة (dropdown)
                                        $.each(results, function(index, product) {
                                            resultsHtml += '<li><a href="product_details.php?product_id=' + product.id + '" class="dropdown-item">' + product.name + '</a></li>';
                                        });
                                        resultsHtml += '</ul>';
                                    } else {
                                        resultsHtml = '<p class="dropdown-item">لا توجد نتائج</p>';
                                    }

                                    // عرض النتائج في الـ div المخصص
                                    $('#search-results').html(resultsHtml).addClass('show'); // إضافة class 'show' لعرض الـ dropdown
                                }
                            });
                        } else {
                            $('#search-results').html('').removeClass('show'); // إخفاء النتائج إذا كان النص المدخل أقل من 3 حروف
                        }
                    });

                    // إخفاء الـ dropdown عند النقر خارج الحقل
                    $(document).click(function(e) {
                        if (!$(e.target).closest('#search-input').length) {
                            $('#search-results').removeClass('show');
                        }
                    });
                });
            </script>
        </div>
        <!-- القائمة الجانبية -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">القائمة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="list-unstyled">
                    <li class="nav-item"><a class="nav-link" href="index.php">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php">المنتجات</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">الدعم</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">عربة التسوق</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders.php">طلباتي</a></li>
                </ul>
            </div>
        </div>
        <style>
            .offcanvas-body {
                background-color: #c5c5c5;
            }

            ul.list-unstyled {
                padding: 0;
                margin: 0;
            }

            ul.list-unstyled li {
                font-size: 16px;
                font-weight: bold;
                margin-bottom: 10px;
                /* مسافة بين العناصر */
            }

            ul.list-unstyled li a {
                text-decoration: none;
                color: #007bff;
                /* لون أزرق للأزرار */
                transition: color 0.3s ease;
            }

            ul.list-unstyled li a:hover {
                color: #0056b3;
                /* لون عند التحويم */
            }
        </style>

        <!-- </stylul.list-unstyled>
        <script>
            $(document).ready(function() {
                // عند الكتابة في شريط البحث
                $("input[name='query']").on("input", function() {
                    var query = $(this).val();

                    // إذا كان النص غير فارغ
                    if (query.length > 0) {
                        // إرسال الـ AJAX إلى search.php
                        $.ajax({
                            url: 'path/to/your/search.php', // مسار ملف البحث
                            type: 'GET',
                            data: {
                                query: query
                            },
                            success: function(data) {
                                var results = JSON.parse(data); // تحويل النتيجة من JSON إلى مصفوفة
                                var html = '';

                                // التحقق من وجود نتائج
                                if (results.length > 0) {
                                    results.forEach(function(product) {
                                        html += '<p>' + product.name + '</p>';
                                    });
                                } else {
                                    html = '<p>لا توجد نتائج</p>';
                                }

                                // عرض النتائج في الـ offcanvas
                                $(".offcanvas-body").html(html);
                            },
                            error: function() {
                                $(".offcanvas-body").html('<p>حدث خطأ أثناء البحث</p>');
                            }
                        });
                    } else {
                        $(".offcanvas-body").html(''); // إذا كان النص فارغًا، إخفاء النتائج
                    }
                });
            });
        </script>
        </script> -->





        <!-- الإشعارات -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNotifications" aria-labelledby="offcanvasNotificationsLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasNotificationsLabel">الإشعارات</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <!-- محتوى الإشعارات -->
            </div>
        </div>
        </div>
    </header>






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
                    <a class="nav-link" href="./cart.php">
                        <i class="bi bi-person"></i>
                        Profile
                    </a>
                </li>
                <li class="nav-item cart-icon">
                    <a class="nav-link" href="cart.php">
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


    <!--Start JS code TO count items in Cart and Update Automatecly while user add itwms to cart -->
    <script>
        // دالة لإضافة منتج إلى العربة
        function addToCart(productId, productName, productPrice, productImage, quantity) {
            fetch('add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        product_id: productId,
                        product_name: productName,
                        product_price: productPrice,
                        product_image: productImage,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message); // عرض رسالة من الخادم
                        updateCartCount(data.total_items); // تحديث العدد في أيقونة العربة
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // دالة لتحديث عدد العناصر في العربة
        function updateCartCount(totalItems) {
            document.getElementById('cart-count').textContent = totalItems;
        }

        // استدعاء دالة updateCartCount عند تحميل الصفحة لأول مرة
        window.onload = function() {
            // قم بإجراء طلب لجلب العدد الحالي للعناصر في العربة عند تحميل الصفحة
            fetch('add_to_cart.php')
                .then(response => response.json())
                .then(data => {
                    updateCartCount(data.total_items); // تحديث العدد في أيقونة العربة
                })
                .catch(error => console.error('Error:', error));
        };
    </script>
    <!--End JS code TO count items in Cart and Update Automatecly while user add itwms to cart -->


    <!-- <footer class="footer1 d-block d-lg-none bg-light position-fixed bottom-0 w-100 py-2 border-top shadow">
            <div class="container">
                <div class="row justify-content-between align-items-center text-center">
                    <div class="col">
                        <a href="account.php" class="text-decoration-none">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#user"></use>
                            </svg>
                            <p class="mb-0 small"></p>
                        </a>
                    </div>

                    <div class="col">
                        <a href="#" class="text-decoration-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                            <i class="fa-solid fa-bars"></i>
                            <p class="mb-0 small"></p>
                        </a>
                    </div>

                    <div class="col">
                        <a href="cart.php" class="text-decoration-none">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#cart"></use>
                            </svg>
                            <p class="mb-0 small"></p>
                        </a>
                    </div>

                    <div class="col">
                        <a href="#" class="rounded-circle bg-light p-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWishlist" aria-controls="offcanvasWishlist">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#wishlist"></use>
                            </svg>
                        </a>
                    </div>

                    <div class="col">
                        <a href="#" class="text-decoration-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotifications" aria-controls="offcanvasNotifications">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#notifications"></use>
                            </svg>
                            <p class="mb-0 small"></p>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
        <style>
            .footer1 {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                background-color: #f8f9fa;
                z-index: 1000;
                box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
                padding: 0;
                margin: 0;
            }

            body {
                padding-bottom: 0;
                margin: 0;
                overflow-x: hidden;
            }

            .footer1 .container {
                padding-left: 0;
                padding-right: 0;
            }

            @media (max-width: 576px) {
                .footer1 {
                    position: fixed;
                    left: 0;
                    bottom: 0;
                    width: 100%;
                    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
                }

                .footer1 .container {
                    padding-left: 0;
                    padding-right: 0;
                }
            }

            html,
            body {
                width: 100%;
                height: 100%;
                overflow-x: hidden;
            }
        </style> -->

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">