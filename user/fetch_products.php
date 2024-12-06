<?php
/*
    ** In this File We get 4 products from 4 deffrient category
        to display in the right cart of the main three cads at the first of our website
        Note: js detrmins num of imgs to display ==> limit

    ** We handle 4 images to js then js display them.
    DISTINCT ==> to ensure that item does not repeat
    انا جبت اسم الكاتيجوري من جدول المنتجات عشان اضمن ان الكاتيجوري جواه منتجات لانة وارد يكون في كاتيجوري فاضي 
*/

require '../config/connection.php';
$limit  = intval($_GET['limit'] ?? 4);
$data = [];

$categories = mysqli_query($conn, "SELECT DISTINCT category_name FROM products_data LIMIT $limit");

if ($categories && mysqli_num_rows($categories) > 0) {
    while ($category = mysqli_fetch_assoc($categories)) {
        $categry_name = $category['category_name'];
        
        $products = mysqli_query($conn, "SELECT category_name, image FROM products_data WHERE category_name = '$categry_name' ORDER BY RAND() LIMIT 1");
        
        if ($products && mysqli_num_rows($products) > 0) {
            $product = mysqli_fetch_assoc($products);

            $categories_query = mysqli_query($conn , "SELECT category_id FROM categories_data WHERE category_name = '$categry_name'");
            $category_data = mysqli_fetch_assoc($categories_query);
            $category_id = $category_data['category_id'];

            $data[] = [
                'category_id' => $category_id,
                'category_name' => $product['category_name'],
                'product_image' => $product['image']
            ];
        }
    }
}

header('Content-Type: application/json');
echo json_encode($data);
?>
