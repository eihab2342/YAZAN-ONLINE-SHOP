<?php
session_start();
require '../assets/header.php';
require '../config/connection.php';
require '../config/functions.php';
?>
<title><?php $pageTitle = 'Admin| '; echo getTitle($pageTitle); ?></title>

<!-- Main Content -->
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
    <div class="content w-100">
        <!-- Navbar Start -->
        <?php require_once '../assets/navBar.php'; ?>

        <?php
        // Default page action (Admins)
        $do = isset($_GET['do']) ? $_GET['do'] : 'Admins';
        if ($do == 'Admins') {
            // Query to fetch admin users
            $sql = "SELECT * FROM users_data WHERE role='admin' ";
            $result = mysqli_query($conn, $sql);
        ?>

        <h2 class="m-3">- Total Admins: <?php echo countItems('role', 'users_data', 'admin'); ?></h2>
        <p></p>
        <div class="table-responsive">
            <table class="table mx-2">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Image</th>
                        <th>Full Name</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Registered Date</th>
                        <th>Control</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Displaying admin users
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                                echo    '<td>' . $row['userID'] . '</td>';

                                // Checking if the user has an image
                                echo    '<td>';
                                    if (!empty($row['user_Image']) && file_exists("../uploads/img/" . $row['user_Image'])) {
                                        echo '<img src="../uploads/img/' . $row['user_Image'] . '" width="50" height="50" alt="User Image">';
                                    } else {
                                        echo '<p>No image available</p>';
                                    }
                                echo    '</td>';

                                echo    '<td>' . $row['full_name'] . '</td>';
                                echo    '<td>' . $row['username'] . '</td>';
                                echo    '<td>' . $row['email'] . '</td>';
                                echo    '<td>' . $row['created_at'] . '</td>';
                                echo    '<td>
                                            <a href="?do=Edit&userID=' . $row['userID'] . '" class="btn btn-success">Edit</a>
                                            <a href="?do=delete&userID=' . $row['userID'] . '" class="btn btn-danger" onclick="return confirmDelete()">Delete</a>
                                        </td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="container">
            <a href="users.php?do=Add" class="btn btn-primary float-start my-3">Add New Admin</a>
        </div>
    </div>
</div>
<!-- End Content -->

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this Admin?");
    }
</script>

<?php 
        // Delete Admin
        } elseif($do == 'delete') {
            echo "<h1 class='text-center mt-4'>Delete User</h1>";

            $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? $_GET['userID'] : 0;

            if ($userID > 0) {
                $sql = "SELECT * FROM users_data WHERE `userID` = '$userID' LIMIT 1";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $query = mysqli_query($conn, "DELETE FROM users_data WHERE `userID` = '$userID'");

                    if ($query) {
                        showAlerts("Deleted Successfully!", null, "index.php");
                    } else {
                        echo "Error in deletion!";
                    }
                } else {
                    showAlerts(null, "Not Found", "index.php");
                }
            } else {
                showAlerts(null, "Invalid User ID", "index.php");
            }
        // Add Admin Form
        } elseif ($do == 'Add') { 
        ?>
        <section class="d-flex justify-content-center align-items-center min-vh-100">
            <div class="container">
                <div class="card border-light-subtle shadow-sm mx-auto bg-secondary" style="max-width: 600px;">
                    <div class="card-body p-2">
                        <form action="?do=insert" method="POST">
                            <h3 class="d-flex justify-content-center align-items-center">Add Admin</h3>
                            <div class="mb-3 mt-1">
                                <label for="Name" class="form-label">Full Name</label>
                                <input type="text" class="form-control bg-white" id="Name" placeholder="Enter Name" name="name" required="required">
                            </div>
                            <div class="mb-3 mt-2">
                                <label for="UserName" class="form-label">User Name</label>
                                <input type="text" class="form-control bg-white" id="UserName" placeholder="Enter User Name" name="username" required="required">
                            </div>
                            <div class="mb-3 mt-2">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control bg-white" id="email" placeholder="Enter email" name="email" required="required">
                            </div>
                            <div class="mt-2">
                                <label for="pwd" class="form-label">Password:</label>
                                <input type="password" class="form-control bg-white" name="password" placeholder="Enter Password" required="required">
                            </div>
                            <button type="submit" class="btn btn-dark mt-3" name="submit" style="margin-left:215px;">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php 
        // Insert Admin
        } elseif($do == 'insert') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
                $name = $_POST['name'];
                $userName = $_POST['username'];
                $email = $_POST['email'];
                $pass = $_POST['password'];

                Add($name, $userName, $email, $pass,$image, 'admin');
            }

        } elseif($do == 'Edit') {
            if (isset($_GET['userID']) && is_numeric($_GET['userID'])) {
                $userID = $_GET['userID'];

                // استعلام لاسترجاع البيانات الخاصة بالمستخدم بناءً على الـ userID
                $sql = "SELECT * FROM users_data WHERE userID = '$userID' LIMIT 1";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                } else {
                    echo "User not found!";
                    exit;
                }
            }
            ?>
            <section class="d-flex justify-content-center align-items-center min-vh-100 mt-5">
                <div class="container">
                    <div class="card border-light-subtle shadow-sm mx-auto" style="max-width: 600px;">
                        <div class="card-body p-4">
                            <form action="?do=update" method="POST" enctype="multipart/form-data">
                                <h3 class="text-center">Edit <?php echo htmlspecialchars($row['role']); ?></h3>
                                <div class="mb-3">
                                    <input type="hidden" name="userID" value='<?php echo htmlspecialchars($row['userID']); ?>'>
                                    <label for="Name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="Name" placeholder="Enter Name" name="name" value="<?php echo htmlspecialchars($row['full_name']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="User Name" class="form-label">User Name</label>
                                    <input type="text" class="form-control" id="User Name" placeholder="Enter User Name" name="userName" value="<?php echo htmlspecialchars($row['username']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="pwd" class="form-label">Password</label>
                                    <input type="hidden" class="form-control" name="oldpassword" value="<?php echo htmlspecialchars($row['password']); ?>">
                                    <input type="password" class="form-control" name="newpassword" placeholder="Enter New Password">
                                </div>
                                
                                <!-- عرض الصورة الحالية -->
                                <div class="mb-3">
                                    <label for="Image" class="form-label">Image</label>
                                    <div>
                                        <?php if (!empty($row['user_Image'])): ?>
                                        <?php if (!empty($row['user_Image']) && file_exists("../user/images/" . $row['user_Image'])): ?>
                                            <img src="../user/images/<?php echo htmlspecialchars($row['user_Image']); ?>" alt="User Image" style="max-width: 150px; max-height: 150px;">
                                        <?php else: ?>
                                            <p>No image available.</p>
                                        <?php endif; ?>
                                        <?php else: ?>
                                            <p>No image available.</p>
                                        <?php endif; ?>
                                    </div>
                                    <input type="file" class="form-control" id="Image" name="image">
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-dark mt-3" name="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <?php 
        } else {
            showAlerts("No ID such that", null, "index.php");
        }
                            

