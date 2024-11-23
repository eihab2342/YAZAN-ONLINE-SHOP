<?php
    session_start();
    require '../assets/header.php';
    require '../config/connection.php';
    require '../config/functions.php';
    //  عنوان الصفحة
    $pageTitle = 'Admin| Coupons';
?>

<title><?php echo getTitle($pageTitle); ?></title>

<?php // if (isset($_SESSION['userName']) && isset($_SESSION['userID'])) {?>

<div class="container-fluid position-relative d-flex p-0">
    <!-- Spinner Start --> 
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    <!-- Spinner End -->

    <!-- Sidebar Start -->
    <?php require_once '../assets/sideBar.php'; ?>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <?php require_once '../assets/navBar.php'; 
            $do = isset($_GET['do']) ? $_GET['do'] : 'Coupons';
            if($do == 'Coupons') { 
        ?>
        <div class="container mt-5 w-75" style="direction: rtl;">
            <h2 class="text-center mb-4">إضافة كوبون جديد</h2>
            <!-- الفورم الخاص بإضافة الكوبون -->
            <form action="?do=add_Coupons" method="POST">
                <div class="form-group text-white">
                    <label for="coupon_code" class="fs-5">كود الكوبون:</label>
                    <input type="text" class="form-control bg-secondary" id="coupon_code" name="coupon_code" placeholder="أدخل كود الكوبون" required>
                </div>
                <div class="form-group text-white">
                    <label for="discount_value" class="fs-5">قيمة الخصم (%):</label>
                    <input type="number" class="form-control bg-secondary" id="discount_value" name="discount_value" placeholder="أدخل قيمة الخصم" required min="0.01" max="20" step="0.01">
                </div>
                <div class="form-group text-white">
                    <label for="expiry_date" class="fs-5">تاريخ الانتهاء:</label>
                    <input type="date" class="form-control bg-secondary text-white" id="expiry_date" name="expiry_date" required>
                </div>
                <div class="form-group text-white">
                    <label for="status" class="fs-5">الحالة:</label>
                    <select class="form-control bg-secondary" id="status" name="status" required>
                        <option value="active" class="bg-white fs-6 text-dark">مفعل</option>
                        <option value="inactive" class="bg-white fs-6 text-dark">مُعطل</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block m-4 float-start">إضافة الكوبون</button>
            </form>
        </div> 

        <?php } elseif($do == 'add_Coupons') { 

            // تحقق من البيانات المدخلة
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $coupon_code = mysqli_real_escape_string($conn, $_POST['coupon_code']);
                $discount_value = $_POST['discount_value'];
                $expiry_date = $_POST['expiry_date'];
                $status = $_POST['status'];

                // تحقق من وجود الكوبون في قاعدة البيانات
                $check_coupon_query = "SELECT * FROM coupons WHERE coupon_code = '$coupon_code'";
                $result = mysqli_query($conn, $check_coupon_query);
                if (mysqli_num_rows($result) > 0) {
                    showAlerts(null, "الكوبون موجود بالفعل!", "?do=Coupons");
                } else {
                    // إدخال الكوبون إلى قاعدة البيانات
                    $query = "INSERT INTO coupons (coupon_code, discount_value, expiry_date, status) 
                              VALUES ('$coupon_code', '$discount_value', '$expiry_date', '$status')";
                    if (mysqli_query($conn, $query)) {
                        showAlerts("تم إضافة الكوبون بنجاح!", null, "index.php");
                    } else {
                        showAlerts(null, "حدث خطأ: " . mysqli_error($conn), "?do=Coupons");
                    }
                }
            }
        }
        ?>
    </div>
    <!-- Content End -->
</div>

<!-- ربط مكتبة JavaScript الخاصة بـ Bootstrap -->
<?php  
    require '../assets/footer.php';
// } else {
//     showAlerts(null, "تم انتهاء مدة صلاحية تسجيل الدخول..برجاء تسجيل الدخول أولا ", "../login.php");
// }
?>