<?php 
session_start();
require './templates/headCode.php';
require './config/connection.php';
require './config/functions.php';
require './config/mail.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    $full_name = $_POST['full_Name'];
    $userName = $_POST['userName'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
    $phone_num = $_POST['phone_number'];
    $gender = $_POST['gender'];

    $errors = [];

    // Full Name Validation
    if (empty($full_name)) {
        $errors[] = "يرجى إدخال الإسم بالكامل";
    } else {
        $full_name = filter_var(trim($full_name), FILTER_SANITIZE_STRING);
    }

    // Username Validation
    if (empty($userName)) {
        $errors[] = "يرجى إدخال اسم المستخدم";
    } else {
        $userName = filter_var(trim($userName), FILTER_SANITIZE_STRING);
    }

    // Password Validation
    if (empty($pass)) {
        $errors[] = "يرجى إدخال كلمة المرور";
    } elseif (strlen($pass) < 6) {
        $errors[] = "يجب أن تتكون كلمة المرور من 6 أحرف على الأقل";
    }

    // Phone Number Validation
    if (empty($phone_num)) {
        $errors[] = "يرجى إدخال رقم الهاتف";
    } elseif (!preg_match("/^01[0-9]{9}$/", $phone_num)) {
        $errors[] = "يرجى إدخال رقم هاتف صحيح يبدأ بـ 01 ويحتوي على 11 رقمًا";
    }

    // Gender Validation
    if (empty($gender)) {
        $errors[] = "يرجى اختيار الجنس";
    }

    // Profile Picture Upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['profile_picture']['tmp_name'];
        $file_name = $_FILES['profile_picture']['name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_ext, $allowed_exts)) {
            $new_file_name = uniqid('user_', true) . '.' . $file_ext;
            $upload_dir = 'uploads/img/';
            $destination = $upload_dir . $new_file_name;
            
            if (move_uploaded_file($file_tmp_path, $destination)) {
                $profile_picture = $new_file_name;
            } else {
                $errors[] = "حدث خطأ أثناء تحميل الصورة.";
            }
        } else {
            $errors[] = "يرجى تحميل صورة بصيغة صحيحة (jpg, jpeg, png, gif).";
        }
    } else {
        $profile_picture = 'default_profile.png'; // صورة افتراضية إذا لم يتم رفع صورة
    }

    // Display Errors
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p class='text-danger'>$error</p>";
        }
    } else {
        // Ensure sanitized input before using in SQL queries
        $userName = mysqli_real_escape_string($conn, $userName);
        $email = mysqli_real_escape_string($conn, $email);

        // Check if username or email already exists
        $query = "SELECT * FROM users_data WHERE username = '$userName' OR email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            showAlerts(null, "المستخدم موجود بالفعل!" , "signup.php");
        } else {
            // Insert new user data
            $insert_query = "INSERT INTO users_data (full_name, username, email, password, phone_num, gender, user_Image) 
                            VALUES ('$full_name', '$userName', '$email', '$hashed_pass', '$phone_num', '$gender', '$profile_picture')";
            $insert_result = mysqli_query($conn, $insert_query);

            if ($insert_result) {
                $userID = mysqli_insert_id($conn); // Get the inserted user's ID
                $_SESSION['userID'] = $userID; // Store userID in session
                $_SESSION['username'] = $userName;
                // $_SESSION['role'] = 'user'; // Store username in session

                setcookie("userID", $userID, time() + (90 * 24 * 60 * 60), "/"); // 3 months expiration
                setcookie("username", $userName, time() + (90 * 24 * 60 * 60), "/"); // 3 months expiration
                setcookie("password", $hashed_pass, time() + (90 * 24 * 60 * 60), "/"); // 3 months expiration
                Generate_OTP_Code();
                send_OTP_Email($email, $userName);
                header("location: paymob2.php");
            } else {
                showAlerts(null, "حدث خطأ ما!", "signup.php");
            }
        }
    }
}
?>

<section class="p-3 p-md-4 p-xl-5 mt-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4 text-center w-100">
                <div class="card border-light-subtle shadow-sm">
                    <div class="row g-0">
                        <div class="col-12 col-md-6 text-bg-secondary d-none d-md-flex">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <div class="col-10 col-xl-8 py-3">
                                    <div class="main-logo">
                                        <img src="./uploads/img/logo3.jpg" alt="YAZAN ONLINE SHOP" class="img-fluid rounded" style="height: 60px; width: 60px; margin-right: 10px;">
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
                                <h2>Signup</h2>
                                <form action="signup.php" method="POST" enctype="multipart/form-data">
                                    <div class="row gy-3 gy-md-4 text-start">
                                        <div class="col-12">
                                            <label for="full_Name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="full_Name" placeholder="Full Name" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="userName" class="form-label">Username <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="userName" placeholder="Username" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="phone_number" placeholder="Phone Number" required pattern="^01[0-9]{9}$" title="Phone number must start with 01 and be 11 digits">
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mb-2 pb-1">Gender: </h6>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="femaleGender" value="female" checked />
                                                <label class="form-check-label" for="femaleGender">Female</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="maleGender" value="male" />
                                                <label class="form-check-label" for="maleGender">Male</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="profile_picture" class="form-label">Profile Picture</label>
                                            <input type="file" class="form-control" name="profile_picture">
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" name="submit" class="btn btn-outline-primary">Sign Up</button>
                                        </div>
                                    </div>
                                    <!-- <div class="position-absolute bottom-0 end-0 p-3 my-3">
                                        <a href="login.php" class="text-decoration-none text-dark">لديك حساب بالفعل؟ سجل دخول</a>
                                    </div> -->
                                    <div class="row">
                                        <div class="col-12">
                                            <hr class="mt-5 mb-4 border-secondary-subtle">
                                            <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end">
                                                <a href="login.php" class="link-secondary text-decoration-none"> لديك حساب بالفعل؟ سجل دخول</a>
                                                <!-- <a href="#!" class="link-secondary text-decoration-none">نسيت الرقم السري؟</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
