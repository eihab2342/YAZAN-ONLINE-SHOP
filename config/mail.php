<?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require 'uploads/PHPMailer-master/src/Exception.php';
        require 'uploads/PHPMailer-master/src/PHPMailer.php';
        require 'uploads/PHPMailer-master/src/SMTP.php';



        //----------------------------------------------------------------------

        // Function To Getnerate OTP Code 
        function Generate_OTP_Code($length = 6) {

            $nums = '0123456789';
            $otp ='';
            for($i = 0; $i < $length; $i++) {
                $otp .= $nums[rand(0, strlen($nums) -1 )];  
                //بننشئ otp ومع كل مرة لأعادة تتعيين otp بيتم اضفاتة في نفس المتغير اوعى تنسي 
                //انا استخدمت -1 عشان العد بيبدأ من 0 مش 1
                // $otp اعادة وتعيين في نفس المتغير
            }
            return $otp;
        }

        function ResetPassword($email, $userName, $reset_link) {
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // استخدم السيرفر الصحيح
                $mail->SMTPAuth = true;
                $mail->Username = 'eihab2342@gmail.com'; // بريدك الإلكتروني
                $mail->Password = 'zjhx vlyh bpem gtus'; // كلمة مرور التطبيق
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // إعداد المرسل والمستلم
                $mail->setFrom('eihab2342@gmail.com', 'YAZAN ONLINE SHOP');
                $mail->addAddress($email, $userName, $reset_link);
                $mail->isHTML(true);
                $mail->Subject = 'إعادة تعيين كلمة المرور';
                $mail->Body    = 'لإعادة تعيين كلمة المرور الخاصة بك، يرجى النقر على الرابط التالي: <a href="' . $reset_link . '">' . $reset_link . '</a>';

                // إرسال البريد
                if ($mail->send()) {
                }
                 else {
                    showAlerts(null, "حدث خطأ اثاء إعادة تعيين كلمة السر", null);
                    // echo "حدث خطأ أثناء إرسال البريد";
                }
            }
        //Function To sent OTP Code To user
        function send_OTP_Email($email, $userName) {
            $otp = Generate_OTP_Code();  // انشاء رمز OTP
            $_SESSION['otp'] = $otp;  // تخزين OTP في الجلسة
            $_SESSION['otp_time'] = time();  // تخزين وقت توليد OTP

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'eihab2342@gmail.com';  // بريدك الإلكتروني
                $mail->Password = 'zjhx vlyh bpem gtus';  // app auth
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('eihab2342@gmail.com', 'YAZAN ONLINE SHOP');
                $mail->addAddress($email, $userName);

                $mail->Subject = 'YAZAN ONLINE SHOP | رمز التحقق';
                $mail->isHTML(true);
                $mail->Body = '
                                <!DOCTYPE html>
                                <html lang="ar" dir="rtl">
                                <head>
                                    <meta charset="UTF-8">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <style>
                                        body {
                                            font-family: Arial, sans-serif;
                                            background-color: #f9f9f9;
                                            margin: 0;
                                            padding: 0;
                                        }
                                        .email-container {
                                            max-width: 600px;
                                            margin: 20px auto;
                                            background: #ffffff;
                                            border: 1px solid #ddd;
                                            border-radius: 8px;
                                            padding: 20px;
                                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                        }
                                        .header {
                                            text-align: center;
                                            background: #007BFF;
                                            color: #ffffff;
                                            padding: 10px;
                                            border-radius: 8px 8px 0 0;
                                        }
                                        .header h1 {
                                            margin: 0;
                                            font-size: 24px;
                                        }
                                        .content {
                                            padding: 20px;
                                            line-height: 1.8;
                                            color: #333;
                                        }
                                        .content strong {
                                            color: #007BFF;
                                            font-size: 20px;
                                        }
                                        .footer {
                                            text-align: center;
                                            margin-top: 20px;
                                            font-size: 12px;
                                            color: #999;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <div class="email-container">
                                        <div class="header">
                                            <h1>YAZAN ONLINE SHOP</h1>
                                        </div>
                                        <div class="content">
                                            <p>أهلاً <strong>' . htmlspecialchars($userName) . '</strong>,</p>
                                            <p>
                                                لقد طلبت رمز التحقق لتأكيد حسابك في <strong>YAZAN ONLINE SHOP</strong>.
                                            </p>
                                            <p>
                                                رمز التحقق الخاص بك هو: <strong>' . htmlspecialchars($otp) . '</strong>
                                            </p>
                                            <p>
                                                يرجى إدخال هذا الرمز في الموقع لتأكيد حسابك.
                                            </p>
                                        </div>
                                        <div class="footer">
                                            مع تحياتنا,<br>
                                            فريق YAZAN ONLINE SHOP
                                        </div>
                                    </div>
                                </body>
                                </html>
                                ';

                // إرسال البريد الإلكتروني
                if ($mail->send()) {
                    echo 'تم إرسال رمز OTP إلى بريدك الإلكتروني!';
                } else {
                    echo 'فشل إرسال البريد.';
                }

            } catch (Exception $e) {
                echo "خطأ: {$mail->ErrorInfo}";
            }
        }


        //function to check OTP is Correct OR no  
        function verifyOTP($inputOTP) {
            if (isset($_SESSION['otp']) && isset($_SESSION['otp_time'])) {
                $timeElapsed = time() - $_SESSION['otp_time']; //و ارسالة للبوزر عشان ناخد فرق التوقيت بينهم ونعرف اذا كان الكود صالج ولا انتهي  otp  بنطرح الوقت الحالي من وقت انشاء ال
                if ($timeElapsed < 300) {  // 5 دقائق كحد أقصى
                    if ($_SESSION['otp'] == $inputOTP) {
                        return true;  // OTP true
                    } else {
                        return false;  // OTP خاطئ
                    }
                } else {
                    return false;  // OTP منتهي الصلاحية
                }
            }
            return false;  // OTP غير موجود
        }




        //ارسال ايميل ترحيب بتسجيل اليوزر 
        function WelcomeMessageMail($email, $userName) {
            $mail = new PHPMailer(true);
            try {
                // إعدادات SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // خادم SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'eihab2342@gmail.com'; // بريدك الإلكتروني
                $mail->Password = 'zjhx vlyh bpem gtus'; // كلمة المرور الخاصة ب app auth
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('eihab2342@gmail.com', 'YAZAN ONLINE SHOP');
                $mail->addAddress($email, $userName); 

                $mail->Subject = 'YAZAN ONLINE SHOP | أهلاً بيك في يزن';
                $mail->isHTML(true); 
                $mail->Body = '
                    أهلاً ' . $userName . ',<br><br>
                    YAZAN ONLINE SHOP | أهلاً بيك في يزن<br><br>
                            <div class="col-sm-4 col-lg-3 text-center text-sm-start">
                    <div class="main-logo">
                    <a href="index.php" class="text-decoration-none d-flex align-items-center">
                        <img src="../user/images/logo3.jpg" alt="YAZAN ONLINE SHOP" style="height: 60px; width: 60px; margin-right: 10px;">
                        <div>
                        <h3 style="color:#26415E; margin: 0;">YAZAN | يزن</h3>
                        <h5 style="color:#274D60; margin: 0;">ONLINE SHOP</h5>
                        </div>
                    </a>
                    </div>
                </div>

                    شكرًا لأنك قمت بالتسجيل معانا. إحنا مبسوطين جدًا إنك بقيت جزء من عائلتنا. في YAZAN ONLINE SHOP، بنقدّم لك مجموعة واسعة من المنتجات اللي هتناسب احتياجاتك، ومتأكدين إنك هتلاقي حاجات تحبها!<br><br>
                    ده اللي هتلاقيه معانا:<br>
                    - تجربة تسوق رائعة<br>
                    - عروض وخصومات حصرية<br>
                    - خدمة عملاء سريعة وموثوقة<br><br>
                    إبدأ استكشاف المتجر دلوقتي واستمتع بالتسوق معانا!<br><br>
                    لو عندك أي أسئلة أو محتاج مساعدة، ما تترددش تتواصل معانا. إحنا هنا علشان نساعدك!<br><br>
                    مع تحياتنا,<br>
                    فريق YAZAN ONLINE SHOP
                ';

                if ($mail->send()) {
                    // echo 'تم إرسال البريد بنجاح!';
                } else {
                    // echo 'فشل إرسال البريد.';
                }

            } catch (Exception $e) {
                echo "خطأ: {$mail->ErrorInfo}";
            }
        }



