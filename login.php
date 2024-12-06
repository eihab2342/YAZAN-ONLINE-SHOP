<?php 
session_start();
require 'templates/headCode.php';
require './config/connection.php';
require './config/functions.php';

require './uploads/PHPMailer-master/src/Exception.php';
require './uploads/PHPMailer-master/src/PHPMailer.php';
require './uploads/PHPMailer-master/src/SMTP.php';

// التحقق من الكوكيز لتسجيل الدخول التلقائي
if (!isset($_SESSION['userID']) && isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $userName = $_COOKIE['username'];
    $hashed_pass = $_COOKIE['password'];

    $result = mysqli_query($conn, "SELECT userID, userName, password, role FROM users_data WHERE username = '$userName' LIMIT 1");

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($hashed_pass === $row['password']) { // تحقق من تطابق كلمة المرور المشفرة
            // إعداد الجلسة
            $_SESSION['username'] = $row['userName'];
            $_SESSION['userID'] = $row['userID'];
            $_SESSION['role'] = $row['role'];

            // تحويل المستخدم حسب الدور
            if ($row['role'] == 'admin') {
                header("location: admin/index.php");
            } else {
                header("location: user/index.php");
            }
            exit();
        }
    }
}

// التحقق من الجلسة الحالية
if (isset($_SESSION['role']) && isset($_SESSION['userID']) && isset($_SESSION['username'])) {
    if ($_SESSION['role'] == 'admin') {
        header("location: admin/index.php");
    } else {
        header("location: user/index.php");
    }
    exit();
}

// معالجة تسجيل الدخول
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userName = $_POST['userName'];
    $pass = $_POST['password'];

    $result = mysqli_query($conn, "SELECT userID, userName, password, role FROM users_data WHERE username = '$userName' LIMIT 1");

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($pass, $row['password'])) { 
            // إعداد الجلسة
            $_SESSION['username'] = $userName;
            $_SESSION['userID'] = $row['userID'];
            $_SESSION['role'] = $row['role'];

            // إذا اختار المستخدم "Keep me logged in"
            if (isset($_POST['remember_me'])) {
                setcookie('userID', $row['userID'], time() + (86400 * 30), "/");
                setcookie('username', $userName, time() + (86400 * 30), "/"); // صالح لمدة 30 يومًا
                setcookie('password', $row['password'], time() + (86400 * 30), "/");
            }

            // تحويل المستخدم حسب الدور
            if ($row['role'] == 'admin') {
                header("location: admin/index.php");
            } else {
                header("location: user/index.php");
            }
            exit();
        } else {
            showAlerts(null, "Invalid password", "login.php");
        }
    } else {
        showAlerts(null, "User not found", "login.php");
    }
}

?>

<!-- <div class="d-flex justify-content-center align-items-center mt-4">
    <img src="" alt="logo" class="img-fluid">
</div> -->

<section class="p-3 p-md-4 p-xl-5 mt-2">
    <div class="container">
        <div class="card border-light-subtle shadow-sm">
            <div class="row g-0">
                        <div class="col-12 col-md-6 text-bg-secondary d-none d-md-flex">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <div class="col-10 col-xl-8 py-3">
                                    <div class="main-logo">
                                        <img src="./uploads/img/logo3.jpg" alt="YAZAN ONLINE SHOP" class="img-fluid rounded" style="height: 60px; width: 60px;">
                                        <div>
                                            <h1 style="color:#26415E; margin: 0;">YAZAN</h1>
                                            <h5 style="color:#274D60; margin: 0;">ONLINE SHOP</h5>
                                        </div>
                                    </div>
                                    <hr class="border-primary-subtle mb-4">
                                        <h2 class="h1 mb-4">نصنع منتجات رقمية تساعدك على التميز.</h2>
                                        <p class="lead m-0">نكتب الكلمات، نلتقط الصور، نصنع الفيديوهات، ونتفاعل مع الذكاء الاصطناعي.</p>
                                </div>
                            </div>
                        </div>
                <div class="col-12 col-md-6">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-5">
                                    <h2>Log in</h2>
                                </div>
                            </div>
                        </div>
                        <form action="" method="POST">
                            <div class="row gy-3 gy-md-4 overflow-hidden">
                                <div class="col-12">
                                    <label for="username" class="form-label">User Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="userName" placeholder="User Name" required>
                                </div>
                                <div class="col-12">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter Password" required minlength="6">
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="remember_me" id="remember_me">
                                        <label class="form-check-label text-dark" for="remember_me">
                                            Keep me logged in
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn bsb-btn-xl btn-dark" type="submit">Log in</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-12">
                                <hr class="mt-5 mb-4 border-secondary-subtle">
                                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end">
                                    <a href="signup.php" class="link-secondary text-decoration-none">انشاء حساب جديد</a>
                                    <a href="forgot_pass.php" class="link-secondary text-decoration-none">نسيت الرقم السري؟</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
