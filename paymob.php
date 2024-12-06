<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كود التحقق</title>
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
            width: 300px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        .container h2 {
            font-size: 18px;
            margin-bottom: 10px;
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
    </style>
</head>

<body>
    <div class="container">
        <h2>كود مكون من 6 أرقام</h2>
        <p>الرجاء إدخال الرمز الذي أُرسلناه إلى +2**2032</p>
        <div class="code-inputs">
            <input type="text" maxlength="1">
            <input type="text" maxlength="1">
            <input type="text" maxlength="1">
            <input type="text" maxlength="1">
            <input type="text" maxlength="1">
            <input type="text" maxlength="1">
        </div>
        <p class="resend">أعد إرسال الرمز بعد 1:59</p>
        <div class="buttons">
            <button class="cancel">إلغاء</button>
            <button class="confirm">تأكيد</button>
        </div>
    </div>
</body>

</html>