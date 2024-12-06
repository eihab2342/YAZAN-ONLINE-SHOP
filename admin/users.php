<?php
session_start();
require '../assets/header.php';
require '../config/connection.php';
require '../config/functions.php';
?>
<title><?php $pageTitle = 'Admin| ';
        echo getTitle($pageTitle) ?></title>

<?php // if (isset($_SESSION['userName']) && isset($_SESSION['userID'])) {
?>

<div class="container-fluid position-relative d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Sidebar Start -->
    <?php require_once '../assets/sideBar.php'; ?>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content w-100">
        <!-- Navbar Start -->
        <?php require_once '../assets/navBar.php'; ?>

        <?php
        $do = isset($_GET['do']) ? $_GET['do'] : 'Admins';
        if ($do == 'Admins') {
            $sql = "SELECT * FROM users_data WHERE role='admin' ";
            $result = mysqli_query($conn, $sql);
        ?>

            <h2 class="m-3 text-dark">- Total Admins: <?php echo countItems('role', 'users_data', 'admin'); ?></h2>
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
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo    '<td>' . $row['userID'] . '</td>';

                            // تحقق من وجود الصورة قبل عرضها
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
</div>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to Delete this Admin?");
    }
</script>


<?php }
        // Other actions (delete, insert, edit) will follow the same approach with adjustments for mobile responsiveness.
        //Delete start
        elseif ($do == 'delete') {
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
        }

        //Delete End

        //Add Admin Start 
        elseif ($do == 'Add') {
?>
    <section class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container">
            <div class="card border-light-subtle shadow-sm mx-auto bg-light text-dark" style="max-width: 600px;">
                <div class="card-body p-2">
                    <div class="card-body p-2 p-md-3 p-xl-4">
                        <div class="row">
                            <form action="?do=insert" method="POST">
                                <h3 class="d-flex justify-content-center align-items-center">Add Admin</h3>
                                <div class="mb-3 mt-1">
                                    <input type="hidden" name="userID">
                                    <label for="Name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control bg-white" id="Name" placeholder="Enter Name" name="name" required="required">
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="User Name" class="form-label">User Name</label>
                                    <input type="text" class="form-control bg-white" id="User Name" placeholder="Enter User Name" name="username" required="required">
                                </div>
                                <div class="mb-3 mt-2">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" class="form-control bg-white" id="email" placeholder="Enter email" name="email" required="required">
                                </div>
                                <div class="mt-2">
                                    <label for="pwd" class="form-label">Password:</label>
                                    <input type="hidden" class="form-control" name="groubID">
                                    <input type="password" class="form-control bg-white" name="password" placeholder="Enter Password" required="required">
                                </div>
                                <button type="submit" class="btn btn-dark mt-3" name="submit" style="margin-left:215px;">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>


    <?php }
        //Add Admin End

        //Insert Admin start
        elseif ($do == 'insert') {

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
                $name = $_POST['name'];
                $userName = $_POST['username'];
                $email = $_POST['email'];
                $pass = $_POST['password'];

                // Add($name, $username, $email, $pass, 'admin');

                // if (!empty($name) && !empty($userName) && !empty($email) && !empty($pass)) {
                //     if (minLen($name, 10) && minLen($userName, 4)) {
                //         if (SanString($email) && sanEmail($email)) {
                //             if (minLen($pass, 8) && maxLen($pass, 25)) {
                //                 $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                //                 //check if admin is exist

                //                 // $check = checkItem("userName", "users", $userName);
                //                 if(checkItem("email", "users", $email) && checkItem("userName", "users", $userName) == 1) {
                //                     showAlerts(null, "Username or email is already exist. ", "?do=Add");
                //                 } else {
                //                         //insert admin in database
                //                         $sql = "INSERT INTO users (fullName, userName, email, password, role, Created_at) VALUES ('$name', '$userName', '$email', '$hashed_pass' , 'admin', Now())";
                //                         $result = mysqli_query($conn, $sql);

                //                         if ($result) {
                //                             showAlerts("Admin Added successfully!", null, "?do=Manage");
                //                             // showAlerts("Admin Added successfully!", null, "?do=Manage");
                //                         } else {
                //                             showAlerts(null, "Error Adding Admin: " . mysqli_error($conn), "?do=Add");
                //                         }
                //                     }
                //                     } else {
                //                     showAlerts(null, "Enter a Valid Email" , "?do=Add");
                //                         // redirect(null, "Error , Enter valied Email", "?do=Add");
                //                     }
                //                 } else {
                //                     showAlerts(null, "Enter valid Email", "?do=Add");
                //                 }
                //             } else {
                //                 showAlerts(null, "Enter valied Data ,maybe name or Username is short", "?do=Add");
                //             }
                //     }*/


                //     }
            }
            //Insert Admin End

            // Add User start
            elseif ($do == 'AddUser') {
                echo ' 
                        <div class="container-fluid position-relative d-flex p-0">
                        <section class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
                            <div class="container">
                                <div class="card border-light shadow-sm" style="max-width: 600px; width: 100%;">
                                    <div class="card-body p-3">
                                        <h3 class="text-center">Add New User</h3>
                                        <form action="?do=insertuser" method="POST">
                                            <input type="hidden" name="userID">
                                            <div class="mb-3">
                                                <label for="Name" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="Name" placeholder="Enter Name" name="name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="UserName" class="form-label">User Name</label>
                                                <input type="text" class="form-control" id="UserName" placeholder="Enter User Name" name="userName" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email:</label>
                                                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pwd" class="form-label">Password:</label>
                                                <input type="hidden" class="form-control" name="groupID">
                                                <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                                            </div>
                                            <button type="submit" class="btn btn-dark mt-3" name="submit">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </section>
                        </div>
                        ';
                // <?php 
                // Add User End

                // Insert User 
                // } elseif ($do == 'insertuser') {
                //     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
                //         $name = $_POST['name'];
                //         $userName = $_POST['userName'];
                //         $email = $_POST['email'];
                //         $pass = $_POST['password'];

                //         Add($name, $userName, $email, $pass, 'user');
                //         //     showAlerts("User Added Successfully!", null , "./total_users.php");
                //         // } 
                //         // else {
                //         //     showAlerts(null, "Error Sdding User", "?do=AddUser");
                //         // }

                //     } else {
                //         showAlerts(null, "You cannot reach this page", null);
                //     }

                // }

                // Edit Start
            } elseif ($do == 'Edit') {
                $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? $_GET['userID'] : 0;
                $sql = "SELECT * FROM users_data WHERE userID = '$userID'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $count = mysqli_num_rows($result);

                if ($count > 0) {
    ?>
            <section class="d-flex justify-content-center align-items-center min-vh-100 mt-5">
                <div class="container">
                    <div class="card border-light-subtle shadow-sm mx-auto" style="max-width: 600px;">
                        <div class="card-body p-4">
                            <form action="?do=update" method="POST">
                                <h3 class="text-center">Edit <?php echo $row['role'] ?></h3>
                                <div class="mb-3">
                                    <input type="hidden" name="userID" value='<?php echo $row['userID'] ?>'>
                                    <label for="Name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="Name" placeholder="Enter Name" name="name" value="<?php echo $row['full_name'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="User Name" class="form-label">User Name</label>
                                    <input type="text" class="form-control" id="User Name" placeholder="Enter User Name" name="userName" value="<?php echo $row['username'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $row['email'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="pwd" class="form-label">Password</label>
                                    <input type="hidden" class="form-control" name="oldpassword" value="<?php echo $row['password'] ?>">
                                    <input type="password" class="form-control" name="newpassword" placeholder="Enter New Password">
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-dark mt-3" name="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            </div>
        <?php
                } else {
                    showAlerts("No ID such that", null, "index.php");
                }

        ?>

        <!-- </div> -->

    <?php
                // Update Start
            } elseif ($do == 'update') {

                echo '<h3 class="text-center">Edit</h3>';

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $userID = $_POST['userID'];
                    $fullName = $_POST['name'];
                    $userName = $_POST['userName'];
                    $email = $_POST['email'];
                    $hashed_pass = '';

                    $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : $_POST['newpassword'];

                    if (minLen($pass, 7) && maxLen($pass, 25)) {
                        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                    }

                    $result = mysqli_query($conn, "UPDATE users_data SET full_name = '$fullName', username = '$username', email = '$email', password = '$hashed_pass' WHERE userID = '$userID' ");

                    if ($result) {
                        showAlerts(" Updated Successfully", null, "index.php");
                        // echo '<a class="btn btn-success btn-lg w-10 m-3" href="dashboard.php">Back</a>';
                    } else {
                        showAlerts(null, "Error updating", null);
                    }
                } else {
                    showAlerts("Something went wrong! Maybe you cannot reach this page.");
                }
            }
            // Update End
    ?>

    </div>
<?php
        }
        //else {
        //     showAlerts(null, "Login First! ", "../users/login.php");
        // }
?>

<!-- JavaScript Libraries -->
<?php
require '../assets/footer.php';
// } else {
//     showAlerts(null, "تم انتهاء مدة صلاحية تسجيل الدخول..برجاء تسجيل الدخول أولا ", "../login.php");
// }
?>