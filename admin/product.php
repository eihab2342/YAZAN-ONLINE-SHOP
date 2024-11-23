<?php
session_start();
require '../assets/header.php';
require '../config/connection.php';
require '../config/functions.php';
?>
<title><?php $pageTitle = 'Admin | Products'; echo getTitle($pageTitle); ?></title>

<?php // if (isset($_SESSION['userName']) && isset($_SESSION['userID'])) { ?>

<div class="container-fluid position-relative d-flex p-0">
    <!-- Spinner Start -->
    <!-- <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div> -->
    <!-- Spinner End -->

    <!-- Sidebar Start -->
    <?php require_once '../assets/sideBar.php'; ?>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <?php require_once '../assets/navBar.php'; ?>
        <!-- Navbar End -->

        <?php 
        $do = isset($_GET['do']) ? $_GET['do'] : 'products';

        // Display Products
        if ($do == 'products') { ?>
            <div class="container mt-4">
                <a href="?do=Add" class="btn btn-success m-1 float-end">Add New Product</a>
                <h2>Manage Products</h2>
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
                            <tr>
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
                                    <a href="?do=Edit&product_id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="?do=Delete&product_id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php }


        if ($do == 'Add') { ?>
            <div class="container mt-4">
                <h2>Add New Product</h2>
                <form action="?do=Insert" method="POST" enctype="multipart/form-data">
                    <div class="mb-3 container">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control bg-secondary" id="name" name="name" required>
                    </div>
                    <div class="mb-3 container">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control bg-secondary" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3 container">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control bg-secondary" id="price" name="price" required>
                    </div>
                    <div class="mb-3 container">
                        <label for="old_price" class="form-label">Old Price</label>
                        <input type="number" class="form-control bg-secondary" id="old_price" name="old_price" required>
                    </div>
                    <div class="mb-3 container">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select bg-secondary" id="category" name="category" required>
                            <option value="">اختر الفئة</option>
                            <?php
                            $query = "SELECT * FROM categories_data";
                            $result = mysqli_query($conn, $query);
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $category_id = $row['category_id'];
                                    $category_name = $row['category_name'];
                                    echo "<option value='$category_name'>$category_name</option>";
                                }
                            } else {
                                echo "<option disabled>لا توجد فئات</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 container">
                        <label for="image1" class="form-label">Image 1</label>
                        <input type="file" class="form-control bg-secondary" id="image1" name="image1" required>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <button type="submit" class="btn btn-success m-3">Add Product</button>
                    </div>
                </form>
            </div>
        <?php
        } elseif ($do == 'Insert') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $price = mysqli_real_escape_string($conn, $_POST['price']);
                $old_price = mysqli_real_escape_string($conn, $_POST['old_price']);
                $category_name = mysqli_real_escape_string($conn, $_POST['category']);

                // التحقق من صحة الصورة
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                $image1 = $_FILES['image1']['name'];
                $image1_tmp = $_FILES['image1']['tmp_name'];
                $image1_extension = strtolower(pathinfo($image1, PATHINFO_EXTENSION));

                if (in_array($image1_extension, $allowed_extensions)) {
                    move_uploaded_file($image1_tmp, "../uploads/img/$image1");

                    $query = "INSERT INTO products_data (name, description, price, old_price, category_name, image) 
                            VALUES ('$name', '$description', '$price', '$old_price', '$category_name', '$image1')";
                    mysqli_query($conn, $query);
                    showAlerts("Added Successfully", null, "?do=products");
                } else {
                    showAlerts("Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.", null, "?do=Add");
                }
            }
        }
            elseif ($do == 'Edit') {
                // Edit Product
                $product_id = $_GET['product_id'];
                $query = "SELECT * FROM products_data WHERE id = '$product_id'";
                $result = mysqli_query($conn, $query);
                $product = mysqli_fetch_assoc($result);
                
                if ($product) { ?>
                    <div class="container mt-4">
                        <h2>Edit Product</h2>
                        <form action="?do=Update&product_id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control bg-secondary" id="name" name="name" value="<?php echo $product['name']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control bg-secondary" id="description" name="description" required><?php echo $product['description']; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control bg-secondary" id="price" name="price" value="<?php echo $product['price']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="old_price" class="form-label">Old Price</label>
                                <input type="number" class="form-control bg-secondary" id="old_price" name="old_price" value="<?php echo $product['old_price']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select bg-secondary" id="category" name="category" required>
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
                                <label for="image1" class="form-label">Image 1</label>
                                <input type="file" class="form-control bg-secondary" id="image1" name="image1">
                                <!-- Show the current image if it exists -->
                                <?php if (!empty($product['image']) && file_exists("../uploads/img/" . $product['image'])): ?>
                                    <div>
                                        <p>Current Image: <img src="../uploads/img/<?php echo $product['image']; ?>" width="100" height="100" alt="Current Image"></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex justify-content-center mb-3">
                                <button type="submit" class="btn btn-warning m-3">Update Product</button>
                            </div>
                        </form>
                    </div>
                <?php } else {
                    echo "Product Not Found";
                }
        }
        elseif($do = 'update') {  
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $old_price = $_POST['old_price'];
                $category_name = $_POST['category'];

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
                            description = '$description', 
                            price = '$price', 
                            old_price = '$old_price', 
                            category_name = '$category_name' 
                            $image1_sql 
                            WHERE id = '{$_GET['product_id']}'";
                mysqli_query($conn, $query);
                showAlerts("Updated Successfully", null, "?do=products");
            }
        }
        elseif  ($do = 'Delete') {
            deleteProduct($_GET['product_id']);
        }
        ?>
    </div>
</div>


<?php require_once '../assets/footer.php'; ?>
