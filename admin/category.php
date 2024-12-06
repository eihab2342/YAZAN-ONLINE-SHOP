<?php
session_start();
require '../assets/header.php';
require '../config/connection.php';
require '../config/functions.php';
//  عنوان الصفحة
$pageTitle = 'Admin| Category';
?>

<title><?php echo getTitle($pageTitle); ?></title>
<div class="container-fluid position-relative d-flex p-0">
    <!-- Spinner Start -->
    <!-- Spinner End -->

    <!-- Sidebar Start -->
    <?php require '../assets/sideBar.php' ?>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content" style="background-color: whitesmoke;">
        <!-- Navbar Start -->
        <?php require '../assets/navBar.php' ?>
        <!-- Navbar End -->

        <?php
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if ($do == 'Manage') {
            $sql = "SELECT * FROM categories_data";
            $result = mysqli_query($conn, $sql);
        ?>
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="category.php">Total Categories</a></li>
                    </ol>
                </nav>

                <div class="container">
                    <a href="?do=Add" class="btn btn-primary m-1 float-end">Add New Category</a>
                </div>

                <h2 class="mb-3 text-dark">- All Categories</h2>
                <hr>
                <table class="table">
                    <thead>
                        <tr class="rounded">
                            <th class="bg-secondary text-white">Category Name</th>
                            <th class="bg-secondary text-white">Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td class="text-dark"><?php echo $row['category_name']; ?></td>
                                <td>
                                    <a href="category.php?do=Edit&categoryID=<?php echo $row['category_id']; ?>" class="btn btn-success">Edit</a>
                                    <?php if ($row['visibility'] == 1) { ?>
                                        <span class="badge badge-pill badge-warning">Hidden</span>
                                    <?php } ?>
                                    <a href="?do=delete&categoryID=<?php echo $row['category_id']; ?>" class="btn btn-danger" onclick="return confirmDelete()">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="container" style="margin-bottom: 15px;">
                    <a href="?do=Add" class="btn btn-primary mt-3">Add New Category</a>
                </div>
            </div>
        <?php
        } elseif ($do == 'Add') {
        ?>
            <div class="container mt-4">
                <h1 class="text-center mb-4 text-dark">Add Category</h1>
                <form method="POST" action="?do=Insert" enctype="multipart/form-data">
                    <!-- Field: Category Name -->
                    <div class="form-group row m-2">
                        <label for="name" class="col-sm-2 col-form-label">Name/الإسم</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control bg-white text-dark" name="category_name" id="name" required>
                        </div>
                    </div>

                    <!-- Field: Description -->
                    <div class="form-group row m-2">
                        <label for="description" class="col-sm-2 col-form-label">Description/الوصف</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control bg-white text-dark" name="description" id="description">
                        </div>
                    </div>

                    <!-- Field: Ordering -->
                    <div class="form-group row m-2">
                        <label for="ordering" class="col-sm-2 col-form-label">Ordering/الطلب علي الفئة</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control bg-white text-dark" name="ordering" id="ordering">
                        </div>
                    </div>

                    <!-- Field: Visibility -->
                    <div class="form-group row m-2">
                        <label class="col-sm-2 col-form-label">Visible/امكانية الوصول</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="visibility" id="vis-yes" value="1">
                                <label class="form-check-label" for="vis-yes">مخفي</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="visibility" id="vis-no" value="0">
                                <label class="form-check-label" for="vis-no">ظاهر</label>
                            </div>
                        </div>
                    </div>

                    <!-- Field: Image Upload -->
                    <div class="form-group row m-2">
                        <label for="image" class="col-sm-2 col-form-label">Image 120*120 </label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control bg-white text-dark" id="image" name="image">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group row my-3">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </div>
                </form>
                <p>الصورة يجب ان تكون 120*120 فقط ولا يقبل غير ذلك**</p>
            </div>
            <?php
        } elseif ($do == 'Insert') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $cat_name = mysqli_real_escape_string($conn, $_POST['category_name']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $ordering = $_POST['ordering'];
                $visibility = $_POST['visibility'];

                // التحقق من وجود صورة
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $image = $_FILES['image'];
                    $imagePath = $image['tmp_name'];

                    // الحصول على أبعاد الصورة
                    $imageSize = getimagesize($imagePath);
                    if ($imageSize) {
                        $imageWidth = $imageSize[0];
                        $imageHeight = $imageSize[1];

                        // التحقق من أن الأبعاد 80x80
                        if ($imageWidth == 120 && $imageHeight == 120) {
                            // رفع الصورة
                            $imageName = uniqid() . '-' . $image['name'];
                            $uploadDir = '../uploads/img/';
                            $uploadPath = $uploadDir . $imageName;

                            if (move_uploaded_file($imagePath, $uploadPath)) {
                                // حفظ البيانات في قاعدة البيانات
                                if (!empty($cat_name)) {
                                    if (checkItem('category_name', 'categories_data', $cat_name)) {
                                        showAlerts(null, "Category '$cat_name' already exists.", "?do=Add");
                                    } else {
                                        $query = "INSERT INTO categories_data (category_name, category_description, category_ordering, visibility, image) 
                                                            VALUES ('$cat_name', '$description', '$ordering', '$visibility', '$imageName')";
                                        $result = mysqli_query($conn, $query);

                                        if ($result) {
                                            showAlerts("Category Added Successfully.", null, "category.php");
                                        } else {
                                            showAlerts(null, "Failed to add category.", "?do=Add");
                                        }
                                    }
                                } else {
                                    showAlerts(null, "Category Name cannot be Empty.", "?do=Add");
                                }
                            } else {
                                showAlerts(null, "Failed to upload image.", "?do=Add");
                            }
                        } else {
                            showAlerts(null, "Image dimensions must be 120*120 pixels.", "?do=Add");
                        }
                    } else {
                        showAlerts(null, "Invalid image file.", "?do=Add");
                    }
                } else {
                    showAlerts(null, "Please upload an image.", "?do=Add");
                }
            }
        } elseif ($do == 'Edit') {
            $category_id = isset($_GET['categoryID']) && is_numeric($_GET['categoryID']) ? $_GET['categoryID'] : 0;
            $sql = "SELECT * FROM categories_data WHERE category_id = '$category_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $count = mysqli_num_rows($result);

            if ($count > 0) {
            ?>
                <div class="container mt-4">
                    <h1 class="text-center mb-4 text-dark">Edit Category</h1>
                    <form method="POST" action="?do=update&categoryID=<?php echo $category_id; ?>" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name/اسم</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control bg-white text-dark" name="category_name" value="<?php echo $row['category_name']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-2 col-form-label">Description/وصف</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control  bg-white text-dark" name="description" value="<?php echo $row['category_description']; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ordering" class="col-sm-2 col-form-label">Ordering/ طلب الفئة</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control  bg-white text-dark" name="ordering" value="<?php echo $row['category_ordering']; ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Visible/مخفي0 - ظاهر1</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input  bg-white text-dark" type="radio" name="visibility" value="1" <?php echo $row['visibility'] == 1 ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="vis-yes">مخفي</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input  bg-white text-dark" type="radio" name="visibility" value="0" <?php echo $row['visibility'] == 0 ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="vis-no">ظاهر</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-check form-check-inline">
                            <label for="file" class="form-label">صورة بحجم 120*120 فقط/image</label>
                            <input type="file" class="form-control  bg-white text-dark" id="image" name="image">
                            <!-- Show the current image if it exists -->
                            <?php if (!empty($row['image']) && file_exists("../uploads/img/" . $row['image'])): ?>
                                <div>
                                    <p class="m-2">Current Image: <img src="../uploads/img/<?php echo htmlspecialchars($row['image']); ?>" width="100" height="100" alt="Current Image"></p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary">Update Category</button>
                            </div>
                        </div>
                    </form>
                </div>
        <?php
            }
        } elseif ($do == 'update') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // استلام البيانات من النموذج
                $category_name = $_POST['category_name'];
                $description = $_POST['description'];
                $ordering = $_POST['ordering'];
                $visibility = $_POST['visibility'];
                $category_id = $_GET['categoryID'];

                // معالجة الصورة
                $image_name = $_FILES['image']['name'];
                $image_tmp = $_FILES['image']['tmp_name'];
                $upload_folder = "../uploads/img/";

                // إذا تم رفع صورة جديدة
                if (!empty($image_name)) {
                    $image_path = $upload_folder . basename($image_name);

                    // رفع الصورة
                    if (move_uploaded_file($image_tmp, $image_path)) {
                        // حذف الصورة القديمة إذا كانت موجودة
                        $sql_get_image = "SELECT image FROM categories_data WHERE category_id = $category_id";
                        $result_get_image = mysqli_query($conn, $sql_get_image);
                        if ($result_get_image && mysqli_num_rows($result_get_image) > 0) {
                            $row = mysqli_fetch_assoc($result_get_image);
                            if (!empty($row['image']) && file_exists($upload_folder . $row['image'])) {
                                unlink($upload_folder . $row['image']);
                            }
                        }

                        // تحديث البيانات مع الصورة الجديدة
                        $sql = "UPDATE categories_data 
                                    SET category_name = '$category_name', 
                                        category_description = '$description', 
                                        category_ordering = '$ordering', 
                                        visibility = '$visibility', 
                                        image = '$image_name' 
                                    WHERE category_id = $category_id";
                    } else {
                        showAlerts(null, "Error uploading the image.", "?do=Edit&categoryID=" . $category_id);
                        exit;
                    }
                } else {
                    // تحديث البيانات بدون صورة
                    $sql = "UPDATE categories_data 
                                SET category_name = '$category_name', 
                                    category_description = '$description', 
                                    category_ordering = '$ordering', 
                                    visibility = '$visibility' 
                                WHERE category_id = $category_id";
                }

                // تنفيذ الاستعلام
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    showAlerts("Category Updated Successfully.", null, "category.php");
                } else {
                    showAlerts(null, "Error updating the category.", "?do=Edit&categoryID=" . $category_id);
                }
            }
        }


        // } elseif ($do == 'update') {
        //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //         $category_name = $_POST['category_name'];
        //         $description = $_POST['description'];
        //         $ordering = $_POST['ordering'];
        //         $visibility = $_POST['visibility'];
        //         $category_id = $_GET['categoryID'];

        //         // معالجة الصورة
        //         $image_name = $_FILES['image']['name'];
        //         $image_tmp = $_FILES['image']['tmp_name'];
        //         $upload_folder = "../uploads/img/";

        //         // إذا تم رفع صورة جديدة
        //         if (!empty($image_name)) {
        //             $image_path = $upload_folder . basename($image_name);

        //             // رفع الصورة
        //             if (move_uploaded_file($image_tmp, $image_path)) {
        //                 // حذف الصورة القديمة إذا كانت موجودة
        //                 $sql_get_image = "SELECT image FROM categories_data WHERE category_id = ?";
        //                 $stmt_get_image = mysqli_prepare($conn, $sql_get_image);
        //                 mysqli_stmt_bind_param($stmt_get_image, "i", $category_id);
        //                 mysqli_stmt_execute($stmt_get_image);
        //                 $result_get_image = mysqli_stmt_get_result($stmt_get_image);

        //                 if ($result_get_image && mysqli_num_rows($result_get_image) > 0) {
        //                     $row = mysqli_fetch_assoc($result_get_image);
        //                     if (!empty($row['image']) && file_exists($upload_folder . $row['image'])) {
        //                         unlink($upload_folder . $row['image']);
        //                     }
        //                 }

        //                 // تحديث البيانات مع الصورة
        //                 $sql = "UPDATE categories_data 
        //                         SET category_name = ?, 
        //                             category_description = ?, 
        //                             category_ordering = ?, 
        //                             visibility = ?, 
        //                             image = ? 
        //                         WHERE category_id = ?";
        //                 $stmt = mysqli_prepare($conn, $sql);
        //                 mysqli_stmt_bind_param($stmt, "ssiiisi", $category_name, $description, $ordering, $visibility, $image_name, $category_id);
        //             } else {
        //                 showAlerts(null, "Error uploading the image.", "?do=Edit&categoryID=" . $category_id);
        //                 exit;
        //             }
        //         } else {
        //             // تحديث البيانات بدون صورة
        //             $sql = "UPDATE categories_data 
        //                     SET category_name = ?, 
        //                         category_description = ?, 
        //                         category_ordering = ?, 
        //                         visibility = ? 
        //                     WHERE category_id = ?";
        //             $stmt = mysqli_prepare($conn, $sql);
        //             mysqli_stmt_bind_param($stmt, "ssiii", $category_name, $description, $ordering, $visibility, $category_id);
        //         }

        //         // تنفيذ الاستعلام
        //         if (mysqli_stmt_execute($stmt)) {
        //             showAlerts("Category Updated Successfully.", null, "category.php");
        //         } else {
        //             showAlerts(null, "Error updating the category.", "?do=Edit&categoryID=" . $category_id);
        //         }

        //         // إغلاق الاستعلامات
        //         mysqli_stmt_close($stmt);
        //         mysqli_stmt_close($stmt_get_image);
        //     }
        // }

        elseif ($do == 'delete') {
            $category_id = isset($_GET['categoryID']) && is_numeric($_GET['categoryID']) ? $_GET['categoryID'] : 0;

            $sql = "SELECT * FROM categories_data WHERE category_id = '$category_id'";
            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);

            if ($count > 0) {
                $sqlDelete = "DELETE FROM categories_data WHERE category_id = '$category_id'";
                $deleteResult = mysqli_query($conn, $sqlDelete);

                if ($deleteResult) {
                    showAlerts("Category Deleted Successfully.", null, "category.php");
                } else {
                    showAlerts(null, "Failed to delete category.", "category.php");
                }
            } else {
                showAlerts(null, "Category not found.", "category.php");
            }
        }

        ?>


    </div>
</div>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this category?");
    }
</script>
<?php require_once '../assets/footer.php'; ?>