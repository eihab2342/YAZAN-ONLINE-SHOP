<?php
session_start();
require '../config/connection.php';
require '../config/functions.php';

// تأكد من وجود userID في الجلسة
if (!isset($_SESSION['userID'])) {
    showAlerts(null, "الرجاء تسجيل الدخول أولاً", "../login.php");
}

$pageTitle = 'YAZAN | حسابي';
$user_id = $_SESSION['userID']; // تأكد أن user_id موجود في الجلسة

// جلب بيانات المستخدم
$query = "SELECT * FROM users_data WHERE userID = $user_id";
$result = mysqli_query($conn, $query);

if ($result) {
    $user = mysqli_fetch_assoc($result);
    // التأكد من أن المصفوفة تحتوي على البيانات المطلوبة
    if (!isset($user['full_name']) || !isset($user['phone_num']) || !isset($user['gender'])) {
        showAlerts(null, "لا توجد بيانات كاملة للمستخدم.", "../login.php");
    }
} else {
    die("فشل جلب بيانات المستخدم: " . mysqli_error($conn));
}

// if ($result) {
//     $user = mysqli_fetch_assoc($result);
// } else {
//     die("فشل جلب بيانات المستخدم: " . mysqli_error($conn));
// }

// تحديث بيانات المستخدم
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone_num = mysqli_real_escape_string($conn, $_POST['phone_num']);
    // $gender = mysqli_real_escape_string($conn, $_POST['gender']);

    // معالجة رفع الصورة
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = '../uploads/img/' . $image;
    
    if (!empty($image)) {
        if (move_uploaded_file($image_tmp, $image_folder)) {
            // إذا تم رفع الصورة بنجاح، نقوم بتحديث قاعدة البيانات مع اسم الصورة الجديد
            $update_image_query = "UPDATE users_data SET user_Image = '$image' WHERE userID = $user_id";
            mysqli_query($conn, $update_image_query);
        }
    }

    // تحديث البيانات في الجدول
    $update_query = "
        UPDATE users_data 
        SET username = '$username', 
            email = '$email', 
            full_name = '$full_name', 
            phone_num = '$phone_num'
        WHERE userID = $user_id
    ";

    if (mysqli_query($conn, $update_query)) {
        echo "<div class='alert alert-success'>تم تحديث البيانات بنجاح.</div>";
        header("Refresh:1"); // إعادة تحميل الصفحة بعد 1 ثانية
    } else {
        echo "<div class='alert alert-danger'>حدث خطأ أثناء التحديث: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getTitle($pageTitle); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid #007bff;
        }
        .logout-btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <a href="index.php" class="btn btn-outline-secondary position-absolute" style="top: 20px; left: 20px;">
            <i class="fas fa-arrow-left"></i> 
        </a>

        <!-- Header Section -->
        <div class="text-center mb-4">
            <?php if (!empty($user['user_Image'])): ?>
                <img src="../uploads/img/<?php echo $user['user_Image']; ?>" alt="User Profile" class="profile-picture mb-3">
            <?php else: ?>
                <img src="../uploads/img/icon.png" alt="Default Profile" class="profile-picture mb-3">
            <?php endif; ?>
            <h1 class="mb-2">مرحباً، <span id="user-name"><?php echo $_SESSION['username'] ?></span></h1>
            <p class="text-muted">هنا يمكنك إدارة بيانات حسابك بكل سهولة.</p>
            <a href="../logout.php" class="logout-btn text-decoration-none">تسجيل الخروج</a>
        </div>

        <div class="row g-4">
            <!-- User Info -->
            <div class="col-lg-6">
                <div class="card p-3">
                    <h5 class="card-title">بيانات الحساب</h5>
                    <p><strong>الاسم الكامل:</strong> <span id="user-fullname"><?php echo $user['full_name']  ?></span></p>
                    <p><strong>البريد الإلكتروني:</strong> <span id="user-email"><?php echo $user['email'] ?></span></p>
                    <p><strong>رقم الهاتف:</strong> <span id="user-phone"><?php echo $user['phone_num'] ?></span></p>
                </div>
            </div>

            <!-- Edit Info -->
            <div class="col-lg-6">
                <div class="card p-3">
                    <h5 class="card-title">تعديل البيانات</h5>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="username" class="form-label"> اسم المستخدم</label>
                            <input type="text" id="username" name="username" class="form-control" value="<?php echo $user['username']; ?>" placeholder="أدخل اسمك الكامل">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">الاسم الكامل</label>
                            <input type="text" id="username" name="full_name" class="form-control" value="<?php echo $user['full_name']; ?>" placeholder="أدخل اسمك الكامل">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" placeholder="example@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">رقم الهاتف</label>
                            <input type="text" id="phone" name="phone_num" class="form-control" value="<?php echo $user['phone_num']; ?>" placeholder="أدخل رقم الهاتف">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">صورة الملف الشخصي</label>
                            <input type="file" name="image" id="image">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">حفظ التعديلات</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Additional Features -->
        <div class="row g-4 mt-4">
            <!-- Password Change -->
            <div class="col-lg-6">
                <div class="card p-3">
                    <h5 class="card-title">تغيير كلمة المرور</h5>
                    <form>
                        <div class="mb-3">
                            <label for="current-password" class="form-label">كلمة المرور الحالية</label>
                            <input type="password" id="current-password" class="form-control" placeholder="********">
                        </div>
                        <div class="mb-3">
                            <label for="new-password" class="form-label">كلمة المرور الجديدة</label>
                            <input type="password" id="new-password" class="form-control" placeholder="********">
                        </div>
                        <button type="submit" class="btn btn-warning w-100">تحديث كلمة المرور</button>
                    </form>
                </div>
            </div>

            <!-- Activity Logs -->
            <div class="col-lg-6">
                <div class="card p-3">
                    <h5 class="card-title">آخر النشاطات</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">تسجيل الدخول: 2024-11-23 14:00</li>
                        <li class="list-group-item">تحديث البريد الإلكتروني: 2024-11-20</li>
                        <li class="list-group-item">إضافة رقم هاتف جديد: 2024-11-15</li>
                    </ul>
                </div>
            </div>


            <?php  
                        $result = mysqli_query($conn, "SELECT * FROM orders WHERE userID = '$user_id'");
                        if ($result && mysqli_num_rows($result) > 0) {
                            $order_num = 1;
                            while ($order = mysqli_fetch_assoc($result)) {
                                echo '<div class="col-lg-6">
                                        <div class="card p-3">
                                            <h5 class="card-title">طلباتي</h5>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">طلب ' . $order_num . ' - ' . htmlspecialchars($order['status'], ENT_QUOTES, 'UTF-8') . '</li>
                                            </ul>
                                        </div>
                                    </div>';
                                $order_num++;
                            }
                                } else {
                            echo '<p class="text-center">لا توجد طلبات حتى الآن.</p>';
                        }
                ?>
        </div>
    </div>

    <!-- Bootstrap JS & Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
