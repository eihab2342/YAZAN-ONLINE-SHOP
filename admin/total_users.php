<?php
session_start();
require '../assets/header.php';
require '../config/connection.php';
require '../config/functions.php';

?>

<title><?php $pageTitle = 'Admin| Total Users';
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
    <div class="content">
        <!-- Navbar Start -->
        <?php require_once '../assets/navBar.php'; ?>
        <!-- Navbar End -->

        <!--Get total users  (groupID = 0) from database Except Admins  (groupID = 1) -->
        <?php
        $sql = "SELECT * FROM users_data WHERE role = 'user' ";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="container">
            <!-- <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="total_users.php">Total Users</a></li>
                        </ol>
                    </nav> -->

            <form class="m-4" action="search.php" method="GET">
                <label for="query" class="mb-2">Search about Users</label>
                <input class="form-control border-0 m-2 bg-secondary text-white" type="search" placeholder="Search">
                <button type="submit" class="btn-info btn mx-3 float-end">Search</button>
            </form>

            <!-- <div class="mb-3">
                        <a href="users.php?do=Add" class="btn btn-primary float-end">Add New User</a>
                    </div> -->

            <h2 class="mb-4 bg-white text-dark">Total Users: <?php echo countItems('role', 'users_data', 'user'); ?></h2>

            <hr>
            <div class="table-responsive">
                <!-- <table class="table table-striped"> -->
                <table class="table mx-2">
                    <!-- <thead class="bg-dark text-white"> -->
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Full Name</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Registered Date</th>
                            <th>Control</th> <!-- Edit & Delete -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row['userID'] . '</td>';
                            echo '<td>' . $row['full_name'] . '</td>';
                            echo '<td>' . $row['username'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '<td>' . $row['created_at'] . '</td>';
                            echo '<td>
                                        <a href="./users.php?do=Edit&userID=' . $row['userID'] . '" class="btn btn-success btn-sm">Edit</a>
                                        <a href="./users.php?do=delete&userID=' . $row['userID'] . '" class="btn btn-danger btn-sm" onclick="return confirmDelete()">Delete</a>
                                        <a href="./user_Detales.php?userID=' . $row['userID'] . ' " class="btn btn-info btn-sm" >Detailes</a>
                                    </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="mb-3">
                <a href="./users.php?do=AddUser" class="btn btn-primary">Add New User</a>
            </div>
        </div>
    </div>
</div>

<!-- js code to show confirm msg on delete -->
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to Delete this Admin");
    }
</script>
<!-- js code to show confirm msg on delete -->

<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>
<?php
require '../assets/footer.php';
// } else {
//     showAlerts(null, "تم انتهاء مدة صلاحية تسجيل الدخول..برجاء تسجيل الدخول أولا ", "../login.php");
// }
?>