<?php
session_start();
require 'config/connection.php';
require 'config/functions.php';
// استلام معرف المستخدم من الرابط
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify_code'])) {
    $entered_code = implode("", $_POST['code']); // جمع الكود المدخل

    // هنا تتحقق من الكود في قاعدة البيانات باستخدام معرف المستخدم
    // مثال: التحقق من الكود المخزن في قاعدة البيانات
    // $stored_code = ...; // جلب الكود من قاعدة البيانات بناءً على user_id
    // if ($entered_code == $stored_code) {
    // الكود صحيح
    showAlerts("تم إنشاء حسابك بنجاح", null, "user/index.php");    // } else {
    // الكود خاطئ
    // echo "الكود المدخل غير صحيح!";
    // }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التحقق من الكود</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 350px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        .container h2 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #333;
        }

        .container p {
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }

        .code-inputs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .code-inputs input {
            width: 40px;
            height: 40px;
            font-size: 18px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .resend {
            font-size: 12px;
            color: #888;
            margin-bottom: 15px;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
        }

        .buttons button {
            width: 48%;
            padding: 10px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .buttons .confirm {
            background-color: #007bff;
            color: #fff;
        }

        .buttons .cancel {
            background-color: #f5f5f5;
            color: #555;
        }

        .countdown {
            font-size: 18px;
            margin-top: 10px;
        }

        .message {
            margin-top: 20px;
            font-size: 16px;
            color: #d9534f;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>كود مكون من 6 أرقام</h2>
        <p>الرجاء إدخال الرمز الذي أُرسلناه إلى بريدك الإلكتروني</p>

        <form method="POST" action="">
            <div class="code-inputs">
                <input type="text" maxlength="1" name="code[]" required>
                <input type="text" maxlength="1" name="code[]" required>
                <input type="text" maxlength="1" name="code[]" required>
                <input type="text" maxlength="1" name="code[]" required>
                <input type="text" maxlength="1" name="code[]" required>
                <input type="text" maxlength="1" name="code[]" required>
            </div>

            <p class="resend">أعد إرسال الرمز بعد <span id="countdown">1:59</span></p>

            <div class="buttons">
                <button type="button" class="cancel">إلغاء</button>
                <button type="submit" class="confirm" name="verify_code">تأكيد</button>
            </div>
        </form>
    </div>

    <script>
        let countdown = 120; // 2 دقائق = 120 ثانية
        const countdownElement = document.getElementById('countdown');

        function updateCountdown() {
            let minutes = Math.floor(countdown / 60);
            let seconds = countdown % 60;
            countdownElement.textContent = `${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
            countdown--;
            if (countdown < 0) {
                clearInterval(countdownInterval);
                countdownElement.textContent = "الوقت انتهى!";
            }
        }

        const countdownInterval = setInterval(updateCountdown, 1000);
    </script>
</body>

</html>