<?php  
session_start();
require 'config/connection.php';
require 'config/functions.php';
require 'config/mail.php';

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require 'uploads/PHPMailer-master/src/Exception.php';
// require 'uploads/PHPMailer-master/src/PHPMailer.php';
// require 'uploads/PHPMailer-master/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    if (empty($email)) {
        echo "يرجى إدخال البريد الإلكتروني";
    } else {
        // تحقق من صحة البريد الإلكتروني
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "الإيميل غير صالح";
        } else {
            // تحقق من وجود البريد الإلكتروني في قاعدة البيانات باستخدام Prepared Statements
            // $sql = "SELECT * FROM users_data WHERE email = '$email' ";
            // $stmt = mysqli_prepare($conn, $sql);
            // mysqli_stmt_bind_param($stmt, 's', $email);
            // mysqli_stmt_execute($stmt);
            // $result = mysqli_stmt_get_result($stmt);
            $result = mysqli_query($conn, "SELECT * FROM users_data WHERE email = '$email' ");
            // $user = mysqli_fetch_assoc($query);
            if ($result && mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);

                $token = bin2hex(random_bytes(50)); // إنشاء رمز عشوائي
                $expire_time = date("U") + 1800; // مدة 30 دقيقة

                $_SESSION['token'] = $token;
                $_SESSION['expire_time'] = $expire_time;
                $_SESSION['email'] = $email;

                // رابط إعادة تعيين كلمة المرور
                $reset_link = "https://5a83-197-135-3-147.ngrok-free.app/foodmart/reset_password.php?token=" . $token;

                // إرسال البريد الإلكتروني باستخدام PHPMailer
                ResetPassword($email, $username, $reset_link);
                    // showAlerts("تم ارسال رابط اعادة تعينن الرقم السري ", null, null);
                // } else {
                //     showAlerts(null, "حدث خطأ", null);
                // }
            } else {
                showAlerts(null,"البريد الإلكتروني غير مسجل لدينا", null);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعادة تعيين كلمة المرور</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-5">إعادة تعيين كلمة المرور</h2>
        <form action="" method="post">
            <div class="mb-3 w-50 container">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">إرسال رابط إعادة تعيين كلمة المرور</button>
        </form>
    </div>
</body>
</html>
