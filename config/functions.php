<?php

// دي دالة بتجيب عنوان الصفحة، لو مفيش بتعرض Default
function getTitle() {
    global $pageTitle; // بنستخدم المتغير pageTitle اللي في الglobal لو موجود
    if (isset($pageTitle)) { // لو المتغير pageTitle موجود
        echo $pageTitle; // بنعرضه
    } else {
        echo "Default"; // لو مفيش قيمة للمتغير بنعرض Default
    }
}

// دي دالة بتجيب لون الـ badge اللي بيظهر جنب الحالة (Status) زي Pending أو Shipped
function getStatusBadge($status) {
    switch ($status) {
        case 'Pending': // لو الحالة هي Pending
            return 'warning'; // بنرجع لون warning
        case 'Processing': // لو الحالة هي Processing
            return 'info'; // بنرجع لون info
        case 'Shipped': // لو الحالة هي Shipped
            return 'primary'; // بنرجع لون primary
        case 'Delivered': // لو الحالة هي Delivered
            return 'success'; // بنرجع لون success
        case 'Cancelled': // لو الحالة هي Cancelled
            return 'danger'; // بنرجع لون danger
        default:
            return 'secondary'; // لو مفيش حالة منهم بنرجع secondary
    }
}

// دالة بتعد العناصر في جدول معين باستخدام شرط WHERE
function countItems($item, $table, $value) {
    global $conn; // بنستخدم الاتصال بقاعدة البيانات

    // بننفذ الاستعلام علشان نعد العناصر في الجدول حسب الشرط
    $sql = "SELECT COUNT($item) FROM $table  WHERE $item = '$value'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $count = mysqli_fetch_row($result); // بنجيب النتيجة
        return (int)$count[0]; // بنرجع العدد
    }
    return 0; // لو في مشكلة بنرجع 0
}

// دالة بتعد العناصر في الجدول بدون شروط
function countItems2($item, $table) {
    global $conn; // بنستخدم الاتصال بقاعدة البيانات

    // بننفذ الاستعلام علشان نعد العناصر في الجدول
    $sql = "SELECT COUNT($item) FROM $table";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $count = mysqli_fetch_row($result); // بنجيب النتيجة
        return (int)$count[0]; // بنرجع العدد
    }
    return 0; // لو في مشكلة بنرجع 0
}

// دالة بتتحقق لو العنصر موجود في قاعدة البيانات
function checkItem($select, $from, $value) {
    global $conn; // بنستخدم الاتصال بقاعدة البيانات

    // بننفذ الاستعلام علشان نتأكد من وجود العنصر في الجدول
    $statement = "SELECT $select FROM $from WHERE $select = '$value'";

    $result = mysqli_query($conn, $statement); // بننفذ الاستعلام
    $count = mysqli_num_rows($result); // بنحسب عدد النتائج
    if ($count > 0) {
        return true; // لو العنصر موجود بنرجع true
    } else {
        return false; // لو العنصر مش موجود بنرجع false
    }
}

// دالة لعرض التنبيهات سواء كانت نجاح أو فشل
function showAlerts($successMessage = null, $errorMessage = null, $redirectUrl = null) {
    echo "<div id='alertContainer'>"; // بنبدأ الـ div اللي هنعرض فيه التنبيه

    // لو في رسالة نجاح، نعرضها
    if ($successMessage) {
        echo "
        <div class='alert alert-success text-center w-50 container mt-5' id='successAlert' role='alert'>
            $successMessage
        </div>
        ";
    }

    // لو في رسالة خطأ، نعرضها
    if ($errorMessage) {
        echo "
        <div class='alert alert-danger text-center w-50 container mt-5' id='errorAlert' role='alert'>
            $errorMessage
        </div>
        ";
    }

    // بنخفي الرسالة بعد 2 ثانية باستخدام جافا سكربت
    echo "
    <script>
        setTimeout(function() {
            var successAlert = document.getElementById('successAlert');
            var errorAlert = document.getElementById('errorAlert');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }, 2000);
    </script>
    ";

    // لو في رابط تحويل بعد 2 ثانية نعمل redirect
    if ($redirectUrl) {
        echo "
        <script>
            setTimeout(function() {
                window.location.href = '$redirectUrl';
            }, 2000);
        </script>
        ";
    }

    echo "</div>"; 
}

// دالة لتحويل المستخدم لصفحة تانية بعد عرض التنبيه
if (!function_exists('redirect')) {
    function redirect($successMessage = null, $errorMessage = null, $redirectUrl = null) {
        echo "<div id='alertContainer'>"; // بنبدأ الـ div اللي هنعرض فيه التنبيه
    
        // لو في رسالة نجاح، نعرضها
        if ($successMessage) {
            echo "
            <div class='alert alert-success text-center w-50 container mt-3' id='successAlert' role='alert'>
                $successMessage
            </div>
            ";
        }
        
        // لو في رسالة خطأ، نعرضها
        if ($errorMessage) {
            echo "
            <div class='alert alert-danger text-center w-50 container mt-3' id='errorAlert' role='alert'>
                $errorMessage
            </div>
            ";
        }
        // لو في رابط تحويل، نعمله بعد 2 ثانية
        if($redirectUrl) {
            header("refresh;location: $redirectUrl");
        }
    }
}

// دالة للتحقق من صحة المدخلات (لازم المدخلات تكون أكتر من 3 أحرف)
function requireInputs($value) {
    $str = trim($value); // بنشيل الفراغات
    if(strlen($str) < 3) {
        return false; // لو المدخلات أقل من 3 أحرف بنرجع false
    } 
    return true; // لو المدخلات صح بنرجع true
}

// دالة للتأكد من أن القيمة مش فارغة
function checkEmpty($value) {
    if(!empty($value)) {
        return true; // لو القيمة مش فارغة بنرجع true
    }
    return false; // لو القيمة فارغة بنرجع false
}

// دالة للتحقق من الحد الأدنى للطول
function minLen($value, $min) {
    if(strlen($value) < $min) {
        return false; // لو الطول أقل من الحد الأدنى بنرجع false
    }
    return true; // لو الطول صح بنرجع true
}

// دالة للتحقق من الحد الأقصى للطول
function maxLen($value, $max) {
    if(strlen($value) > $max) {
        return false; // لو الطول أكبر من الحد الأقصى بنرجع false
    }
    return true; // لو الطول صح بنرجع true
}

// دالة لتنظيف النصوص
function SanString($value) {
    $str = trim($value); // بنشيل الفراغات
    $str = filter_var($str, FILTER_SANITIZE_STRING); // بننظف النص
    return $str;
}

// دالة لتنظيف الإيميل
function sanEmail($email) {
    $email = trim($email); // بنشيل الفراغات
    $email = filter_var($email, FILTER_SANITIZE_EMAIL); // بننظف الإيميل
    return $email;
}

// دالة للتحقق من صحة الإيميل
function validate($email) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) { // لو الإيميل مش صحيح
        return false;
    }
    return true; // لو الإيميل صحيح
}


// دالة لإضافة مستخدم أو أدمن في قاعدة البيانات
function Add($name, $userName, $email, $pass, $image, $role) {
    global $conn;
    
    if ($role == 'admin') { 
        if (!empty($name) && !empty($userName) && !empty($email) && !empty($pass)) { 
            if (minLen($name, 10) && minLen($userName, 4)) { 
                if (SanString($email) && sanEmail($email)) { 
                    if (minLen($pass, 8) && maxLen($pass, 25)) { 
                        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT); 
                        
                        if ($image['error'] == 0) {
                            $imageTmpPath = $image['tmp_name'];
                            $imageName = basename($image['name']);
                            $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
                            
                            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                            if (in_array($imageExtension, $allowedExtensions)) {
                                $imagePath = '../user/images/' . uniqid() . '.' . $imageExtension;
                                
                                if (move_uploaded_file($imageTmpPath, $imagePath)) {
                                    if (!checkItem("email", "users_data", $email)) {
                                        if (!checkItem("username", "users_data", $userName)) {
                                            $sql = "INSERT INTO users_data (full_name, username, email, password, user_Image, role) 
                                                    VALUES ('$name', '$userName', '$email', '$hashed_pass', '$imagePath', '$role')";
                                            if (mysqli_query($conn, $sql)) {
                                                showAlerts("تم التسجيل بنجاح", null, "addAdmin.php");
                                            } else {
                                                showAlerts(null, "حدث خطأ أثناء إضافة المستخدم. برجاء المحاولة لاحقًا.", "addAdmin.php");
                                            }
                                        } else {
                                            showAlerts(null, "اسم المستخدم موجود بالفعل. اختر اسم مستخدم آخر.", "addAdmin.php");
                                        }
                                    } else {
                                        showAlerts(null, "البريد الإلكتروني موجود بالفعل. اختر بريدًا إلكترونيًا آخر.", "addAdmin.php");
                                    }
                                } else {
                                    showAlerts(null, "فشل رفع الصورة. حاول مرة أخرى.", "addAdmin.php");
                                }
                            } else {
                                showAlerts(null, "نوع الصورة غير مدعوم. يرجى تحميل صورة بصيغة JPG, JPEG, PNG, أو GIF.", "addAdmin.php");
                            }
                        } else {
                            showAlerts(null, "حدث خطأ أثناء تحميل الصورة. حاول مرة أخرى.", "addAdmin.php");
                        }
                    } else {
                        showAlerts(null, "كلمة المرور يجب أن تكون بين 8 و 25 حرفًا.", "addAdmin.php");
                    }
                } else {
                    showAlerts(null, "البريد الإلكتروني غير صحيح.", "addAdmin.php");
                }
            } else {
                showAlerts(null, "اسم المستخدم يجب أن يكون أطول من 4 أحرف واسم المستخدم يجب أن يكون أطول من 10 أحرف.", "addAdmin.php");
            }
        } else {
            showAlerts(null, "يرجى ملء جميع الحقول.", "addAdmin.php");
        }
    }
}

function updateUser($userId, $user_Image, $name, $userName, $email, $pass) {
    global $conn;

    // التحقق من أن المدخلات ليست فارغة
    if (!empty($name) && !empty($userName) && !empty($email) && !empty($pass)) {

        // التحقق من طول الاسم واسم المستخدم
        if (minLen($name, 10) && minLen($userName, 4)) {

            // التحقق من صحة الإيميل
            if (SanString($email) && sanEmail($email)) {

                // التحقق من طول كلمة السر
                if (minLen($pass, 8) && maxLen($pass, 25)) {

                    // إذا تم تحميل صورة جديدة، تحقق من صحتها
                    if (!empty($user_Image)) {
                        // التحقق من نوع الصورة (يجب أن تكون صورة فقط)
                        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
                        $image_extension = pathinfo($user_Image['name'], PATHINFO_EXTENSION);

                        if (!in_array($image_extension, $allowed_extensions)) {
                            showAlerts(null, "الامتداد غير مدعوم، يرجى رفع صورة بتنسيق jpg، jpeg، png، أو gif.", "editProfile.php");
                            return;
                        }

                        // تحديد المسار الذي سيتم حفظ الصورة فيه
                        $target_dir = "../user/images/";
                        $target_file = $target_dir . basename($user_Image["name"]);

                        // نقل الصورة إلى المسار المحدد
                        if (move_uploaded_file($user_Image["tmp_name"], $target_file)) {
                            $image_path = basename($user_Image["name"]);
                        } else {
                            showAlerts(null, "فشل تحميل الصورة، حاول مرة أخرى.", "editProfile.php");
                            return;
                        }
                    }

                    // تشفير كلمة السر
                    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

                    // إعداد استعلام التحديث
                    $sql = "UPDATE users_data SET name = ?, username = ?, email = ?, password = ?, user_Image = ? WHERE id = ?";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, 'sssssi', $name, $userName, $email, $hashed_pass, $image_path, $userId);

                        // تنفيذ الاستعلام
                        if (mysqli_stmt_execute($stmt)) {
                            showAlerts("تم تحديث البيانات بنجاح", null, "editProfile.php");
                        } else {
                            showAlerts(null, "فشل تحديث البيانات، حاول مرة أخرى.", "editProfile.php");
                        }

                        // غلق الاستعلام
                        mysqli_stmt_close($stmt);
                    } else {
                        showAlerts(null, "فشل الاتصال بقاعدة البيانات، حاول مرة أخرى.", "../admin/users.php?do=Edit");
                    }
                }
            }
        }
    } else {
        showAlerts(null, "جميع الحقول مطلوبة.", "editProfile.php");
    }
}

// دالة لحذف المستخدم من قاعدة البيانات
function deleteUser($userId) {
    global $conn;

    // بننفذ استعلام الحذف
    $sql = "DELETE FROM users_data WHERE id = $userId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        showAlerts("تم حذف المستخدم بنجاح", null, "users.php");
    } else {
        showAlerts(null, "فشل في حذف المستخدم، حاول مرة أخرى.", "users.php");
    }
}

// دالة لعرض تفاصيل المستخدم
function showUserDetails($userId) {
    global $conn;

    // بننفذ استعلام لعرض بيانات المستخدم
    $sql = "SELECT * FROM users_data WHERE id = $userId";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result); // بنجيب بيانات المستخدم
        return $user; // بنرجع بيانات المستخدم
    } else {
        return null; // لو مفيش بيانات بنرجع null
    }
}

// دالة لعرض كل المستخدمين
function showAllUsers() {
    global $conn;

    // بننفذ استعلام لعرض كل المستخدمين
    $sql = "SELECT * FROM users_data";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($user = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $user['id'] . "</td>
                    <td>" . $user['name'] . "</td>
                    <td>" . $user['username'] . "</td>
                    <td>" . $user['email'] . "</td>
                    <td><a href='editUser.php?id=" . $user['id'] . "'>تعديل</a></td>
                    <td><a href='deleteUser.php?id=" . $user['id'] . "'>حذف</a></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>لا يوجد مستخدمين</td></tr>";
    }
}

// دالة لعرض تفاصيل منتج
function showProductDetails($productId) {
    global $conn;

    // بننفذ استعلام لعرض بيانات المنتج
    $sql = "SELECT * FROM products_data WHERE product_id = $productId";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result); // بنجيب بيانات المنتج
        return $product; // بنرجع بيانات المنتج
    } else {
        return null; // لو مفيش بيانات بنرجع null
    }
}

// دالة لعرض كل المنتجات
function showAllProducts() {
    global $conn;

    // بننفذ استعلام لعرض كل المنتجات
    $sql = "SELECT * FROM products_data";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($product = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $product['id'] . "</td>
                    <td>" . $product['image'] . "</td>
                    <td>" . $product['name'] . "</td>
                    <td>" . $product['description'] . "</td>
                    <td>" . $product['category_name'] . "</td>
                    <td>" . $product['position'] . "</td>
                    <td>" . $product['price'] . "</td>
                    <td>
                        <a href='editProduct.php?id=" . $product['id'] . "'>تعديل</a>
                        <a href='deleteProduct.php?id=" . $product['id'] . "'>حذف</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>لا يوجد منتجات</td></tr>";
    }
}

// دالة لإضافة منتج جديد
function addProduct($productName, $productDescription, $productPrice, $old_productPrice, $position, $rating, $image, $image2, $image3) {
    global $conn;

    // بننفذ استعلام لإضافة منتج جديد
    $sql = "INSERT INTO products_data (name, description, price, old_price, position, rating, image, image2, image3) 
            VALUES ('$productName', '$productDescription', '$productPrice', '$old_productPrice', '$position', '$rating', '$image', '$image2', '$image3' )";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        showAlerts("تم إضافة المنتج بنجاح", null, "addProduct.php");
    } else {
        showAlerts(null, "فشل في إضافة المنتج، حاول مرة أخرى.", "addProduct.php");
    }
}

// دالة update بيانات منتج
function updateProduct($productId, $productName, $productDescription, $price, $old_price, $Category, $image, $image2, $image3, $rating) {
    global $conn;

    // بننفذ استعلام لتحديث بيانات المنتج
    $sql = "UPDATE products SET name = '$productName', description = '$productDescription', price = '$price', old_price = '$old_price', category_name = '$Category' image = '', image2 = '', image3 = '' rating = '$rating' WHERE id = $productId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        showAlerts("تم تحديث المنتج بنجاح", null, "product.php?do=products");
    } else {
        showAlerts(null, "فشل تحديث المنتج، حاول مرة أخرى.", "editProduct.php");
    }
}

// دالة لحذفdelete  منتج من قاعدة البيانات
function deleteProduct($productId) {
    global $conn;

    // بننفذ استعلام الحذف
    $sql = "DELETE FROM products_data WHERE id = $productId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        showAlerts("تم حذف المنتج بنجاح", null, "product.php");
    } else {
        showAlerts(null, "فشل في حذف المنتج، حاول مرة أخرى.", "product.php");
    }
}


//-------------------------------------------------------------------------------
// Function To Send Mail To New User Who Created New Account On YAZAN ONLINE SHOP

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

//       require '../uploads/PHPMailer-master/src/Exception.php';
//       require '../uploads/PHPMailer-master/src/PHPMailer.php';
//       require '../uploads/PHPMailer-master/src/SMTP.php';



// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require 'uploads/PHPMailer-master/src/Exception.php';
// require 'uploads/PHPMailer-master/src/PHPMailer.php';
// require 'uploads/PHPMailer-master/src/SMTP.php';



// //----------------------------------------------------------------------

// // Function To Getnerate OTP Code 
// function Generate_OTP_Code($length = 6) {

//     $nums = '0123456789';
//     $otp ='';
//     for($i = 0; $i < $length; $i++) {
//         $otp .= $nums[rand(0, strlen($nums) -1 )];  
//         //بننشئ otp ومع كل مرة لأعادة تتعيين otp بيتم اضفاتة في نفس المتغير اوعى تنسي 
//         //انا استخدمت -1 عشان العد بيبدأ من 0 مش 1
//         // $otp اعادة وتعيين في نفس المتغير
//     }
//     return $otp;
// }


// //Function To sent OTP Code To user
// function send_OTP_Email($email, $userName) {
//     $otp = Generate_OTP_Code();  // انشاء رمز OTP
//     $_SESSION['otp'] = $otp;  // تخزين OTP في الجلسة
//     $_SESSION['otp_time'] = time();  // تخزين وقت توليد OTP

//     $mail = new PHPMailer(true);
//     try {
//         $mail->isSMTP();
//         $mail->Host = 'smtp.gmail.com';
//         $mail->SMTPAuth = true;
//         $mail->Username = 'eihab2342@gmail.com';  // بريدك الإلكتروني
//         $mail->Password = 'zjhx vlyh bpem gtus';  // app auth
//         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//         $mail->Port = 587;

//         $mail->setFrom('eihab2342@gmail.com', 'YAZAN ONLINE SHOP');
//         $mail->addAddress($email, $userName);

//         $mail->Subject = 'YAZAN ONLINE SHOP | رمز التحقق';
//         $mail->isHTML(true);
//         $mail->Body = '
//             أهلاً ' . $userName . ',<br><br>
//             لقد طلبت رمز التحقق لتأكيد حسابك في YAZAN ONLINE SHOP.<br><br>
//             رمز التحقق الخاص بك هو: <strong>' . $otp . '</strong><br><br>
//             يرجى إدخال هذا الرمز في الموقع لتأكيد حسابك.<br><br>
//             مع تحياتنا,<br>
//             فريق YAZAN ONLINE SHOP
//         ';

//         // إرسال البريد الإلكتروني
//         if ($mail->send()) {
//             echo 'تم إرسال رمز OTP إلى بريدك الإلكتروني!';
//         } else {
//             echo 'فشل إرسال البريد.';
//         }

//     } catch (Exception $e) {
//         echo "خطأ: {$mail->ErrorInfo}";
//     }
// }

// //function to check OTP is Correct OR no  
// function verifyOTP($inputOTP) {
//     if (isset($_SESSION['otp']) && isset($_SESSION['otp_time'])) {
//         $timeElapsed = time() - $_SESSION['otp_time']; //و ارسالة للبوزر عشان ناخد فرق التوقيت بينهم ونعرف اذا كان الكود صالج ولا انتهي  otp  بنطرح الوقت الحالي من وقت انشاء ال
//         if ($timeElapsed < 300) {  // 5 دقائق كحد أقصى
//             if ($_SESSION['otp'] == $inputOTP) {
//                 return true;  // OTP true
//             } else {
//                 return false;  // OTP خاطئ
//             }
//         } else {
//             return false;  // OTP منتهي الصلاحية
//         }
//     }
//     return false;  // OTP غير موجود
// }




// //ارسال ايميل ترحيب بتسجيل اليوزر 
// function WelcomeMessageMail($email, $userName) {
//     $mail = new PHPMailer(true);
//     try {
//         // إعدادات SMTP
//         $mail->isSMTP();
//         $mail->Host = 'smtp.gmail.com'; // خادم SMTP
//         $mail->SMTPAuth = true;
//         $mail->Username = 'eihab2342@gmail.com'; // بريدك الإلكتروني
//         $mail->Password = 'zjhx vlyh bpem gtus'; // كلمة المرور الخاصة ب app auth
//         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//         $mail->Port = 587;

//         $mail->setFrom('eihab2342@gmail.com', 'YAZAN ONLINE SHOP');
//         $mail->addAddress($email, $userName); 

//         $mail->Subject = 'YAZAN ONLINE SHOP | أهلاً بيك في يزن';
//         $mail->isHTML(true); 
//         $mail->Body = '
//             أهلاً ' . $userName . ',<br><br>
//             YAZAN ONLINE SHOP | أهلاً بيك في يزن<br><br>
//                       <div class="col-sm-4 col-lg-3 text-center text-sm-start">
//             <div class="main-logo">
//               <a href="index.php" class="text-decoration-none d-flex align-items-center">
//                 <img src="../user/images/logo3.jpg" alt="YAZAN ONLINE SHOP" style="height: 60px; width: 60px; margin-right: 10px;">
//                 <div>
//                   <h3 style="color:#26415E; margin: 0;">YAZAN | يزن</h3>
//                   <h5 style="color:#274D60; margin: 0;">ONLINE SHOP</h5>
//                 </div>
//               </a>
//             </div>
//           </div>

//             شكرًا لأنك قمت بالتسجيل معانا. إحنا مبسوطين جدًا إنك بقيت جزء من عائلتنا. في YAZAN ONLINE SHOP، بنقدّم لك مجموعة واسعة من المنتجات اللي هتناسب احتياجاتك، ومتأكدين إنك هتلاقي حاجات تحبها!<br><br>
//             ده اللي هتلاقيه معانا:<br>
//             - تجربة تسوق رائعة<br>
//             - عروض وخصومات حصرية<br>
//             - خدمة عملاء سريعة وموثوقة<br><br>
//             إبدأ استكشاف المتجر دلوقتي واستمتع بالتسوق معانا!<br><br>
//             لو عندك أي أسئلة أو محتاج مساعدة، ما تترددش تتواصل معانا. إحنا هنا علشان نساعدك!<br><br>
//             مع تحياتنا,<br>
//             فريق YAZAN ONLINE SHOP
//         ';

//         // إرسال البريد الإلكتروني
//         if ($mail->send()) {
//             echo 'تم إرسال البريد بنجاح!';
//         } else {
//             echo 'فشل إرسال البريد.';
//         }

//     } catch (Exception $e) {
//         // التعامل مع الأخطاء
//         echo "خطأ: {$mail->ErrorInfo}";
//     }
// }




















