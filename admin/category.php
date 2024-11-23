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
    <div class="content">
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

                <h2 class="mb-3">- All Categories</h2><hr>
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
                                <td><?php echo $row['category_name']; ?></td>
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
                            <h1 class="text-center mb-4">Add Category</h1>
                            <form method="POST" action="?do=Insert">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control bg-secondary" name="category_name" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control bg-secondary" name="description">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="ordering" class="col-sm-2 col-form-label">Ordering</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control bg-secondary" name="ordering">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Visible</label>
                                    <div class="col-sm-10">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input bg-secondary" type="radio" name="visibility" value="1">
                                            <label class="form-check-label" for="vis-yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input bg-secondary" type="radio" name="visibility" value="0">
                                            <label class="form-check-label" for="vis-no">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <button type="submit" class="btn btn-primary">Add Category</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                <?php
                } elseif ($do == 'Insert') {
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $cat_name = mysqli_real_escape_string($conn, $_POST['category_name']);
                        $description = mysqli_real_escape_string($conn, $_POST['description']);
                        $ordering = $_POST['ordering'];
                        $visibility = $_POST['visibility'];

                        if (!empty($cat_name)) {
                            if (checkItem('category_name', 'categories_data', $cat_name)) {
                                showAlerts(null, "Category '$cat_name' already exists.", "?do=Add");
                            } else {
                                $query = "INSERT INTO categories_data (category_name, category_description, category_ordering, visibility) 
                                        VALUES ('$cat_name', '$description', '$ordering', '$visibility')";
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
                    }
                }

                elseif ($do == 'Edit') {
                    $category_id = isset($_GET['categoryID']) && is_numeric($_GET['categoryID']) ? $_GET['categoryID'] : 0;
                    $sql = "SELECT * FROM categories_data WHERE category_id = '$category_id'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $count = mysqli_num_rows($result);

                    if ($count > 0) {
?>
        <div class="container mt-4">
            <h1 class="text-center mb-4">Edit Category</h1>
            <form method="POST" action="?do=update&categoryID=<?php echo $category_id; ?>">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control bg-secondary" name="category_name" value="<?php echo $row['category_name']; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control bg-secondary" name="description" value="<?php echo $row['category_description']; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="ordering" class="col-sm-2 col-form-label">Ordering</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control bg-secondary" name="ordering" value="<?php echo $row['category_ordering']; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Visible</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input bg-secondary" type="radio" name="visibility" value="1" <?php echo $row['visibility'] == 1 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="vis-yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input bg-secondary" type="radio" name="visibility" value="0" <?php echo $row['visibility'] == 0 ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="vis-no">No</label>
                        </div>
                    </div>
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
                }

            elseif ($do == 'update') {
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $category_name = $_POST['category_name'];
                        $description = $_POST['description'];
                        $ordering = $_POST['ordering'];
                        $visibility = $_POST['visibility'];

                        $category_id = $_GET['categoryID'];

                        $sql = "UPDATE categories_data SET category_name = '$category_name', category_description = '$description', category_ordering = '$ordering', visibility = '$visibility' WHERE category_id = $category_id";

                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            showAlerts("Category Updated Successfully.", null, "category.php");
                        } else {
                            showAlerts(null, "Error in updating the category.", "?do=Edit&categoryID=" . $category_id);
                        }
                    }
                }

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
