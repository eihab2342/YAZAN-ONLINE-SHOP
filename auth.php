<?php
session_start();
require './assets/header.php';
require './config/connection.php';
require './config/functions.php';
require './config/mail.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

$otp = $_SESSION['otp'] ?? null; // لو مفيش OTP يبقى بيساوي null

// إرسال رمز OTP جديد عندما يضغط المستخدم على زر إعادة الإرسال
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['otp'])) {
        $userOtp = $_POST['otp'];
        if (verifyOTP($userOtp)) {
            showAlerts("تم انشاء حسابكم بنجاح", null, "./user/index.php");
            ?>
<?php
        } else {
            showAlerts(null, "رمز OTP غير صحيح", null);
        }
    }

    // إعادة إرسال OTP
    if (isset($_POST['resend_otp'])) {
        $email = "user@example.com";  // ضع هنا البريد الإلكتروني للمستخدم
        $otp = rand(100000, 999999); // توليد OTP عشوائي
        $_SESSION['otp'] = $otp; // تخزين OTP في الجلسة
        send_OTP_Email($email, $otp); // إرسال OTP عبر البريد الإلكتروني
        showAlerts("تم إرسال رمز OTP جديد إلى بريدك الإلكتروني", null, "auth.php");
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدخال رمز OTP</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 400px;
            margin-top: 100px;
        }
        .form-title {
            font-size: 24px;
            font-weight: bold;
            color: #495057;
        }
        .btn-submit {
            background-color: #007bff;
            color: #fff;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .error-msg {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h3>إلى الإيميل المسجل، تم إرسال رمز OTP</h3>
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="form-title text-center mb-4">يرجى إدخال رمز OTP</h2>
            <form action="auth.php" method="POST">
                <div class="mb-3">
                    <input type="text" name="otp" class="form-control" placeholder="أدخل رمز OTP" required>
                </div>
                <button type="submit" class="btn btn-submit w-75">إرسال</button>
            </form>

            <!-- زر إعادة إرسال رمز OTP -->
            <form action="auth.php" method="POST">
                <button type="submit" name="resend_otp" class="btn btn-link w-75" style="color: #007BFF; text-decoration: none; font-weight: bold;">
                    إعادة إرسال رمز OTP
                </button>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
