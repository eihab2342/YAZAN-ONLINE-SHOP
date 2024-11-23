<?php 
    session_start();

        if (!isset($_SERVER['HTTP_REFERER']) || parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != $_SERVER['HTTP_HOST']) {
        showAlerts(null, "You cannot reach this page directly", "dashboard.php");
        exit();
    }
    
    
    if(isset($_SESSION['userName'])) {

        // $noNavbar = '';
        // $AnavBar = '';
        require './connection.php';
        require './assets/header.php';
        require './assets/sideBar.php';
        require './assets/navBar.php';
        


        $do = '';
        if(isset($_GET['do'])) {
            $do = $_GET['do'];
        } else {
            $do = 'Manage';
        }

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ; 
        
            if($do == 'Manage'){
                // echo "Category Page";
                // echo '<a href="?do=Add"> Add new category +</a>';
                $sql = "SELECT * FROM categories_data";
                $result = mysqli_query($conn, $sql);
        ?>
    

<div class="container mt-4 py-5">
        <nav aria-label="breadcrumb" class=" container mt-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item "><a href="category.php">Total Categories</a></li>
            </ol>
        </nav>

        <div class="container">
            <a href="?do=Add" class="btn btn-primary m-1 float-end">Add New Category</a>
        </div>

    <h2 class="mb-3">- All Categories</h2><hr>
    <table class="table">
        <thead>
            <tr class="rounded">
                <!-- <th>#ID</th> -->
                <th class="bg-secondary text-white ">Category Name</th>
                <!-- <th>User Name</th> -->
                <!-- <th>Email</th> -->
                <!-- <th>Registered Date</th> -->
                <th class="bg-secondary text-white ">Control</th> 
            </tr>
        </thead>
        <tbody>
<?php
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                            echo '<td>' . $row['category_name'] . '</td>';
                            // echo '<td>' . $row['fullName'] . '</td>';
                            // echo '<td>' . $row['userName'] . '</td>';
                            // echo  '<td>' . $row['email'] . '</td>';
                            // echo'<td>' . $row['RegisteredDate'] . '</td>';
                            echo '<td>';
                            echo '<a href="./category.php?do=Edit&categoryID=' . $row['category_id'] . '" class="btn btn-success">Edit</a>';
                                
                                if($row['visibility'] == 1){echo '<span class="badge badge-pill badge-warning">Hidden</span>';}
                            echo '<a href="./category.php?do=delete&categoryID=' . $row['category_id'] . '" class="btn btn-danger" onclick="return confirmDelete()">Delete</a>';
                            echo '</td>';
                        echo '</tr>';
                }
            ?>
    </table>
    <div class="container" style="margin-bottom: 15px;">
        <a href="?do=Add" class="btn btn-primary mt-3">Add New Category</a>
    </div>
</div>



<?php
    } elseif($do == 'Add') {
?>
        <nav aria-label="breadcrumb" class=" container mt-5 pt-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item "><a href="?do=Manage">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="?do=Add">Add Category</a></li>
            </ol>
        </nav>

            <div class="container mt-4">
                <h1 class="text-center mb-4">Add New Category</h1>
                <form method="POST" action="?do=Insert">
                    <!-- Name Field -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="category_name" placeholder="Name Of The Category" >
                        </div>
                    </div>

                    <!-- Description Field -->
                    <div class="form-group row">
                        <label for="description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="description" placeholder="Describe The Category">
                        </div>
                    </div>

                    <!-- Ordering Field -->
                    <div class="form-group row">
                        <label for="ordering" class="col-sm-2 col-form-label">Ordering</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="ordering" placeholder="Number To Arrange The Categories">
                        </div>
                    </div>

                    <!-- Visible Field -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Visible</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="visibility" id="vis-yes" value="1" checked>
                                <label class="form-check-label" for="vis-yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="visibility" id="vis-no" value="0">
                                <label class="form-check-label" for="vis-no">No</label>
                            </div>
                        </div>
                    </div>

                    <!-- Allow Commenting Field -->
                    <!-- <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Allow Commenting</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="commenting" id="comm-yes" value="1" checked>
                                <label class="form-check-label" for="comm-yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="commenting" id="comm-no" value="0">
                                <label class="form-check-label" for="comm-no">No</label>
                            </div>
                        </div>
                    </div> -->

                    <!-- Allow Ads Field -->
                    <!-- <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Allow Ads</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ads" id="ads-yes" value="1" checked>
                                <label class="form-check-label" for="ads-yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ads" id="ads-no" value="0">
                                <label class="form-check-label" for="ads-no">No</label>
                            </div>
                        </div>
                    </div> -->

                    <!-- Submit Button -->
                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </div>
                </form>
            </div>




<?php
                        // $result = mysqli_query($conn, $query);
                        
                        // if ($result) {
            
} elseif($do == 'Insert') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "<h1 class='text-center'> Insert Category </h1>";
        echo '<div class="container">';

        $cat_name    = $_POST['category_name'];
        $description = $_POST['description'];
        $ordering    = $_POST['ordering'];
        $visibility  = $_POST['visibility']; 
        if (!empty($cat_name)) {
            if (checkItem('category_name', 'categories_data', $cat_name)) {
                showAlerts(null, "Category is already exist! " . $cat_name , "?do=Add");
            } else {

                if ($visibility === 'yes') {
                    $visibility = '0'; // مخفية
                } elseif ($visibility === 'no') {
                    $visibility = '1'; // ظاهرة
                } else {
                    $visibility = '1'; // default
                }

                $query = "INSERT INTO categories_data (category_name, category_description, catehory_ordering, visibility) 
                          VALUES ('$cat_name', '$description', '$ordering', '$visibility')";
                
                $result = mysqli_query($conn, $query);
                
                if ($result) {
                    showAlerts("Category Added Successfully.", null, "category.php");
                } else {
                    showAlerts(null, "Failed to add category.", "?do=Add");
                }
            }
        } else {
            // عرض رسالة إذا كان اسم الفئة فارغًا
            showAlerts(null, "Category Name cannot be Empty.", "?do=Add");
        }
    }
}

        elseif($do == 'Edit') {
            echo "hello!"; 
            
            $category_id = isset($_GET['categoryID']) && is_numeric($_GET['categoryID']) ? $_GET['categoryID'] : 0;

            $sql = "SELECT * FROM categories WHERE category_ID = '$category_id' ";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $count = mysqli_num_rows($result);

            if($count > 0) { ?>

            <div class="container mt-4">
                <nav aria-label="breadcrumb" class=" container mt-5">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="category.php">Total Categories</a></li>
                        <li class="breadcrumb-item active"><a href="dashboard.php">Edit Category</a></li>
                        <!-- <li class="breadcrumb-item active" aria-current="page"><a href="?do=Add">Add User</a></li> -->
                    </ol>
                </nav>

                <h1 class="text-center mb-4">Edit Category</h1>
                <form method="POST" action="?do=update">
                    <!-- Name Field -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="category_name" value="<?php echo $row['category_name'] ?>">
                        </div>
                    </div>

                    <!-- Description Field -->
                    <div class="form-group row">
                        <label for="description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="description"  value="<?php echo $row['category_description']?>">
                        </div>
                    </div>

                    <!-- Ordering Field -->
                    <div class="form-group row">
                        <label for="ordering" class="col-sm-2 col-form-label">Ordering</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="ordering" value="<?php echo $row['catehory_ordering'] ?>">
                        </div>
                    </div>

                    <!-- Visible Field -->
                    <!-- Visible Field -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Visible</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="visibility" value="<?php echo $row['visibility'] ?>" >
                                <label class="form-check-label" for="vis-yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="visibility" value="<?php echo $row['visibility'] ?>">
                                <label class="form-check-label" for="vis-no">No</label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="Update" class="btn btn-primary" name="update">Update Category</button>
                        </div>
                    </div>
                </form>
            </div>


<?php 

    }


            
        }

        elseif($do == 'update') {
            showAlerts("Updated Successfully." ,null, "?do=Manage");
        }

        elseif($do == 'delete') {
            echo "<h1 class='text-center'> Delete User </h1>";
            $category_id = $_GET['categoryID'];
            $sql = "SELECT * FROM categories WHERE category_id = $category_id";
            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);

            if($count > 0) {
                $result = mysqli_query($conn, "DELETE FROM categories WHERE category_id = '$category_id'");
                if($result){ //returned True
                    showAlerts("Category Deleted Successfully.", null, "?do=Manage");
                }
            } else {
                showAlerts(null, "No Category Like That! ", "");
            }

        }





    require './assets/footer.php';
    }