<?php
session_start();
require '../assets/header.php';
require '../config/connection.php';
require '../config/functions.php';
?>
<title><?php $pageTitle = 'Admin | Products';
        echo getTitle($pageTitle); ?></title>

<div class="container-fluid position-relative d-flex p-0" style="background-color: whitesmoke;">
    <!-- Spinner Start -->
    <!-- <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div> -->
    <!-- Spinner End -->
    <!-- <div class="content" style="background-color: whitesmoke;"> -->

    <!-- Sidebar Start -->
    <?php require_once '../assets/sideBar.php'; ?>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <?php require_once '../assets/navBar.php'; ?>
        <!-- Navbar End -->

        <style>
        </style>
        </head>

        <!-- <body style="background-color: whitesmoke;"> -->
        <div class="col-12 col-lg-4 d-lg-flex justify-content-center align-items-center mt-3 mt-sm-4 mt-lg-0">
            <form class="w-100" action="../user/search.php" method="GET" id="search-form" style="background-color: whitesmoke;">
                <input type="text" id="search-input" class="form-control me-2" name="query" placeholder="ابحث عن المنتجات..." aria-label="Search" style="background-color: white;">
            </form>
            <div id="search-results" class="dropdown-menu" style="width: 100%;"></div> <!-- لعرض نتائج البحث -->
        </div>
        <script>
            $(document).ready(function() {
                $('#search-input').keyup(function() {
                    var query = $(this).val();

                    if (query.length > 1) { // إذا كان النص المدخل أطول من حرفين
                        $.ajax({
                            url: '../user/search.php', // الصفحة التي ستستقبل الاستعلامات
                            method: 'GET',
                            data: {
                                query: query
                            }, // إرسال النص المدخل في المتغير query
                            success: function(response) {
                                var results = JSON.parse(response); // تحويل الاستجابة إلى JSON
                                var resultsHtml = '';

                                // التحقق إذا كانت النتائج تحتوي على منتجات
                                if (results.length > 0) {
                                    resultsHtml = '<ul class="list-unstyled">';

                                    // عرض كل منتج في قائمة منسدلة (dropdown)
                                    $.each(results, function(index, product) {
                                        resultsHtml += '<li><a href="product_details.php?product_id=' + product.id + '" class="dropdown-item">' + product.name + '</a></li>';
                                    });
                                    resultsHtml += '</ul>';
                                } else {
                                    resultsHtml = '<p class="dropdown-item">لا توجد نتائج</p>';
                                }

                                // عرض النتائج في الـ div المخصص
                                $('#search-results').html(resultsHtml).addClass('show'); // إضافة class 'show' لعرض الـ dropdown
                            }
                        });
                    } else {
                        $('#search-results').html('').removeClass('show'); // إخفاء النتائج إذا كان النص المدخل أقل من 3 حروف
                    }
                });

                // إخفاء الـ dropdown عند النقر خارج الحقل
                $(document).click(function(e) {
                    if (!$(e.target).closest('#search-input').length) {
                        $('#search-results').removeClass('show');
                    }
                });
            });
        </script>
        <!-- End JQ Code To Serach  -->




        <?php
        $do = isset($_GET['do']) ? $_GET['do'] : 'products';
        // عرض المنتجات
        if ($do == 'products') { ?>



            <div class="m-2">
                <a href="?do=Add" class="btn btn-success m-1 float-end">Add New Product</a>
                <h2 class=" text-dark mt-1">Manage Products</h2>
            </div>
            <div class="container mt-4 table-responsive" style="background-color: whitesmoke;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Old Price</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM products_data";
                        $result = mysqli_query($conn, $query);
                        while ($product = mysqli_fetch_assoc($result)) { ?>
                            <tr class="text-dark">
                                <td>
                                    <?php if (!empty($product['image']) && file_exists("../uploads/img/" . $product['image'])): ?>
                                        <img src="../uploads/img/<?php echo $product['image']; ?>" width="50" height="50" alt="Product Image">
                                    <?php else: ?>
                                        <p>No image</p>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $product['name']; ?></td>
                                <td><?php echo $product['price']; ?></td>
                                <td><?php echo $product['old_price']; ?></td>
                                <td><?php echo $product['category_name']; ?></td>
                                <td>
                                    <a href="admin_product_details.php?product_id=<?php echo $product['id'] ?>" class="btn btn-success btn-sm">عرض التفاصيل </a>
                                    <a href="?do=Edit&product_id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="?do=ConfirmDelete&product_id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } elseif ($do == 'ConfirmDelete') {

            if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
                $product_id = $_GET['product_id'];

                if (isset($_POST['confirm_delete'])) {

                    $sql = "DELETE FROM products_data WHERE id = $product_id";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        showAlerts("تم حذف المنتج بنجاح", null, "product.php");
                        // echo "Product deleted successfully.";
                        // header("Location: ?do=products"); // إعادة التوجيه إلى صفحة المنتجات
                        exit;
                    } else {
                        echo "Error deleting the product: " . mysqli_error($conn);
                    }
                } else {

            ?>
                    <div class="container mt-4">
                        <h3>Are you sure you want to delete this product?</h3>
                        <form method="POST" action="?do=ConfirmDelete&product_id=<?php echo $product_id; ?>">
                            <button type="submit" name="confirm_delete" class="btn btn-danger">Yes, Delete</button>
                            <a href="?do=products" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo "Invalid product ID.";
            }
        }

        if ($do == 'Add') { ?>
            <div class="container mt-4 text-dark bg-white">
                <h2 class="text-dark">Add New Product</h2>
                <form action="?do=Insert" method="POST" enctype="multipart/form-data">
                    <!-- الحقول الأخرى -->
                    <div class="mb-3 container">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control bg-white text-secondary" id="name" name="name" required>
                    </div>
                    <div class="mb-3 container">
                        <label for="keywords" class="form-label">Product Keywords</label>
                        <input type="text" class="form-control bg-white text-secondary" id="keywords" name="keywords" required>
                    </div>
                    <div class="mb-3 container">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control bg-white text-secondary" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3 container">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control bg-white text-secondary" id="price" name="price" required>
                    </div>
                    <div class="mb-3 container">
                        <label for="old_price" class="form-label">Old Price</label>
                        <input type="number" class="form-control bg-white text-secondary" id="old_price" name="old_price" required>
                    </div>
                    <!-- اختيار الفئة -->
                    <div class="mb-3 container">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-control bg-white text-secondary" id="category" name="category" required>
                            <option value="">اختر الفئة</option>
                            <?php
                            $query = "SELECT * FROM categories_data";
                            $result = mysqli_query($conn, $query);
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $category_name = $row['category_name'];
                                    echo "<option value='$category_name'>$category_name</option>";
                                }
                            } else {
                                echo "<option disabled>لا توجد فئات</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- ألوان المنتج -->
                    <div id="colorField" style="display: none;">
                        <label for="color" class="form-label">Choose Colors</label>
                        <div class="d-flex flex-wrap">
                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="color_black" name="colors[]" value="black">
                                <label class="form-check-label" for="color_black">أسود</label>
                            </div>
                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="color_black" name="colors[]" value="white">
                                <label class="form-check-label" for="color_black">ابيض</label>
                            </div>
                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="color_black" name="colors[]" value="move">
                                <label class="form-check-label" for="color_black">موف</label>
                            </div>
                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="color_black" name="colors[]" value="baby_blue">
                                <label class="form-check-label" for="color_black">بيبي بلو</label>
                            </div>
                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="color_black" name="colors[]" value="gold">
                                <label class="form-check-label" for="color_black">دهبي</label>
                            </div>
                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="color_black" name="colors[]" value="yellow">
                                <label class="form-check-label" for="color_black">اصفر</label>
                            </div>
                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="color_black" name="colors[]" value="orange">
                                <label class="form-check-label" for="color_black">برتقالي</label>
                            </div>

                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="color_white" name="colors[]" value="lead">
                                <label class="form-check-label" for="color_white">رصاصي</label>
                            </div>
                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="color_black" name="colors[]" value="oil">
                                <label class="form-check-label" for="color_black">زيتي</label>
                            </div>
                            < <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="color_black" name="colors[]" value="navy blue">
                                <label class="form-check-label" for="color_black">كحلي</label>
                        </div>
                        <div class="form-check m-3">
                            <input class="form-check-input" type="checkbox" id="color_black" name="colors[]" value="blue">
                            <label class="form-check-label" for="color_black">ازرق</label>
                        </div>
                        <div class="form-check m-3">
                            <input class="form-check-input" type="checkbox" id="color_black" name="colors[]" value="green">
                            <label class="form-check-label" for="color_black">اخضر</label>
                        </div>
                        <!-- باقي الألوان -->
                    </div>
                    <!-- مقاسات المنتج -->
                    <div id="sizeField" style="display: none;">
                        <label for="size" class="form-label">Choose Sizes</label>
                        <div class="d-flex flex-wrap">
                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="size_s" name="sizes[]" value="S">
                                <label class="form-check-label" for="size_s">S</label>
                            </div>
                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="size_m" name="sizes[]" value="M">
                                <label class="form-check-label" for="size_m">M</label>
                            </div>
                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="size_l" name="sizes[]" value="L">
                                <label class="form-check-label" for="size_l">L</label>
                            </div>
                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="size_xl" name="sizes[]" value="XL">
                                <label class="form-check-label" for="size_xl">XL</label>
                            </div>
                            <div class="form-check m-3">
                                <input class="form-check-input" type="checkbox" id="size_xxl" name="sizes[]" value="XXL">
                                <label class="form-check-label" for="size_xxl">XXL</label>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="mb-3 container">
                <label for="image1" class="form-label">Image 1</label>
                <input type="file" class="form-control bg-white text-secondary" id="image1" name="image1" required>
            </div>
            <div class="mb-3 container">
                <label for="image2" class="form-label">Image 2</label>
                <input type="file" class="form-control bg-white text-secondary" id="image2" name="image2">
            </div>
            <div class="mb-3 container">
                <label for="image3" class="form-label">Image 3</label>
                <input type="file" class="form-control bg-white text-secondary" id="image3" name="image3">
            </div>

            <!-- سكريبت لإظهار وإخفاء الحقول بناءً على الفئة -->
            <script>
                document.getElementById('category').addEventListener('change', function() {
                    var category = this.value;
                    var colorField = document.getElementById('colorField');
                    var sizeField = document.getElementById('sizeField');

                    if (category === 'ملابس رجالى' || category === 'ملابس حريمى') {
                        colorField.style.display = 'block';
                        sizeField.style.display = 'block';
                    } else if (category === 'هواتف') {
                        colorField.style.display = 'block';
                        sizeField.style.display = 'none';
                    } else {
                        colorField.style.display = 'none';
                        sizeField.style.display = 'none';
                    }
                });
            </script>

            <div class="d-flex justify-content-center mb-3">
                <button type="submit" class="btn btn-success m-3">Add Product</button>
            </div>
            </form>
    </div>

    <?php
        } elseif ($do == 'Insert') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // الحصول على البيانات المدخلة من الفورم
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $keywords = mysqli_real_escape_string($conn, $_POST['keywords']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $price = mysqli_real_escape_string($conn, $_POST['price']);
                $old_price = mysqli_real_escape_string($conn, $_POST['old_price']);
                $category_name = mysqli_real_escape_string($conn, $_POST['category']);
                $position = isset($_POST['position']) ? mysqli_real_escape_string($conn, $_POST['position']) : NULL;
                $discount = isset($_POST['discount']) ? mysqli_real_escape_string($conn, $_POST['discount']) : NULL;

                // الحصول على اللون والمقاس
                $colors = isset($_POST['colors']) ? $_POST['colors'] : [];
                $sizes = isset($_POST['sizes']) ? $_POST['sizes'] : [];

                // التعامل مع الصور
                $upload_path = "../uploads/img/";
                $images = [];
                $image_errors = false;

                for ($i = 1; $i <= 3; $i++) {
                    $image_name = $_FILES["image$i"]['name'];
                    $image_tmp = $_FILES["image$i"]['tmp_name'];

                    if (!empty($image_name)) {
                        $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                        if (!empty($image_tmp) && file_exists($image_tmp)) {
                            $unique_image_name = uniqid("img_") . ".$image_extension";
                            move_uploaded_file($image_tmp, $upload_path . $unique_image_name);
                            $images[] = $unique_image_name;
                        } else {
                            showAlerts("Error in image $i upload.", null, "?do=Add");
                            $image_errors = true;
                            break;
                        }
                    } else {
                        $images[] = NULL;
                    }
                }

                if (!$image_errors) {
                    // إدخال البيانات المنتج في جدول products_data
                    $query = "INSERT INTO products_data 
                (name, keywords, description, price, old_price, category_name, image, image2, image3)
                VALUES ('$name', '$keywords', '$description', '$price', '$old_price', '$category_name', 
                '{$images[0]}', '{$images[1]}', '{$images[2]}')";

                    if (mysqli_query($conn, $query)) {
                        $product_id = mysqli_insert_id($conn);

                        // إدخال الألوان في جدول product_colors
                        if (!empty($colors)) {
                            foreach ($colors as $color) {
                                $query_color = "INSERT INTO product_colors (product_id, color) VALUES ('$product_id', '$color')";
                                mysqli_query($conn, $query_color);
                            }
                        }

                        // إدخال المقاسات في جدول product_sizes
                        if (!empty($sizes)) {
                            foreach ($sizes as $size) {
                                $query_size = "INSERT INTO product_sizes (product_id, size) VALUES ('$product_id', '$size')";
                                mysqli_query($conn, $query_size);
                            }
                        }

                        showAlerts("Added Successfully", null, "?do=products");
                    } else {
                        showAlerts("Error: " . mysqli_error($conn), null, "?do=Add");
                    }
                }
            } else {
                showAlerts("Error: Please make sure the image is smaller than 350x350 pixels.", null, "?do=Add");
            }
        } elseif ($do == 'Edit') {
            // Edit Product
            $product_id = $_GET['product_id'];
            $query = "SELECT * FROM products_data WHERE id = '$product_id'";
            $result = mysqli_query($conn, $query);
            $product = mysqli_fetch_assoc($result);

            if ($product) {
                $category_id = $product['category_id']; // Assuming category_id exists
    ?>
        <div class="container mt-4">
            <h2 class="text-dark">Edit Product</h2>
            <form action="?do=Update&product_id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
                <!-- Fields for Name, Keywords, Description, Price, etc. -->
                <div class="mb-3">
                    <label for="name" class="form-label text-dark fs-5">Product Name</label>
                    <input type="text" class="form-control bg-white text-secondary" id="name" name="name" value="<?php echo $product['name']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="keywords" class="form-label text-dark fs-5">Product Keywords</label>
                    <input type="text" class="form-control bg-white text-secondary" id="keywords" name="keywords" value="<?php echo $product['keywords']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label text-dark fs-5">Description</label>
                    <textarea class="form-control bg-white text-secondary" id="description" name="description" required><?php echo $product['description']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label text-dark fs-5">Price</label>
                    <input type="number" class="form-control bg-white text-secondary" id="price" name="price" value="<?php echo $product['price']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="old_price" class="form-label text-dark">Old Price</label>
                    <input type="number" class="form-control bg-white text-secondary" id="old_price" name="old_price" value="<?php echo $product['old_price']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label text-dark fs-5">Position</label>
                    <select class="form-select bg-white text-secondary" id="position" name="position" required>
                        <option value="<?php echo $product['position']; ?>"><?php echo $product['position']; ?></option>
                        <option value="">اختر مكان عرض المنتج</option>
                        <option value="best_selling">أكثر المنتجات مبيعًا</option>
                        <option value="new_arrivals">منتجات وصلت حديثًا</option>
                        <option value="trending">منتجات تريند</option>
                        <option value="food">أطعمة ومأكولات</option>
                    </select>
                </div>

                <!-- Color -->
                <!-- <div class="mb-3">
                                    <label for="color" class="form-label text-dark fs-5">Color</label>
                                    <input type="text" class="form-control bg-white text-secondary" id="color" name="color" value="<?php echo isset($product['color']) ? $product['color'] : ''; ?>" placeholder="Enter product color if applicable">
                                </div>
                        <div class="mb-3">
                            <label for="category" class="form-label text-dark fs-5">Category</label>
                            <select class="form-select bg-white text-secondary" id="category" name="category" required>
                                <option value="<?php echo $product['category_name']; ?>"><?php echo $product['category_name']; ?></option>
                                <?php
                                $query = "SELECT * FROM categories_data";
                                $result = mysqli_query($conn, $query);
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['category_name'] . "'>" . $row['category_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="image1" class="form-label text-dark fs-5">Image 1</label>
                            <input type="file" class="form-control bg-white text-secondary" id="image1" name="image1">
                            <?php if (!empty($product['image']) && file_exists("../uploads/img/" . $product['image'])): ?>
                                <div>
                                    <p class="text-dark">Current Image: <img src="../uploads/img/<?php echo $product['image']; ?>" width="100" height="100" alt="Current Image"></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- </div> -->
                <!-- Check if category_id matches 31, 32, or 27 -->
                <?php if (in_array($product['category_name'], ['ملابس رجالى', 'ملابس حريمى'])): ?>
                    <div class="mb-3">
                        <label for="size" class="form-label text-dark fs-5">Size</label>
                        <input type="text" class="form-control bg-white text-secondary" id="size" name="size" value="<?php echo $product['size']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label text-dark fs-5">Color</label>
                        <input type="text" class="form-control bg-white text-secondary" id="color" name="color" value="<?php echo $product['color']; ?>">
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-warning m-3">Update Product</button>
                </div>
            </form>
        </div>
<?php
            }
            // } else {
            //     echo "Product Not Found";
            // }
        } elseif ($do == 'Update') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_POST['name'];
                $keywords = $_POST['keywords'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $old_price = $_POST['old_price'];
                $category_name = $_POST['category'];
                $size = isset($_POST['size']) ? $_POST['size'] : null;
                $color = isset($_POST['color']) ? $_POST['color'] : null;

                $image1 = $_FILES['image1']['name'];
                if (!empty($image1)) {
                    $image1_tmp = $_FILES['image1']['tmp_name'];
                    move_uploaded_file($image1_tmp, "../uploads/img/$image1");
                    $image1_sql = ", image = '$image1'";
                } else {
                    $image1_sql = "";
                }

                $query = "UPDATE products_data SET 
                    name = '$name',
                    keywords = '$keywords',
                    description = '$description', 
                    price = '$price', 
                    old_price = '$old_price', 
                    category_name = '$category_name',
                    size = '$size',
                    color = '$color'
                    $image1_sql 
                    WHERE id = '{$_GET['product_id']}'";
                mysqli_query($conn, $query);
                showAlerts("Updated Successfully", null, "?do=products");
            }
        }
?>
</div>
</div>


<?php require_once '../assets/footer.php'; ?>
</div>


<?php require_once '../assets/footer.php'; ?>