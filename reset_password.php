<?php  
    session_start();
    require 'config/connection.php';
    require 'config/functions.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $new_pass = $_POST['new_password'];
        $confirm_pass = $_POST['confirm_password'];
        $token = $_GET['token'];
        // Check if new password === confirm password

        if($new_pass !== $confirm_pass) {
            showAlerts(null, "كلمة المرور وتأكيد كلمة المرور غير متطابقين.", null);
        } else {

            if(isset($_SESSION['token'])) { 
                $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
                $email = $_SESSION['email'];

                $result = mysqli_query($conn, "UPDATE users_data SET password='$hashed_pass' WHERE email = '$email' ");
                if($result) {
                    showAlerts("تم تحديث كلمة المرور الخاصة بك..برجاء إعادة تسجيل الدخول", null, "login.php");
                } else {
                    showAlerts(null, "حدث خطأ اثنلء تحديث كلمة السر", null);
                }
            } else {
                showAlerts(null, "الرابط غير صالح او قد انتهت مدة صلاحيتة", null);
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
    <div class="container d-flex flex-column justify-content-center align-items-center ">
        <!-- Logo and site name -->
        <div class="d-flex align-items-center justify-content-center my-5">
            <img src="user/images/logo3.jpg" alt="YAZAN ONLINE SHOP" class="img-fluid" style="height: 60px; width: 60px; margin-right: 10px;">
            <div class="text-center">
                <h1 class="text-primary m-0">YAZAN</h1>
                <h5 class="text-secondary m-0">ONLINE SHOP</h5>
            </div>
        </div>

        <!-- Form for resetting password -->
        <h2 class="text-center mt-4">إنشاء كلمة مرور جديدة</h2>
        <form action="" method="post" class="w-100" style="max-width: 380px;">
            <div class="mb-3">
                <label for="new_password" class="form-label">كلمة المرور الجديدة</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">تأكيد كلمة المرور</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">تغيير كلمة المرور</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


    




