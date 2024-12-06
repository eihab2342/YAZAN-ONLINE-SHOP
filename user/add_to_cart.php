<?php
// session_start();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// include('../config/connection.php'); // الاتصال بقاعدة البيانات

// header('Content-Type: application/json'); // لضمان الرد بصيغة JSON

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $product_id = $_POST['product_id'] ?? null;
//     $product_name = $_POST['product_name'] ?? null;
//     $product_price = $_POST['product_price'] ?? null;
//     $product_image = $_POST['product_image'] ?? null;
//     $quantity = $_POST['quantity'] ?? 1;

//     // التحقق من أن المستخدم مسجل الدخول
//     if (isset($_SESSION['userID']) && isset($_COOKIE['userID'])) {
//         $user_id = $_SESSION['userID'];
//         $user_id = $_COOKIE['userID'];

//         // التحقق من صحة القيم المستقبلة
//         if (!empty($product_id) && !empty($product_name) && !empty($product_price) && !empty($product_image)) {
//             // التحقق إذا كان المنتج موجوداً بالفعل
//             $check_query = "SELECT * FROM cart WHERE userID = '$user_id' AND id = '$product_id'";
//             $check_result = mysqli_query($conn, $check_query);

//             if ($check_result && mysqli_num_rows($check_result) > 0) {
//                 // تحديث الكمية إذا كان المنتج موجوداً
//                 $update_query = "UPDATE cart SET quantity = quantity + $quantity WHERE userID = '$user_id' AND id = '$product_id'";
//                 if (mysqli_query($conn, $update_query)) {
//                     echo json_encode(["status" => "success", "message" => "تم تحديث الكمية في العربة!"]);
//                 } else {
//                     echo json_encode(["status" => "error", "message" => "حدث خطأ أثناء تحديث الكمية."]);
//                 }
//             } else {
//                 // إضافة المنتج إذا لم يكن موجوداً
//                 $insert_query = "INSERT INTO cart (userID, id, product_name, product_price, quantity, product_image) 
//                                  VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$quantity', '$product_image')";
//                 if (mysqli_query($conn, $insert_query)) {
//                     echo json_encode(["status" => "success", "message" => "تم إضافة المنتج إلى العربة!"]);
//                 } else {
//                     echo json_encode(["status" => "error", "message" => "حدث خطأ أثناء إضافة المنتج."]);
//                 }
//             }
//         } else {
//             echo json_encode(["status" => "error", "message" => "بيانات المنتج غير مكتملة."]);
//         }
//     } else {
//         echo json_encode(["status" => "error", "message" => "يرجى تسجيل الدخول أولاً."]);
//     }
// } else {
//     echo json_encode(["status" => "error", "message" => "طلب غير صالح."]);
// }












































// session_start();
// include('../config/connection.php'); // تأكد من وجود الاتصال بقاعدة البيانات هنا

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $product_id = $_POST['product_id'];
//     $product_name = $_POST['product_name'];
//     $product_price = $_POST['product_price'];
//     $product_image = $_POST['product_image'];
//     $quantity = $_POST['quantity'] ? $_POST['quantity'] : 1 ;

//     if (isset($_SESSION['userID'])) {
//         $user_id = $_SESSION['userID'];
//         // $image_path = '../uploads/img/' . $product_image;
//         $check_query = "SELECT * FROM cart WHERE userID = '$user_id' AND id = '$product_id'";
//         $check_result = mysqli_query($conn, $check_query);

//         if (mysqli_num_rows($check_result) > 0) {
//             $update_query = "UPDATE cart SET quantity = quantity + $quantity WHERE userID = '$user_id' AND id = '$product_id'";
//             mysqli_query($conn, $update_query);
//         } else {
//             $insert_query = "INSERT INTO cart (userID, id, product_name, product_price, quantity, product_image) 
//                              VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$quantity', '$product_image')";
//             mysqli_query($conn, $insert_query);
//         }
//         echo "تم إضافة المنتج إلى العربة!";
//     } else {
//         echo "يرجى تسجيل الدخول أولاً.";
//     }
// }






// if (isset($_SESSION['userID']) || isset($_COOKIE['userID'])) {
//     $user_id = $_SESSION['userID'];

//     // استعلام لجلب عدد العناصر في العربة
//     $query = "SELECT SUM(quantity) AS total_items FROM cart WHERE userID = '$user_id'";
//     $result = mysqli_query($conn, $query);

//     if ($result) {
//         $row = mysqli_fetch_assoc($result);
//         echo $row['total_items'] ? $row['total_items'] : 0; // إذا لم تكن هناك عناصر، عرض 0
//     } else {
//         echo 0; // في حالة وجود خطأ
//     }
// } else {
//     echo 0; // إذا لم يكن المستخدم مسجلاً دخول
// }























session_start();
include('../config/connection.php'); // تأكد من وجود الاتصال بقاعدة البيانات هنا

// الدالة التي تحسب عدد العناصر في العربة
function getCartCount($user_id, $conn) {
    $query = "SELECT SUM(quantity) AS total_items FROM cart WHERE userID = '$user_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_items'] ? $row['total_items'] : 0; // إذا لم تكن هناك عناصر، عرض 0
    } else {
        return 0; // في حالة حدوث خطأ في الاستعلام
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    // $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $quantity = $_POST['quantity'] ? $_POST['quantity'] : 1 ;

    $result = mysqli_query($conn, "SELECT price FROM products_data WHERE id = '$product_id' ");
    $arr_product = mysqli_fetch_assoc($result);

    $product_price = $arr_product['price'];
    if (isset($_SESSION['userID'])) {
        $user_id = $_SESSION['userID'];

        // استعلام للتحقق من وجود المنتج في العربة
        $check_query = "SELECT * FROM cart WHERE userID = '$user_id' AND id = '$product_id'";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            // إذا كان المنتج موجودًا، يتم تحديث الكمية
            $update_query = "UPDATE cart SET quantity = quantity + $quantity WHERE userID = '$user_id' AND id = '$product_id'";
            mysqli_query($conn, $update_query);
        } else {
            // إذا لم يكن المنتج موجودًا، يتم إدخاله
            $insert_query = "INSERT INTO cart (userID, id, product_name, product_price, quantity, product_image) 
                             VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$quantity', '$product_image')";
            mysqli_query($conn, $insert_query);
        }

        // حساب عدد العناصر في العربة بعد إضافة أو تحديث المنتج
        $total_items = getCartCount($user_id, $conn);

        echo json_encode(['message' => 'تم إضافة المنتج إلى العربة!', 'total_items' => $total_items]);
    } else {
        echo json_encode(['message' => 'يرجى تسجيل الدخول أولاً.', 'total_items' => 0]);
    }
} else {
    // إذا كان الطلب GET لعرض عدد العناصر في العربة (في حالة إعادة تحميل الصفحة)
    if (isset($_SESSION['userID'])) {
        $user_id = $_SESSION['userID'];
        $total_items = getCartCount($user_id, $conn);
        echo json_encode(['total_items' => $total_items]);
    } else {
        echo json_encode(['total_items' => 0]);
    }
}






 ?>
